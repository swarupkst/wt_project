<?php

session_start();
session_unset();
session_destroy();
header("Location: ../../index.php");
// include(__DIR__ . '/../../config.php');
exit();

?>
