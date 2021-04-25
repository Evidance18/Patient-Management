<?php
// Include header file
    require_once "header.php";

// Process delete operation after confirmation
if(isset($_POST["patients"]) && !empty($_POST["patients"])){
    
    // Prepare a delete all statement
    $result = queryMysql("SELECT * FROM patients");
    // Delete all data statement
    if($stmt = $connection->prepare("TRUNCATE patients")){
             
        // Set parameters
        $contacts = trim($_POST["patients"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Alter that the process is successfull
            echo "<script>alert('All data is successfully deleted');</script>";
            // Records deleted successfully. Redirect to landing page
            echo "<script type='text/javascript'> document.location = 'patient.php'; </script>";
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $connection->close();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete All Records</title>
    <!--Include stylesheet-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!--Include javascript file-->
    <script src='javascript.js'></script> 
    
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="header">
                      <!--Form header-->
                        <h1>Delete All Data From Database</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="patients" value="<?php echo trim($_GET["patients"]); ?>"/>
                            <p>Are you sure you want to delete all data from database?</p><br>
                            <p>
                                <input type="submit" style='background-color:red' value="Yes" class="btn btn-danger">
                                
                                <a href="patient.php" data-role='button'>No</a>
                            </p>
                            
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div> 
</body>
</html>