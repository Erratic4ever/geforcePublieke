<?php
error_reporting(0);

	session_start();
    if (isset($_GET['time'])) {
  	  $_SESSION['USER_TIME'] = $_GET['time'];
    }
?>