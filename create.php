<?php
   require_once 'header.php'; // Indlude header file
   

   // Check if ID number do not exist
   echo <<<_END
  <script>
    function checkPatient(idno)
    {
      if (idno.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkpatient.php',
        { idno : idno.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>  
_END;
// Check input errors before inserting in database
  $error = $name = $surname = $idno = $gender = $address = $phoneNo = $email = "";
  if (isset($_SESSION['id'])) destroySession();
  
  //Sanitize inputs for MySQL
  if (isset($_POST['id']))
  {
  $id        = mysql_fix_string($connection, $_POST['id']);
	$name      = mysql_fix_string($connection, $_POST['name']);
  $surname   = mysql_fix_string($connection, $_POST['surname']);
	$idno      = mysql_fix_string($connection, $_POST['idno']);
	$gender    = mysql_fix_string($connection, $_POST['gender']);
	$address   = mysql_fix_string($connection, $_POST['address']);
	$phoneNo   = mysql_fix_string($connection, $_POST['phoneNo']);
	$email     = mysql_fix_string($connection, $_POST['email']);

    // Check if inputs are not empty
  if ($name == "" || $surname == "" || $idno == "" || $gender == "" || $address == "" || $phoneNo == "" || $email == "")
      $error = 'Not all fields were entered<br><br>'; // Show error if fields are empty
    else
    {
      $result = queryMysql("SELECT * FROM patients WHERE idno='$idno'"); //Select ID number from table to check if it exists
      // Collecting data from table
      if ($result->num_rows)
        $error = '<a style=color:red>This patient already exists</a><br><br>'; // Out printing error
      else
      {
        // Prepare statement
        $stmt = $connection->prepare('INSERT INTO patients (name, surname, idno, gender, address, phoneNo, email, id) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
		    $stmt->bind_param('sssssssi', $name, $surname, $idno, $gender, $address, $phoneNo, $email, $id);
		
		$stmt->execute(); // Execute statement
		
    echo "The Insert ID was: " . $connection->insert_id; // Insert ID auto
    
    echo "<script>alert('Patient is successfully added');</script>";
		
        echo "<script type='text/javascript'> document.location = 'patient.php'; </script>"; // Redirect to patient form
		$stmt->close(); // Close statement
      }
	  
    }
	
  }
  
  //The fields must be entered
  echo <<<_Head
  <div class='center'>
    <h1>Please fill the fields to add patient to database</h1>
  </div>
  _Head;

  //Create  a form
echo <<<_END
  <form method='post' action='create.php'>$error
	<div data-role='fieldcontain'>
		<label></label>
		<input type="hidden" name="id" class="form-control" value="id">
	</div>
	<div data-role='fieldcontain'>
		<label>Name</label>
		<input type="text" name="name" class="form-control" placeholder="Name" value="$name">
	</div>
	<div data-role='fieldcontain'>
		<label>Surname</label>
		<input type="text" name="surname" class="form-control" placeholder="Surname" value="$surname">
	</div>
	<div data-role='fieldcontain'>
		<label>ID Number</label>
		<input type="text" name="idno" minlength="13" maxlength="13" class="form-control" placeholder="Identical Number" value="$idno">		
	</div>
	<div data-role='fieldcontain'>
		<label>Gender</label>
		<select name="gender" size="1"> <option value="Male">Male</option>
		<option value="Female">Female</option></select>
	</div>
	<div data-role='fieldcontain'>
		<label>Address</label>
		<textarea name="address" class="form-control" placeholder="Address" value="$address"></textarea>
	</div>
	<div data-role='fieldcontain'>
		<label>Phone Number</label>
		<input type="text" name="phoneNo" minlength="9" maxlength="10" class="form-control" placeholder="Phone Number" value="$phoneNo">
	</div>
	<div data-role='fieldcontain'>
		<label>Email</label>
		<input type="email" name="email" class="form-control" placeholder="Email Address" value="$email">
		
	</div>
	<div data-role='fieldcontain'>
        <label></label>
        <input data-transition='slide' type='submit' value='ADD'>
      </div>
	  <div data-role='fieldcontain'>
		  <label></label>
          <a href="patient.php" class="btn btn-success pull-right">Cancel</a>
    </div>

   </div>
</body>
</html>
_END;

$connection->close();  // Close connection
?>