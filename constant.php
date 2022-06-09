<?php 
    $errorsMessage = array();
    $errorsMessage["empty"] = "This field is required";
    $errorsMessage["invalid"]= "This field is not valid";

    $host  = "http://localhost";
    $route = array();
    $route["default"] = "/baitaplon";
    $route["auth"] = $route["default"]."/auth";
    $route["user"] = $route["default"]."/user";
    $route["admin"] = $route["default"]."/admin";
    $secretKey  = 'cha.iu.iem';
?>