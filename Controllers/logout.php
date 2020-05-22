<?php
session_start();
require_once('..\Models\dbListener.php');
dbListener::clean();
unset($_SESSION["user"]);
header("location: ../login");
?>