<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="admin_subject_style.css">
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

<!-- Subject Form starts -->
<div class="subject_container">
		<h2>Subjects</h2>
	<form method="post">
		<label>Subject Name:</label>
		<input type="text" name="subject_name" required>
		<label>Course Name:</label>
		<input type="text" name="course_name" required>
		<button type="submit" name="add_subject">Add Subject</button>
	</form>
	<table>
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Subject</th>
				<th>Course</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<!-- <?php
				// Connect to the database
				$conn = mysqli_connect("localhost", "username", "password", "database_name");
				
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				
				// Fetch subjects from the database
				$sql = "SELECT * FROM subjects";
				$result = mysqli_query($conn, $sql);
				
				// If there are subjects, display them in the table
				if (mysqli_num_rows($result) > 0) {
					$count = 1;
					
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $count . "</td>";
						echo "<td>" . $row['subject_name'] . "</td>";
						echo "<td>" . $row['course_name'] . "</td>";
						echo "<td class='action-column'><button class='remove-btn' data-id='" . $row['id'] . "'>Remove</button></td>";
						echo "</tr>";
						
						$count++;
					}
				} else {
					echo "<tr><td colspan='4'>No subjects found</td></tr>";
				}
				
				// Close database connection
				mysqli_close($conn);
			?> -->
		</tbody>
	</table>
	
	</div>

<!-- Subject Form ends -->

<!-- script for action button starts -->
<!-- <script>
		// Add event listener to remove buttons
		const removeBtns = document.querySelectorAll('.remove-btn');
		
		removeBtns.forEach(btn => {
			btn.addEventListener('click', e => {
				const courseId = btn.getAttribute('data-id');
				
				// Send AJAX request to the server to remove course from the list
				const xhr = new XMLHttpRequest();
				
				xhr.open('POST', 'remove_course.php', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = () => {
					if (xhr.status >= 200 && xhr.status < 400) {
						alert(xhr.responseText);
						
						// If the operation was successful, remove the row from the table
						e.target.parentNode.parentNode.remove();
					} else {
						console.error('Error: ' + xhr.statusText);
					}
				};
				xhr.onerror = () => {
					console.error('Error: Network Error');
                  };
				
				xhr.send(`course_id=${courseId}`);
			});
		});
	</script> -->
<!-- script for action button ends -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>