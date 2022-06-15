<?php
include("../../functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_COOKIE["token"] && isset($_POST["name"]) && isset($_POST["date_of_birth"]) && isset($_POST["address"]) && isset($_POST["phone"]) && isset($_POST["detail"]) && isset($_POST["status"]) && isset($_POST["desired_job"])) {
        $name = $_POST["name"];
        $date_of_birth = $_POST["date_of_birth"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $detail = $_POST["detail"];
        $status = $_POST["status"];
        $desired_job = $_POST["desired_job"];
        $result = addCVInfo($_COOKIE["token"], $name, $date_of_birth, $address, $phone, $detail, $status, $desired_job);
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

