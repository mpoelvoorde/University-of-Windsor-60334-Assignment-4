<html>
<head>
    <title>User Form</title>
</head>
<body>

<?php
	
	// Most of this code is borrowed from assignment 3:
    require_once 'login1.php';
    $conn = new mysqli($hn, $un, $pw, $db);
	
    if ($conn->connect_error) {
		die($conn->connect_error);
	}
	
	// WHEN FORM IS SUBMITTED:
	if (isset($_POST['submit'])) {
		$query = "INSERT INTO user_profiles(fname, lname, usercode, email, password) VALUES (?, ?, ?, ?, ?)";
		
		// Bind parameters using syntax discussed at: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
		$stmt = $conn->prepare($query);
		
		// Sanitize parameters for SQL statement:
		$fname = $conn->real_escape_string($_POST['fname']);
		$lname = $conn->real_escape_string($_POST['lname']);
		$usertype = $conn->real_escape_string($_POST['usertype']);
		$email = $conn->real_escape_string($_POST['email']);
		$password = $conn->real_escape_string($_POST['password']);
		
		// Bind parameters for SQL statement:
		$stmt->bind_param("ssiss", $fname, $lname, $usertype, $email, $password);
		
		// Unset $_POST['submit'] so that it won't submit again when page refreshed:
		unset($_POST['submit']);
		
		// Execute statement and display success/failure to screen
		if ($stmt->execute()) {
			echo '<p>Successfully inserted record</p>';
		} else {
			die($stmt->error);
		}
	}
?>

<form method='post' id='newuser'>
	<label for='fname'>First Name: </label>
		<input type='text' name='fname' id='fname' required><br>
	<label for='lname'>Last Name: </label>
		<input type='text' name='lname' id='lname' required><br>
	<label for='usertype'>User Type: </label>
		<select id='usertype' name='usertype'>
			<?php
				// Display the possible user types:
				$query = "SELECT * FROM user_codes";
				$result = $conn->query($query);
				
				// If error occurs, die
				if (!$result) {
					die ("Database access failed: " . $conn->error);
				}
				
				$rows = $result->num_rows;
				
				for ($i = 0; $i < $rows; ++$i) {
					$result->data_seek($i);
					$row = $result->fetch_array(MYSQLI_NUM);
					
					// Generate HTML for user type option
					echo "<option value='$row[0]'>$row[1]</option>";
				}
				
				// Close the query
				$result->close();
			?>
		</select><br>
	<label for='email'>E-Mail: </label>
		<input type='text' name='email' id='email'><br>
	<label for='password'>Password: </label>
		<input type='text' name='password' id='password'><br>
	<input type='submit' id='submit' name='submit' value='Submit'>
</form>

<?php
	// Close connection:
	$conn->close();
?>
</body>
</html>