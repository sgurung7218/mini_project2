<?php
$server = "localhost";
$username = "my_usr";
$password = "miniproject";
$database = "uni_db";

$mysqli = new mysqli($server, $username, $password, $database);

//check connection
if ($mysqli -> connect_errno) {
	die("Connection failed: ". $mysqli->connect_error);
}

$courses_result = $enroll_result = $show_courses = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (isset($_POST['instructor'])){
		$query = "SELECT * FROM instructor";
		$query_result = $mysqli->query($query);
		if ($query_result && $query_result->num_rows>0){
			$courses_result="<table border='1'><tr><th>Name</th><th>dept_name</th></tr>";
			while ($row = $query_result->fetch_assoc()){
				$courses_result.="<tr><td>{$row['name']}</td><td>{$row['dept_name']}</td></tr>";
			}
			$courses_result.="</table>";
		}else{
			$courses_result="No results found with the name!!!";
		}
	}
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mini_project2</title>
</head>
<body>
<div class="instructor">
<h1> Instructor Courses Search Page </h1>
<form method="POST">
<label for="instructor_name">Enter Instructor Name:</label>
<input type="text" name="instructor_name" placeholder="e.g., Wu">
<button type="submit" name="instructor">Search Courses</button>
</form>
<div id="courses_result"><?php echo $courses_result; ?></div>
</div>

<div class="student">
<h1> Student Enrolled Courses Page </h1>
<form method="POST">
<label for="student_name">Enter Student Name:</label>
<input type="text" name="student_name" placeholder="e.g., Aoi">
<button type="submit" name="student">Search Enrollments</button>
</form>
<div id="enroll_result"><?php echo $enroll_result; ?></div>
</div>

<div class="department">
<h1> Computer Science Department Course Listings </h1>
<form method="POST">
<label for="dept_name">Enter Department Name:</label>
<input type="text" name="dept_name" placeholder="e.g., Comp. Sci.">
<button type="submit" name="dept">Show Courses</button>
</form>
<div id="show_courses"><?php echo $show_courses; ?></div>
</div>

</body>
</html>
