<?php
include("../../functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["cv_id"])) {
        $cv_id = $_GET["cv_id"];
        $result = getCVInfoById($cv_id);
        echo $result ? json_encode($result) : json_encode(array("error" => "something went wrong"));
        exit();
    }
    http_response_code(400);
    echo json_encode(array("error" => true));
    exit();
}
http_response_code(401);
echo json_encode(array("error" => true));
exit();
