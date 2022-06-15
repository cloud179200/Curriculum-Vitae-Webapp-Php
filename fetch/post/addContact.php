<?php
include("../../functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["cv_id"]) && isset($_POST["contact_name"]) && isset($_POST["phone"]) && isset($_POST["email"])) {
        $cv_id = $_POST["cv_id"];
        $contact_name = $_POST["contact_name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $result = addContact($cv_id, $contact_name, $phone, $email);
        return $result ? json_encode(array("success" => true)) : json_encode(array("error" => "something went wrong"));
    }
    http_response_code(400);
    return json_encode(array("error" => true));
}
http_response_code(401);
return json_encode(array("error" => true));
