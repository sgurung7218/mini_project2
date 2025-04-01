<?php
$server = "localhost";
$username = "root";
$password = "password";
$database = "uni_db";

$mysqli = new mysqli($server, $username, $password, $database);

//check connection
if ($mysqli -> connect_errno) {
	die("Connection failed: ". $mysqli->connect_error);
}

$courses_result = $enroll_result = $show_courses = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (isset($_POST['instructor'])){
		$query = "SELECT c.course_id, c.title AS course_name FROM course c JOIN teaches t ON c.course_id = t.course_id JOIN instructor i ON t.ID = i.ID WHERE i.name LIKE '%" . $mysqli->real_escape_string($_POST['instructor_name']) . "%'";
		$query_result = $mysqli->query($query);
		if ($query_result && $query_result->num_rows>0){
			$courses_result="<table border='1'><tr><th>Course ID</th><th>Course Title</th></tr>";
			while ($row = $query_result->fetch_assoc()){
				$courses_result.="<tr><td>{$row['course_id']}</td><td>{$row['course_name']}</td></tr>";
			}
			$courses_result.="</table>";
		}else{
			$courses_result="No results found with the name!!!";
		}
	}
	if (isset($_POST['student']))
	{
		$student_name = $mysqli->real_escape_string($_POST['student_name']);
		$query = "
        SELECT c.course_id, c.title AS course_name 
        FROM student s 
        JOIN takes t ON s.ID = t.ID 
        JOIN course c ON t.course_id = c.course_id 
        WHERE s.name = '$student_name'";
		$query_result = $mysqli->query($query);
		if ($query_result && $query_result->num_rows>0){
			$enroll_result="<table border='1'><tr><th>Course ID</th><th>Course Title</th></tr>";
			while ($row = $query_result->fetch_assoc()){
				$enroll_result.="<tr><td>{$row['course_id']}</td><td>{$row['course_name']}</td></tr>";
			}
			$enroll_result.="</table>";
		}else{
			$enroll_result="No results found with the name!!!";
		}
	}
	if (isset($_POST['dept']))
	{
		$dept_name = $mysqli->real_escape_string($_POST['dept_name']);
		$query = "
		SELECT c.course_id, c.title AS course_name 
		FROM course c
		WHERE c.dept_name = '$dept_name'";
		$query_result = $mysqli->query($query);
		if ($query_result && $query_result->num_rows>0){
			$show_courses="<table border='1'><tr><th>Course ID</th><th>Course Title</th></tr>";
			while ($row = $query_result->fetch_assoc()){
				$show_courses.="<tr><td>{$row['course_id']}</td><td>{$row['course_name']}</td></tr>";
			}
			$show_courses.="</table>";
		}else{
			$show_courses="No results found with the name!!!";
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
<input type="text" id="instructor_name" name="instructor_name" placeholder="e.g., Wu">
<button type="submit" name="instructor">Search Courses</button>
</form>
<div id="courses_result"><?php echo $courses_result; ?></div>
</div>
<div class="student">
<h1> Student Enrolled Courses Page </h1>
<form method="POST">
<label for="student_name">Enter Student Name:</label>
<input type="text" name="student_name" id="student_name" placeholder="e.g., Aoi">
<button type="submit" name="student">Search Enrollments</button>
</form>
<div id="enroll_result"><?php echo $enroll_result; ?></div>
</div>
<div class="department">
<h1> Computer Science Department Course Listings </h1>
<form method="POST">
<label for="dept_name">Enter Department Name:</label>
<input type="text" name="dept_name" id="dept_name" placeholder="e.g., Comp. Sci.">
<button type="submit" name="dept">Show Courses</button>
</form>
<div id="show_courses"><?php echo $show_courses; ?></div>
</div>
</body>
</html>
