<?php // header.php
  session_start(); //Start session

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
    <link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <script src='javascript.js'></script>
    <script src='jquery-2.2.4.min.js'></script>
    <script src='jquery.mobile-1.4.5.min.js'></script>

_INIT;

  require_once 'functions.php'; //Include funtions file

  $userstr = 'Patient Management System';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
  }
  else $loggedin = FALSE;

echo <<<_MAIN
    <title>Welcom to Patient Management System: $userstr</title>
  </head>
  <body>
    <div data-role='page'>
      <div data-role='header'>
        <div id='logo' class='username'>$userstr</div>
      </div>
      <div data-role='content'>

_MAIN;

?>
