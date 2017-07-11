<html>
<head>
    <title>Pie Chart</title>
	
	<!-- Google's terms of service forbid me from downloading the Google Charts code.
	     I must use their website as the "src" for this script, not my "js" folder -->
	<script src="https://www.gstatic.com/charts/loader.js"></script>
	
	<!-- JavaScript for this file (my own JavaScript) -->
	<script src='../js/sectionb.js'></script>
	
</head>
<body>

<?php
	
	// Most of this code is borrowed from assignment 3:
    require_once 'login2.php';
    $conn = new mysqli($hn, $un, $pw, $db);
	
    if ($conn->connect_error) {
		die($conn->connect_error);
	}
	
	// GET DATA FROM DATABASE AND FILL A "DUMMY" <P> ELEMENT WITH IT:
	// Since I don't know how to use JavaScript to access a database, I fill
	// a 'dummy' <p> element with the correctly formatted data.
	// The JavaScript will hide this element when displaying the page,
	// and use this element's innerHTML find the data for displaying it.
	
	$query = "SELECT category, COUNT(*) cnt FROM classics GROUP BY category";
	$result = $conn->query($query);
	
	if (!$result) {
		die("Database access failed: " . $conn->error);
	}
	
	$rows = $result->num_rows;
	
	$output = "<p id='data'>[['Category', 'Count'], "; // Beginning of data string
	
	for ($i = 0; $i < $rows; ++$i) {
		$result->data_seek($i);
		$row = $result->fetch_array(MYSQLI_NUM);
		$output .= "['$row[0]',  '$row[1]']";
		
		if ($i != $rows - 1) {
			$output .= ", ";		// add comma if not last row
		}
	}
	
	$output .= "]";		// a "]" character terminates the data string
	
	echo "<p id='data'>$output</p>";
	$result->close();
	$conn->close();
?>

<div id='piechart'></div>
</body>
</html>