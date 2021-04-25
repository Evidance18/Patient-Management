<?php // checkpatient.php

  //Include functions file
  require_once 'functions.php';

  if (isset($_POST['id']))
  {
    $id   = sanitizeString($_POST['id']);
	$idno = sanitizeString($_POST['idno']);
    $result = queryMysql("SELECT * FROM patients WHERE idno='$idno'"); // check patient by ID number

    //Display if the patient is already on the system or not
    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The ID Number '$idno' is taken</span>"; 
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The ID Number '$idno' is available</span>";
  }
?>