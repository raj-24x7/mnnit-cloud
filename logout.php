<?php
session_start();
require 'checksession.php';
session_unset();
header("location:index.php"); 

?>