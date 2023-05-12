<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="admin_teacher_style.css">
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

<!-- Admin Teacher Form starts -->
<div class="teacher_container">
		<h2>Teacher Registration</h2>
		<form action="" method="post">
			<div class="col-25">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" placeholder="Teacher Name">
			</div>
			<div class="col-50">
				<label for="course">Course</label>
				<select id="course" name="course">
                  <option value="" disabled selected hidden>Select Course</option>
					<option value="BTech">BTech</option>
					<option value="MCA">MCA</option>
					<option value="MTech">MTech</option>
				</select>
				<label for="subject">Subject</label>
				<select id="subject" name="subject">
				<option value="" disabled selected hidden>Select Subject</option>
				<option value="Data Structures">Data Structures</option>
				<option value="Internet of Things">Internet of Things</option>
				<option value="Data Science and Analytics">Data Science and Analytics</option>
				</select>
			</div>
			<div class="col-25">
				<input type="submit" name="register" value="Register">
			</div>
		</form>
	</div>
	<div class="teacher_container">
		<h2>Teachers</h2>
		<table>
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Name</th>
					<th>Course</th>
					<th>Subject</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<!-- <?php
					$servername = "localhost";
					$username = "username";
					$password = "password";
					$dbname = "myDB";

					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);

					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}

					// If form submitted, insert data into database
					if (isset($_POST['register'])) {
						$name = $_POST['name'];
						$course = $_POST['course'];
						$subject = $_POST['subject'];

						$sql = "INSERT INTO teachers (name, course, subject) VALUES ('$name', '$course', '$subject')";

						if ($conn->query($sql) === TRUE) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					}
                    
                    // Fetch data from database and display in table
					$sql = "SELECT * FROM teachers";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						$i = 1;
						while($row = $result->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['course']; ?></td>
								<td><?php echo $row['subject']; ?></td>
								<td class="action-btns">
									<form action="delete_teacher.php" method="post">
										<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
										<button type="submit" name="delete">Delete</button>
									</form>
								</td>
							</tr>
						<?php }
					} else {
						echo "0 results";
					}

					$conn->close();
				?> -->
			</tbody>
		</table>
	</div>



<!-- Admin Teacher Form ends -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>