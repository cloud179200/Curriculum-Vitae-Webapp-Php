<?php
    include("../functions.php");
    handleRoute();
    require("../constant.php");
    header("location:".$route["auth"]."/login.php");
?>