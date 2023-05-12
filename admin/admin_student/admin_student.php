<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="admin_student_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="heading">Attendance Management System</div>

<header>
  <nav>
    <ul>
      <li><a href="#">Admin</a></li>
      <li><a href="#">Student</a></li>
      <li><a href="admin/admin_teacher.php">Teacher</a></li>
      <li><a href="student/student_course.php">Course</a></li>
      <li><a href="teacher/teacher_subject.php">Subject</a></li>
      <li><a href="teacher/teacher_attendance.php">Attendance</a></li>
      <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Student Registration Form starts -->
<div class="container">
		<h2>Student Registration</h2>
		<form action="register.php" method="post">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder="Name">

			<label for="roll_number">Roll Number:</label>
			<input type="text" id="roll_number" name="roll_number" placeholder="Roll Number">

			<label for="email">Email:</label>
			<input type="text" id="email" name="email" placeholder="Email">

			<label for="course">Course:</label>
			<input type="text" id="course" name="course" placeholder="Course">

			<label for="subject">Subject:</label>
			<select id="subject" name="subject">
        <option value="" disabled selected hidden>Select Subject</option>
				<option value="Data Structures">Data Structures</option>
				<option value="Internet of Things">Internet of Things</option>
				<option value="Data Science and Analytics">Data Science and Analytics</option>
			</select>

			<input type="submit" value="Register">
		</form>
	</div>



<!-- Student Registration Form ends -->

<!-- Student Table starts -->
<table>
  <caption>STUDENTS</caption>
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th>Name</th>
      <th>Course</th>
      <th>Subject</th>
      <th>Roll No.</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <!-- <?php
      // code to retrieve data from database and loop through each row
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['sr_no'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['course'] . "</td>";
        echo "<td>" . $row['subject'] . "</td>";
        echo "<td>" . $row['roll_no'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
      }
    ?> -->
  </tbody>
</table>
  
   
<!-- Student Table ends -->














<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>



