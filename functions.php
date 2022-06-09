<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
require "C:\\xampp\\htdocs\\baitaplon\\vendor\\autoload.php";

// function getAllPosts(){
//     // B1. Ket noi CSDL
//     $conn = mysqli_connect('localhost','root','','baitaplon');
//     if(!$conn){
//         die("Ko the ket noi");
//     }
//     // B2. Truy van
//     $sql = "SELECT * FROM posts";
//     $result = mysqli_query($conn,$sql);

//     // B3. Xu ly ket qua
//     $posts = array();
//     while($row = mysqli_fetch_assoc($result)){
//         array_push($posts, $row);
//     }

//     // B4. Dong ket noi
//     mysqli_close($conn);
//     return $posts;
// }

// function getAllCategories(){
//     // B1. Ket noi CSDL
//     $conn = mysqli_connect('localhost','root','','baitaplon');
//     if(!$conn){
//         die("Ko the ket noi");
//     }
//     // B2. Truy van
//     $sql = "SELECT * FROM categories";
//     $result = mysqli_query($conn,$sql);

//     // B3. Xu ly ket qua
//     $categories = array();
//     while($row = mysqli_fetch_assoc($result)){
//         array_push($categories,$row);
//     }

//     // B4. Dong ket noi
//     mysqli_close($conn);
//     return $categories;
// }

// function getPostById($id){
//     // B1. Ket noi CSDL
//     $conn = mysqli_connect('localhost','root','','baitaplon');
//     if(!$conn){
//         die("Ko the ket noi");
//     }
//     // B2. Truy van
//     $sql = "SELECT * FROM posts WHERE post_id='$id'";
//     $result = mysqli_query($conn,$sql);

//     // B3. Xu ly ket qua
//     $post = mysqli_fetch_assoc($result);

//     // B4. Dong ket noi
//     mysqli_close($conn);
//     return $post;
// }

function isTokenValid($token){
    require("constant.php");
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    try{
        $jwtDecode = JWT::decode($token, new Key($secretKey, 'HS512'));
        if(!property_exists($jwtDecode, "userName")){
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
    }catch(ExpiredException $e){
        $sql = "DELETE FROM users_online WHERE token='.$token.'";
        mysqli_query($conn, $sql);
        return false;
    }
}

function checkUserExist($userName, $email)
{
    // B1. Ket noi CSDL
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
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


function addNewUser($fistName, $lastName, $userName, $email, $pass)
{
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role, verified)
          VALUES ('$fistName', '$lastName', '$userName', '$email', '$pass_hash', 'user', 'FALSE')";
    $n = mysqli_query($conn, $sql);
    
    if ($n > 0) {
        return true;
    }
    return false;
}
function verifyUser($token)
{
    require("constant.php");
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $username = isTokenValid($token);
    if(!$username){
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
        $mail->msgHTML('<a href="'.$link.'">Verify link</a>');
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
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "DELETE FROM users_online WHERE username='$username'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM users WHERE username='$username'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
function checkLogin($username, $pass)
{
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
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
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
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
    require("constant.php");
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    if (!isset($_COOKIE["token"])) {
        logout();
        exit();
    }
    $token = $_COOKIE["token"];
    $userName = isTokenValid($token);
    if(!$userName){
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
function logout()
{
    require("constant.php");
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    if (isset($_SESSION["username"])){
        $username = $_SESSION["username"];
        $sql = "DELETE * FROM users_online WHERE username='$username'";
        mysqli_query($conn, $sql);
    }
    mysqli_close($conn);
    header_remove();
    session_destroy();
    header("location:" . $route["auth"]);
}
