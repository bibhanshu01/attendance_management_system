<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="admin_course_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="heading">Attendance Management System</div>

<header>
  <nav>
    <ul>
      <li><a href="#">Admin</a></li>
      <li><a href="../admin_student/admin_student.php">Student</a></li>
      <li><a href="../admin_teacher/admin_teacher.php">Teacher</a></li>
      <li><a href="#">Course</a></li>
      <li><a href="../admin_subject/admin_subject.php">Subject</a></li>
      <li><a href="../admin_attendance/admin_attendance.php">Attendance</a></li>
      <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Course Form starts -->
<div class="course_container"> 
	<h1>Courses</h1>
	<form method="POST" action="add_course.php">
		<label>Course Name:</label>
		<input type="text" name="course_name" required>
		
		<label>Course Duration:</label>
		<input type="text" name="course_duration" required>

		<button type="submit" name="add_course">Add Course</button>
	</form>

	<table>
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Course</th>
				<th>Duration</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<!-- <?php
			// Fetch courses from database and display in table
			$conn = mysqli_connect("localhost", "username", "password", "database");

			$sql = "SELECT * FROM courses";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				$i = 1;
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>" . $i . "</td>";
					echo "<td>" . $row['course_name'] . "</td>";
					echo "<td>" . $row['course_duration'] . "</td>";
					echo "<td><a href='remove_course.php?id=".$row['id']."'>Remove</a></td>";
					echo "</tr>";
					$i++;
				}
			} else {
				echo "<tr><td colspan='4'>No courses found.</td></tr>";
			}
			
			mysqli_close($conn);
			?> -->
		</tbody>
	</table>
</div> 



<!-- Course Form ends -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>