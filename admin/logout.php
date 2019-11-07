<?php
session_start();
$_SESSION['loggedin'] = False;
session_unset();
session_destroy();

header("Location: .");
?>