<?php
// Include header file
    require_once "header.php";

// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    // Prepare a delete statement
    $result = queryMysql("SELECT * FROM patients WHERE id='$id'");
    
    if($stmt = $connection->prepare("DELETE FROM patients WHERE id = ? ")){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param('i', $id);
        
        // Set parameters
        $id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Alter that the process is successfull
            echo "<script>alert('Patient is deleted');</script>";
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
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
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
    <title>View Record</title>
    
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Patient</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this patient?</p><br>
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