<?php // checkuser.php

  //Include funtions file
  require_once 'functions.php';

  if (isset($_POST['user']))
  {
    $user   = sanitizeString($_POST['user']);
    $result = queryMysql("SELECT * FROM admin WHERE user='$user'");


    // Check if the user exists on database or not
    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$user' is taken</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The username '$user' is available</span>";
  }
?>
