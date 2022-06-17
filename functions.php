<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

require_once __DIR__ . '/vendor/autoload.php';
function getContacts($token)
{
    $contacts = array();
    $username = isTokenValid($token);
    if (!$username) {
        return $contacts;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "SELECT * FROM cv_information WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result === 0 || !is_a($result, 'mysqli_result')) {
        return $contacts;
    }
    $cv_id = mysqli_fetch_assoc($result)["cv_id"];
    $sql = "SELECT * FROM contact WHERE cv_id='$cv_id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($contacts, $row);
    }

    mysqli_close($conn);
    
    return $contacts;
}
function getCVInfoPublic($filter_job = "")
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }

    $sql = "SELECT * FROM cv_information WHERE status='1'";
    $result = mysqli_query($conn, $sql);

    $infos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        if(!empty($filter_job)){
            if($row["desired_job"] == $filter_job){
                array_push($infos, $row);
            }
        }
        else{
            array_push($infos, $row);
        }
    }

    mysqli_close($conn);
    return $infos;
}
function getCVInfoPersonal($token){
    $contacts = array();
    $username = isTokenValid($token);
    if (!$username) {
        return $contacts;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "SELECT * FROM cv_information WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result === 0 || !is_a($result, 'mysqli_result')) {
        return $contacts;
    }
    $cvInfo = mysqli_fetch_assoc($result);
    return $cvInfo;
}
function getCVInfoById($id)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "SELECT * FROM cv_information WHERE cv_id='$id' and status=TRUE";
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $info;
}

function addCVInfo($token, $name, $date_of_birth, $address, $phone, $detail, $status, $desired_job, $gender)
{
    $username = isTokenValid($token);
    if (!$username) {
        return false;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "INSERT INTO cv_information(username,name,date_of_birth,address,phone,detail, status, desired_job, gender)
    VALUES ('$username', '$name', '$date_of_birth', '$address', '$phone', '$detail', '$status', '$desired_job', '$gender')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return false;
    }
    return true;
}
function updateCVInfo($token, $cv_id, $name, $date_of_birth, $address, $phone, $detail, $status, $desired_job)
{
    $username = isTokenValid($token);
    if (!$username) {
        return false;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "UPDATE cv_information 
    SET name='$name',date_of_birth='$date_of_birth',address='$address',phone='$phone',detail='$detail', status='$status', desired_job='$desired_job'
    WHERE cv_id='$cv_id'";
    if (!mysqli_query($conn, $sql)) {
        return false;
    }
    return true;
}

function isTokenValid($token)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    try {
        $jwtDecode = JWT::decode($token, new Key($secretKey, 'HS512'));
        if (!property_exists($jwtDecode, "userName")) {
            $sql = "DELETE FROM users_online WHERE token='.$token.'";
            mysqli_query($conn, $sql);
            return false;
        }
        $userName = $jwtDecode->userName;
        $sql = "SELECT * FROM users_online WHERE token='$token' AND username='$userName'";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        if (mysqli_num_rows($result) == 0) {
            return false;
        }
        return $userName;
    } catch (ExpiredException $e) {
        $sql = "DELETE FROM users_online WHERE token='.$token.'";
        mysqli_query($conn, $sql);
        return false;
    }
}

function checkUserExist($userName, $email)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    // $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    // B2. Truy van
    $sql = "SELECT * FROM users WHERE username='$userName' OR user_email='$email'";
    $result = mysqli_query($conn, $sql); //Nó trả về SỐ BẢN GHI CHÈN THÀNH CÔNG 

    // B4. Dong ket noi
    mysqli_close($conn);
    // B3. Xu ly ket qua
    if (mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}
function addContact($cv_id, $contact_name, $phone, $email, $message){
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $cvInfo = getCVInfoById($cv_id);
    if(!$cvInfo){
        return false;
    }
    $sql = "INSERT INTO contact(cv_id, contact_name, phone, email, message) VALUES ('$cv_id', '$contact_name', '$phone', '$email', '$message')";
    if(!mysqli_query($conn, $sql)){
        mysqli_close($conn);
        return false;
    }
    mysqli_close($conn);
    return true;
}
function removeContact($contact_id, $token){
    $username = isTokenValid($token);
    if (!$username) {
        return false;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if (!$conn) {
        die("Ko the ket noi");
    }
    $cvInfo = getCVInfoPersonal($token);
    if(!$cvInfo){
        return true;
    }
    $cv_id = $cvInfo["cv_id"];
    $sql = "DELETE from contact where cv_id='$cv_id' AND contact_id='$contact_id'";
    if(!mysqli_query($conn, $sql)){
        mysqli_close($conn);
        return false;
    }
    mysqli_close($conn);
    return true;
}
function addNewUser($firstName, $lastName, $userName, $email, $gender, $pass)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role, verified, gender)
          VALUES ('$firstName', '$lastName', '$userName', '$email', '$pass_hash', 'user', 'FALSE', '$gender')";
    $n = mysqli_query($conn, $sql);

    if ($n > 0) {
        return true;
    }
    return false;
}
function verifyUser($token)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $username = isTokenValid($token);
    if (!$username) {
        return false;
    }
    $sql = "UPDATE users SET verified=TRUE WHERE username='$username'";
    mysqli_query($conn, $sql);
    $sql = "DELETE from users_online where token='$token'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    return true;
}
function sendEmailForActivation($toEmail, $verifyToken)
{
    require("constant.php");
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Mailer = "smtp";
        $mail->SMTPAuth   = true;
        $mail->Port       = 587;
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'cloud179200@gmail.com';                     //SMTP username
        $mail->Password   = 'vnmvjxogdwbsjwrc';                               //SMTP password

        //Recipients
        $mail->addAddress($toEmail);     //Add a recipient
        $mail->setFrom('cloud179200@gmail.com', 'Web CV Admin');

        //Content
        $mail->isHTML(true);
        $mail->AddCC($toEmail, $toEmail);
        $mail->Subject = 'Verify your web CV account';
        $link = $host . $route["default"] . "/verify.php?token=" . $verifyToken;
        $mail->msgHTML('<a href="' . $link . '">Verify link</a>');
        if (!$mail->send()) {
            var_dump($mail);
            return false;
        }
        return true;
    } catch (Exception $e) {
        die($e);
        return false;
    }
}
function removeUser($username)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "DELETE FROM users_online WHERE username='$username'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM users WHERE username='$username'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM cv_information WHERE username='$username'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
function checkLogin($username, $pass)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "SELECT * FROM users WHERE username='$username' AND verified=TRUE";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    $pass_save = $row['user_password'];
    if (password_verify($pass, $pass_save)) {
        $token = generateAuthToken($username);
        if (empty($token)) {
            return false;
        }
        setcookie("token", $token, time() + (86400 * 7), '/');
        return true;
    }
    return false;
}
function generateAuthToken($username)
{
    if (!$username) {
        return "";
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "DELETE FROM users_online WHERE username='$username'";
    if (!mysqli_query($conn, $sql)) {
        return false;
    }
    $issuedAt = new DateTimeImmutable();
    $expired = $issuedAt->modify('+7 days')->getTimestamp();
    $serverName = "localhost";
    $data = [
        'iat'  => $issuedAt->getTimestamp(),
        'iss'  => $serverName,
        'nbf'  => $issuedAt->getTimestamp(),
        'exp'  => $expired,
        'userName' => $username,
    ];
    $token = JWT::encode(
        $data,
        $secretKey,
        'HS512'
    );
    $sql = "INSERT INTO users_online(token, expired, username) VALUES ('$token', '$expired', '$username')";
    if (!mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return false;
    }
    mysqli_close($conn);
    return $token;
}
function authorized()
{
    session_start();
    if(!isPrivateRoute()){
        return;
    }
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    if (!isset($_COOKIE["token"])) {
        logout();
        exit();
    }
    $token = $_COOKIE["token"];
    $userName = isTokenValid($token);
    if (!$userName) {
        logout();
        exit();
    }
    //get userinfo
    $sql = "SELECT * FROM users WHERE username='$userName'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        logout();
        exit(1);
    }
    $row = mysqli_fetch_assoc($result);
    $_SESSION["user_id"] = $row['user_id'];
    $_SESSION["username"] = $row['username'];
    $_SESSION["user_firstname"] = $row['user_firstname'];
    $_SESSION["user_lastname"] = $row['user_lastname'];
    $_SESSION["user_email"] = $row['user_email'];
    $_SESSION["user_role"] = $row['user_role'];
    $_SESSION["gender"] = $row['gender'];
}

function handleRoute()
{
    require("constant.php");
    if (isPrivateRoute()) {
        if (!isset($_SESSION["username"])) {
            header("location:" . $route["auth"]);
            return;
        }
        $url = $_SERVER['REQUEST_URI'];
        $userRole = $_SESSION["user_role"];
        if ($userRole == "admin" && !str_contains($url, "admin") && !str_contains($url, "public")) {
            header("location:" . $route["admin"]);
        }
        if ($userRole == "user" && !str_contains($url, "user") && !str_contains($url, "public")) {
            header("location:" . $route["user"]);
        }
    }
    if (isAuthRoute()) {
        if (isset($_SESSION["username"])) {
            $userRole = $_SESSION["user_role"];
            switch ($userRole) {
                case 'admin':
                    header("location:" . $route["admin"]);
                    break;
                case 'user':
                    header("location:" . $route["user"]);
                    break;
                default:
                    break;
            }
        }
    }
}
function isPrivateRoute()
{
    $url = $_SERVER['REQUEST_URI'];
    if (str_contains($url, "admin") || str_contains($url, "user")) {
        return true;
    }
    return false;
}
function isAuthRoute()
{
    $url = $_SERVER['REQUEST_URI'];
    return str_contains($url, "auth");
}
function logout($isVerifySuccess = false)
{
    require("constant.php");
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    //$conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $sql = "DELETE FROM users_online WHERE username='$username'";
        mysqli_query($conn, $sql);
    }
    mysqli_close($conn);
    session_unset();
    setcookie("token", "", time() - 3600, "/");
    session_destroy();
    header("location:" . $route["auth"].($isVerifySuccess ? "/login.php?success=Verify account success. You can login now ^.^": ""));
}
