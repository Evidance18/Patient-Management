
<?php
// Include header file
require_once "header.php";
/*jQuery for logout confirmation 
  and header buttons*/
echo <<<_LOGGEDIN
<script>
$(function(){
	$('a#logout').click(function(){
		if(confirm('Exit the system?')) {
			return true;
		}

		return false;
	});
	$('a#deleteall').click(function(){
		if(confirm('Are you sure you want to delete all?')) {
			return true;
		}

		return false;
	});
});
</script>
        <div class='center'>
          <a data-role='button' title='Add new patient' style='color:#d2f89fcc; text-shadow: 1px 1px black; background-color:#5F9EA0' data-inline='true' data-icon='plus'
            data-transition="slide" href='create.php?view=$user'>ADD patient</a>
          <a data-role='button' id="deleteall" title='Delete all records' style='color:rgb(250, 153, 153); text-shadow: 1px 1px black; background-color:#5F9EA0' data-inline='true' data-icon='alert'
            data-transition="slide" href='deleteall.php'>DELETE ALL patients</a>
          <a data-role='button' id="logout" title='Logout' style='color:#d2f89fcc; text-shadow: 1px 1px black; background-color:#5F9EA0' data-inline='true' data-icon='lock'
            data-transition="slide" href='logout.php'>Log out</a>
        </div>
        
_LOGGEDIN;

// Attempt select query execution
  $query  = "SELECT * FROM patients";
  $result = $connection->query($query);
  if (!$result) die ("Database access failed");
	//Table and table header
  if ($rows = $result->num_rows){
  echo "<table border='1' class='center'>";
    echo "<thead>";
     echo "<tr style='color:green'>";
	    echo "<th>#</th>";
		echo "<th>Name</th>";
		echo "<th>Surname</th>";
		echo "<th>ID Number</th>";
		echo "<th>Gender</th>";
		echo "<th>Address</th>";
		echo "<th>Phone Number</th>";
		echo "<th>Email</th>";
		echo "<th>Action</th>";
		echo "</tr>";
	  echo "</thead>";
	 echo "<tbody>";
	 //Start couting from 1
	 $counter = 1;
	 // Fetching data from database
  while ($row = $result->fetch_array(MYSQLI_NUM))
  {
    echo "<tr>";
		echo "<td>" . $counter . "</td>";
		echo "<td>" . htmlspecialchars($row['1']) . "</td>";
		echo "<td>" . htmlspecialchars($row['2']) . "</td>";
		echo "<td>" . htmlspecialchars($row['3']) . "</td>";
		echo "<td>" . htmlspecialchars($row['4']) . "</td>";
		echo "<td>" . htmlspecialchars($row['5']) . "</td>";
		echo "<td>" . htmlspecialchars($row['6']) . "</td>";
		echo "<td>" . htmlspecialchars($row['7']) . "</td>";
		echo "<td>";
			  echo "<a data-role='button' data-inline='true' style='background-color:#5F9EA0' data-icon='edit' title='Update Patient' href='update.php?id=". $row['0'] ."'></a>";
			  echo "<a data-role='button' data-inline='true' style='background-color:#5F9EA0' data-icon='delete' title='Delete Patient' href='delete.php?id=". $row['0'] ."'></a>";
		echo "</td>";
	echo "</tr>";
	//Increment rows
	$counter++;
  }
  echo "<tbody>";

  echo "</table>";
  
  mysqli_free_result($result);
  } else { // Print if the is no data to display
	echo '<div class="next">';
	echo "<p class='lead'><em>No records were found.</em></p>";
	echo '</div>'; }
  

// Close connection
$connection->close();
?>