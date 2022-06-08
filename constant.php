<?php 
    $errorsMessage = array();
    $errorsMessage["empty"] = "This field is required";
    $errorsMessage["invalid"]= "This field is not valid";

    $route = array();
    $route["default"] = "/baitaplon";
    $route["auth"] = $route["default"]."/auth";
    $route["user"] = $route["default"]."/auth";
    $route["admin"] = $route["default"]."/auth";
    $route["admin"] = $route["default"]."/recruitment";
?>