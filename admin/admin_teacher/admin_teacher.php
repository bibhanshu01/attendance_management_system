<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';
















  ?>



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
      <li><a href="../admin_student/admin_student.php">Student</a></li>
      <li><a href="#">Teacher</a></li>
      <li><a href="../admin_course/admin_course.php">Course</a></li>
      <li><a href="../admin_subject/admin_subject.php">Subject</a></li>
      <li><a href="../admin_attendance/admin_attendance.php">Attendance</a></li>
      <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Admin Teacher Form starts -->

<div class="container">
	<h2>Teacher Registration</h2>
		<form action="" method="POST">

			<label for="tid">Teacher ID:</label>
			<input type="text" id="tid" name="tid" value="<?php echo $row['teacherID'];?>" required placeholder="Enter Teacher ID">

			<label for="name">Name:</label>
			<input type="text" id="name" name="name" value="<?php echo $row['teacherName'];?>" required placeholder="Enter Name">

			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="<?php echo $row['teacherEmail'];?>" required placeholder="Enter Email Address">

    		<label for="password">Password:</label>
			<input type="text" id="password" name="password" value="<?php echo $row['teacherpassword'];?>" required placeholder="Enter Password">

			<?php
            	if (isset($Id))
                    {
            ?>
            <button type="submit" name="update" class="btn btn-warning">Update</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
                } else {           
            ?>
            <button type="submit" name="save" class="btn btn-primary">Save</button>
            <?php
                 }         
            ?>

			<!-- <button type="submit" name="submit">Register</button> -->
		</form>
</div>


	<div class="teacher_container">
		<h2>Teachers</h2>
		<table>
			<thead>
				<tr>
					<!-- <th>Sr. No.</th> -->
					<th>Teacher ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Password</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					
					// If form submitted, insert data into database
					if (isset($_POST['submit'])) {
						$teacherID = $_POST['tid'];
						$teacherName = $_POST['name'];
						$teacherEmail = $_POST['email'];
						$teacherpassword= $_POST['password'];

						$query=mysqli_query($conn,"select * from teacher where teacherID ='$teacherID'");
						$ret=mysqli_fetch_array($query);

						if($ret > 0){ 

							echo "<script>alert('Already registered.');</script>";
						}
						else{
							$sql = "INSERT INTO teacher (teacherID, teacherName, teacherEmail, teacherpassword)
							 VALUES ('$teacherID', '$teacherName', '$teacherEmail', '$teacherpassword')";

							if ($conn->query($sql) === TRUE) {
							echo "New record created successfully";
							} 
							else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}

						}

						
					}
                    
                    // Fetch data from database and display in table
					$sql = "SELECT * FROM teacher";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// $i = 1;
						while($row = $result->fetch_assoc()) { ?>
							<tr>
								<!-- <td><?php echo $i++; ?></td> -->
								<td><?php echo $row['teacherID']; ?></td>
								<td><?php echo $row['teacherName']; ?></td>
								<td><?php echo $row['teacherEmail']; ?></td>
								<td><?php echo $row['teacherpassword']; ?></td>
								<td class="action-btns">
									<form action="" method="POST">
										<input type="hidden" name="id" value="<?php echo $row['teacherID']; ?>">
										<button type="submit" name="edit">Edit</button>
									</form>
								</td>
								<td class="action-btns">
									<form action="" method="POST">
										<input type="hidden" name="id" value="<?php echo $row['teacherID']; ?>">
										<button type="submit" name="delete">Delete</button>
									</form>
								</td>
							</tr>
						<?php }
					} else {
						echo "0 results";
					}

					
				?>
			</tbody>
		</table>
	</div>



<!-- Admin Teacher Form ends -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>