<?php
include("../../functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["cv_id"]) && isset($_POST["contact_name"]) && isset($_POST["phone"]) && isset($_POST["email"])) {
        $cv_id = $_POST["cv_id"];
        $contact_name = $_POST["contact_name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $result = addContact($cv_id, $contact_name, $phone, $email, $message);
        echo $result ? json_encode(array("success" => true)) : json_encode(array("error" => "something went wrong"));
        exit();
    }
    http_response_code(400);
    echo json_encode(array("error" => true));
    exit();
}
http_response_code(401);
echo json_encode(array("error" => true));
exit();
