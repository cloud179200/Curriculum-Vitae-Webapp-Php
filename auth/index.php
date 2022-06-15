<?php
    include("../functions.php");
    session_start();
    handleRoute();
    require("../constant.php");
    header("location:".$route["auth"]."/login.php");
?>