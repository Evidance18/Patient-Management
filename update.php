<?php
// Include header file
require_once "header.php";
 
// Define variables and initialize with empty values
$name = $surname = $idno = $gender = $address = $phoneNo = $email = "";
$name_err = $surname_err = $idno_err = $gender_err = $address_err = $phoneNo_err = $email_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
	
	// Validate surname
    $input_surname = trim($_POST["surname"]);
    if(empty($input_surname)){
        $surname_err = "Please enter a surname.";
    } elseif(!filter_var($input_surname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $surname_err = "Please enter a valid surname.";
    } else{
        $surname = $input_surname;
    }
	
	// Validate idno
    $input_idno = trim($_POST["idno"]);
    if(empty($input_idno)){
        $idno_err = "Please enter the ID Number.";     
    } elseif(!ctype_digit($input_idno)){
        $idno_err = "Please enter a positive integer value.";
    } else{
        $idno = $input_idno;
    }
	
	// Validate gender
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please enter a gender.";
    } elseif(!filter_var($input_gender, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $gender_err = "Please enter a valid gender.";
    } else{
        $gender = $input_gender;
    }
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate phoneNo
    $input_phoneNo = trim($_POST["phoneNo"]);
    if(empty($input_phoneNo)){
        $phoneNo_err = "Please enter the Phone Number.";     
    } elseif(!ctype_digit($input_phoneNo)){
        $phoneNo_err = "Please enter a positive integer value.";
    } else{
        $phoneNo = $input_phoneNo;
    }
	
	// Validate email
	$input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an address.";     
    } else{
        $email = $input_email;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($surname_err) && empty($idno_err) && empty($gender_err) && empty($address_err) && empty($phoneNo_err) && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE patients SET name=?, surname=?, idno=?, gender=?, address=?, phoneNo=?, email=? WHERE id=?";
         
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_name, $param_surname, $param_idno, $param_gender, $param_address, $param_phoneNo, $param_email, $param_id);
            
            // Set parameters
            $param_name = $name;
			$param_surname = $surname;
			$param_idno = $idno;
			$param_gender = $gender;
            $param_address = $address;
            $param_phoneNo = $phoneNo;
			$param_email = $email;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                //Altering that the process is successsful
                echo "<script>alert('Patient is successfully Updated');</script>";
		        // Records updated successfully. Redirect to landing page
                echo "<script type='text/javascript'> document.location = 'patient.php'; </script>"; 
                
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
    echo "<script>alert('Patient updated');</script>";
} else{
    require_once "header.php";
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM patients WHERE id = ?";
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
					$surname = $row["surname"];
					$idno = $row["idno"];
					$gender = $row["gender"];
                    $address = $row["address"];
                    $phoneNo = $row["phoneNo"];
					$email = $row["email"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($connection);
        
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Patient</title>
    <link rel='stylesheet' href='styles.css' type='text/css'>  
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Patient</h2>
                    </div>
                    <p>Please edit the input values and submit to update the patient.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
                            <label>Surname</label>
                            <input type="text" name="surname" class="form-control" value="<?php echo $surname; ?>">
                            <span class="help-block"><?php echo $surname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($idno)) ? 'has-error' : ''; ?>">
                            <label>ID Number</label>
                            <input type="text" name="idno" class="form-control" value="<?php echo $idno; ?>">
                            <span class="help-block"><?php echo $idno_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label>Gender</label>
                            <select name="gender" size="1"> <option value="Male">Male</option>
							<option value="Female">Female</option></select>
                            <span class="help-block"><?php echo $gender_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phoneNo_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input type="text" name="phoneNo" class="form-control" value="<?php echo $phoneNo; ?>">
                            <span class="help-block"><?php echo $phoneNo_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="patient.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>