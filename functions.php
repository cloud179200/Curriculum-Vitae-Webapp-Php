<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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


function addNewUser($fistName, $lastName, $userName, $email, $avatar, $pass)
{
    // B1. Ket noi CSDL
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    // B2. Truy van
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_image, user_password)
          VALUES ('$fistName', '$lastName', '$userName', '$email', '$avatar', '$pass_hash')";
    $n = mysqli_query($conn, $sql); //Nó trả về SỐ BẢN GHI CHÈN THÀNH CÔNG 

    // B4. Dong ket noi
    mysqli_close($conn);
    // B3. Xu ly ket qua
    if ($n > 0) {
        return true;
    }
    return false;
}

// function sendEmailForActivation($toEmail){
//     // Đây mới chỉ là ĐIỀU KIỆN CẦN

//     // Sử dụng Gmail làm trung gian gửi nhận Email
//     $mail = new PHPMailer(true);

//     try {
//         //Server settings
//         $mail["SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//         $mail["isSMTP();                                            //Send using SMTP
//         $mail["Host       = 'smtp.example.com';                     //Set the SMTP server to send through
//         $mail["SMTPAuth   = true;                                   //Enable SMTP authentication
//         $mail["Username   = 'user@example.com';                     //SMTP username
//         $mail["Password   = 'secret';                               //SMTP password
//         $mail["SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//         $mail["Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//         //Recipients
//         $mail["setFrom('from@example.com', 'Mailer');
//         $mail["addAddress('joe@example.net', 'Joe User');     //Add a recipient
//         $mail["addAddress('ellen@example.com');               //Name is optional
//         $mail["addReplyTo('info@example.com', 'Information');
//         $mail["addCC('cc@example.com');
//         $mail["addBCC('bcc@example.com');

//         //Attachments
//         $mail["addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//         $mail["addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//         //Content
//         $mail["isHTML(true);                                  //Set email format to HTML
//         $mail["Subject = 'Here is the subject';
//         $mail["Body    = 'This is the HTML message body <b>in bold!</b>';
//         $mail["AltBody = 'This is the body in plain text for non-HTML mail clients';

//         $mail["send();
//         echo 'Message has been sent';
//     } catch (Exception $e) {
//         echo "Message could not be sent. Mailer Error: {$mail["ErrorInfo}";
//     }
// }

function checkLogin($user, $pass)
{
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $sql = "SELECT * FROM users WHERE username='$user' OR user_email='$user'";
    $result = mysqli_query($conn, $sql); 
    if (mysqli_num_rows($result) === 0) {
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    $pass_save = $row['user_password']; 
    if (password_verify($pass, $pass_save)) {
        $sql = "DELETE FROM users_online WHERE username='$user'";
        if (!mysqli_query($conn, $sql)) {
            return false;
        }
        // $sql = "DELETE FROM users_online WHERE username='$user'";
        return true;
    }

    // B4. Dong ket noi
    mysqli_close($conn);
    return false;
}
function generateAuthToken()
{
}
function authorized()
{
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'baitaplon');
    if (!$conn) {
        die("Ko the ket noi");
    }
    $token = $_COOKIE["token"];
    if (empty($token)) {
        header("location:/baitaplon/auth/login.php");
        exit(1);
    }
    $sql = "SELECT * FROM users_online WHERE token='$token'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        header("location:/baitaplon/auth/login.php");
        exit(1);
    }
    $row = mysqli_fetch_assoc($result);
    $userName = $row['username'];

    //get userinfo
    $sql = "SELECT * FROM users WHERE username='$userName'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        header("location:/baitaplon/auth/login.php");
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
    require_once("constant.php");
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
        if ($userRole == "recruiter" && !str_contains($url, "recruitment") && !str_contains($url, "public")) {
            header("location:" . $route["recruitment"]);
        }
        if ($userRole == "user" && !str_contains($url, "user") && !str_contains($url, "public")) {
            header("location:" . $route["recruitment"]);
        }
    }
    if (isAuthRoute()) {
        if (isset($_SESSION["username"])) {
            $userRole = $_SESSION["user_role"];
            switch ($userRole) {
                case 'admin':
                    header("location:" . $route["admin"]);
                    break;
                case 'recruiter':
                    header("location:" . $route["recruitment"]);
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
    if (str_contains($url, "admin") || str_contains($url, "user") || str_contains($url, "recruitment")) {
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
    require_once("constant.php");
    header_remove();
    session_destroy();
    header("location:" . $route["auth"]);
}
