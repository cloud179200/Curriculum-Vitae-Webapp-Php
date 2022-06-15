<?php
include("../../functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_COOKIE["token"] && isset($_POST["contact_id"])) {
        $contact_id = $_POST["contact_id"];
        $result = removeContact($contact_id, $_COOKIE["token"]);
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
