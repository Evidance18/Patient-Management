<?php // login.php
  require_once 'header.php'; //include header
  $error = $user = $pass = ""; // Set error if inputs fields are empty

  // Sanitize to prevent hacking attempts
  if (isset($_POST['user']))
  {
    $user = mysql_fix_string($connection, $_POST['user']);
    $pass = mysql_fix_string($connection, $_POST['pass']);
    
    if ($user == "" || $pass == "")
      $error = 'Not all fields were entered';
    else
    {
      $result = queryMySQL("SELECT user,pass FROM admin
        WHERE user='$user' AND pass='$pass'");

      if ($result->num_rows == 0)
      {
        $error = "Invalid login attempt";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        echo "<script type='text/javascript'> document.location = 'patient.php'; </script>"; //Redirect to patient form
      }
    }
  }

echo <<<_END
      <form method='post' action='index.php'>
        <div data-role='fieldcontain'>
          <label></label>
          <span class='error'>$error</span>
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          Please enter your details to log in or Signup on the link below
        </div>
        <div data-role='fieldcontain'>
          <label>Username</label>
          <input type='text' maxlength='16' name='user' value='$user' placeholder='Username'>
        </div>
        <div data-role='fieldcontain'>
          <label>Password</label>
          <input type='password' maxlength='16' name='pass' value='$pass' placeholder='Password'>
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          <input data-transition='slide' type='submit' value='Login'>
        </div>
		<div data-role='fieldcontain'>
		  <label>Not yet registered? </label>
          <a href="signup.php" class="btn btn-success pull-right">Register Here</a>
        </div>
      </form>
    </div>
  </body>
</html>
_END;
?>
