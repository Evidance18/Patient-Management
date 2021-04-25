<?php // signup.php
  require_once 'header.php';
// Script to Check user in database
echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>  
_END;
    // Error when inputs are empty
  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) destroySession();

  //Sanitize user input for MySQL
  if (isset($_POST['user']))
  {
    $user = mysql_fix_string($connection, $_POST['user']);
    $pass = mysql_fix_string($connection, $_POST['pass']);
    // Check if the input fields are not empty
    if ($user == "" || $pass == "")
      $error = 'Not all fields were entered<br><br>';
    else
    {
      $result = queryMysql("SELECT * FROM admin WHERE user='$user'"); // Select User
      // Check if username already exist
      if ($result->num_rows)
        $error = 'That username already exists<br><br>';
      else
      {
        //Prepare statement
        $stmt = $connection->prepare('INSERT INTO admin VALUES(?, ?)'); 
		$stmt->bind_param('ss', $user, $pass);
		//Execute statement
		$stmt->execute(); 
		//Popup to notify your process is successful
    echo "<script>alert('You are now registered. Enter your details and login');</script>";
		// Redirect you to login page
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
      }
    }
    //Close statement
	$stmt->close(); 
  }
// Signup form
echo <<<_END
      <form method='post' action='signup.php'>$error
      <div data-role='fieldcontain'>
        <label></label>
        Please enter your details to sign up
      </div>
      <div data-role='fieldcontain'>
        <label>Username</label>
        <input type='text' maxlength='16' name='user' value='$user'
          onBlur='checkUser(this)'>
        <div id='used'>&nbsp;</div>
      </div>
      <div data-role='fieldcontain'>
        <label>Password</label>
        <input type='password' maxlength='16' name='pass' value='$pass'>
      </div>
      <div data-role='fieldcontain'>
        <label></label>
        <input data-transition='slide' type='submit' value='Sign Up'>
      </div>
	  <div data-role='fieldcontain'>
		  <label>Registered? </label>
          <a href="index.php" class="btn btn-success pull-right">Login Here</a>
        </div>
    </div>
  </body>
</html>
_END;

//Close connection
$connection->close();

?>