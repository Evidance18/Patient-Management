<?php // functions.php
  $dbhost  = 'localhost';  // localhost
  $dbname  = 'patient';    // database name
  $dbuser  = 'root';   // user name
  $dbpass  = 'password';   // user password

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname); // Attempt to connect the database
  if ($connection->connect_error) die("Fatal Error On Connecting");
  
  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error on insersion");
    return $result;
  }

  // Destroy session
  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  //Sanitize function for inputs
  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc())
      $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }
  // Function to prevent hacking attempts
  function mysql_entities_fix_string($connection, $string)
  {
	  return htmlentities(mysql_fix_string($connection, $string));
  }
  // Function to prevent hacking attempts
  function mysql_fix_string($connection, $string)
  {
	  if (get_magic_quotes_gpc()) $string = stripcslashes($string);
	  return $connection->real_escape_string($string);
  }

	  
?>
