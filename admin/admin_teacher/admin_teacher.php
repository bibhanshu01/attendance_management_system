<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';

   // Code to get the details of selected teacher and fill the form fields
   if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM teacher WHERE teacherID = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
  }

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

<!-- Navbar starts -->
<header>
  <nav>
    <ul>
      <li><a href="#">Admin</a></li>
	  <li><a href="../admin_course/admin_course.php">Course</a></li>
      <li><a href="../admin_subject/admin_subject.php">Subject</a></li>
      <li><a href="../admin_student/admin_student.php">Student</a></li>
      <li><a href="#">Teacher</a></li>
      <li><a href="../admin_attendance/admin_attendance.php">Attendance</a></li>
      <li><a href="../../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>
<!-- Navbar ends -->



<!-- Nav Radio Container starts -->
<div class="nav_radio_container">
<form id="attendance-form-selector">
  <label><input type="radio" name="attendance" value="subject" onclick="showSubjectForm()">Registration</label>  <!-- Subject initially -->
  <label><input type="radio" name="attendance" value="date" onclick="showDateForm()">Assign Subject</label>    <!-- Date initially -->
</form>

</div>

<!-- Nav Radio Container ends -->



























<!-- Admin Teacher Form starts -->
<div class="subject_form_container" id="subject-form" style="display: none;">
	<div class="container">
		<h2>Teacher Registration</h2>
			<form action="" method="POST">

			 	<label for="tid">Teacher ID:</label>
			 	<input type="text" id="tid" maxlength="10" name="tid" value="<?php echo isset($row) ? $row['teacherID'] : '';?>" required placeholder="Enter Teacher ID">

				<label for="name">Name:</label>
				<input type="text" id="name" name="name" value="<?php echo isset($row) ? $row['teacherName'] : '';?>" required placeholder="Enter Name">

				<label for="email">Email:</label>
				<input type="text" id="email" name="email" value="<?php echo isset($row) ? $row['teacherEmail'] : '';?>" required placeholder="Enter Email Address">

    			<label for="password">Password:</label>
				<input type="text" id="password" maxlength="50" name="password" value="<?php echo isset($row) ? $row['teacherpassword'] : '';?>" required placeholder="Enter Password">

				<div class="buttons">
					<?php
            			if (isset($row))
                		{
            		?>
                	<input type="hidden" name="id" value="<?php echo $row['teacherID']; ?>">
                	<button type="submit" name="updateteacher" class="btn btn-warning">Update</button>
                	<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
            		<?php
                		} else {           
            		?>
                	<button type="submit" name="saveteacher" class="btn btn-primary">Save</button>
            		<?php
                 		}         
            		?>

					<button type="reset" id="clearButton" name="clearButton" onclick="resetFormFields()" class="btn btn-secondary">Clear</button>

				</div>



				<!-- <label for="tid">Teacher ID:</label>
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
            	?> -->

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
					if (isset($_POST['saveteacher'])) {
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
								echo "<script>alert('Teacher Registered Successfully!');</script>";
							} 
							else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}

						}

						
					}

					//update and delete
					if (isset($_POST['updateteacher'])) {
						$id = $_POST['id'];
						$teacherID = $_POST['tid'];
						$teacherName = $_POST['name'];
						$teacherEmail = $_POST['email'];
						$teacherpassword = $_POST['password'];
	
						$query = "UPDATE `teacher` SET `teacherID`='$teacherID', `teacherName`='$teacherName', `teacherEmail`='$teacherEmail', `teacherpassword`='$teacherpassword' WHERE `teacherID`='$id'";
						$result = mysqli_query($conn, $query);
						if($result) {
							echo "<script>alert('Teacher Details Updated Successfully!');</script>";
						} else {
							echo "<script>alert('Updation Failed!!!');</script>";
						}
					}
	
					if (isset($_POST['deleteteacher'])) {
						$id = $_POST['id'];
	
						$query = "DELETE FROM `teacher` WHERE `teacherID`='$id'";
						$result = mysqli_query($conn, $query);
						if($result) {
							echo "<script>alert('Teacher Deleted Successfully!');</script>";
						} else {
							echo "<script>alert('Deletion Failed!!!');</script>";
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
										<button type="submit" name="deleteteacher">Delete</button>
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
</div>
<!-- Admin Teacher Form ends -->




<!-- Subject Assignment starts(ShowDate) -->

<div class="date_form_container" id="date-form" style="display: none;">
<form method="POST">
<label for="teacher">Select Teacher:</label>
    <select name="teacher" id="teacher" required>
      <option value="" disabled selected hidden>Select Teacher</option>
      <?php
        $teacherQuery = "SELECT * FROM teacher";
        $result = mysqli_query($conn, $teacherQuery);
        while($row = mysqli_fetch_assoc($result)) {
          echo '<option value="'.$row['teacherID'].'">'.$row['teacherName'].'</option>';
        }
      ?>
    </select>
  <label for="subject">Select Subject:</label>
    <select name="subject" id="subject" required>
      <option value="" disabled selected hidden>Select Subject</option>
      <?php
        $subjectQuery = "SELECT * FROM `subject`";
        $result = mysqli_query($conn, $subjectQuery);
        while($row = mysqli_fetch_assoc($result)) {
          echo '<option value="'.$row['subjectID'].'">'.$row['subjectName'].'</option>';
        }
      ?>
    </select>
    <div class="buttons">
      <button type="submit" name="saveassignment" class="btn btn-primary">Submit</button>
    </div>
  </form>



</div>






<!-- Subject Assignment ends(ShowDate) -->


<!-- Attendance Display Form starts -->
<div class="attendance_container" id="attendance-form" style="display: none;">
<div class="teacher_container">
		<h2>Teacher-Subject Assignment</h2>
		<table>
			<thead>
				<tr>
					<th>Sr. No.</th> 
					<th>Teacher ID</th>
					<th>Teacher Name</th>
					<th>Subject ID</th>
					<th>Subject Name</th>
					<!-- <th>Edit</th> -->
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					
					// If form submitted, insert data into teacher_subject table
					if (isset($_POST['saveassignment'])) {
						$teacherID = $_POST['teacher'];
						$subjectID = $_POST['subject'];

						$teacherQuery = "SELECT * FROM teacher_subject WHERE teacherID = '$teacherID' AND subjectID = '$subjectID'";
						$query=mysqli_query($conn, $teacherQuery);
						$ret=mysqli_fetch_array($query);

						if($ret > 0){ 

							echo "<script>alert('Already Assigned!!!');</script>";
						}
						else{
							$sql = "INSERT INTO teacher_subject (teacherID, subjectID)
							 VALUES ('$teacherID', '$subjectID')";

							if ($conn->query($sql) === TRUE) {
								echo "<script>alert('Subject Assigned Successfully!');</script>";
							} 
							else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}

						}

						
					}

					//update
					// if (isset($_POST['update'])) {
					// 	$id = $_POST['id'];
					// 	$teacherID = $_POST['tid'];
					// 	$teacherName = $_POST['name'];
					// 	$teacherEmail = $_POST['email'];
					// 	$teacherpassword = $_POST['password'];
	
					// 	$query = "UPDATE `teacher` SET `teacherID`='$teacherID', `teacherName`='$teacherName', `teacherEmail`='$teacherEmail', `teacherpassword`='$teacherpassword' WHERE `teacherID`='$id'";
					// 	$result = mysqli_query($conn, $query);
					// 	if($result) {
					// 		echo "<script>alert('Teacher Details Updated Successfully!');</script>";
					// 	} else {
					// 		echo "<script>alert('Updation Failed!!!');</script>";
					// 	}
					// }
					
					//delete
					if (isset($_POST['deleteassignment'])) {
						$teacherID = $_POST['teacherID'];
    					$subjectID = $_POST['subjectID'];
	
						$query = "DELETE FROM teacher_subject 
						WHERE teacherID = '$teacherID' 
						AND subjectID = '$subjectID'";
						$result = mysqli_query($conn, $query);
						if($result) {
							echo "<script>alert('Subject Unassigned Successfully!');</script>";
						} else {
							echo "<script>alert('Subject Unassignment Failed!!!');</script>";
						}
					}


                    
                    // Fetch data from database and display in table
					$sql = "SELECT teacher.teacherID, teacher.teacherName, `subject`.subjectID, `subject`.subjectName
					FROM teacher_subject 
					INNER JOIN teacher ON teacher_subject.teacherID = teacher.teacherID 
					INNER JOIN `subject` ON teacher_subject.subjectID = `subject`.subjectID";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						$i = 1;
						while($row = $result->fetch_assoc()) { ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['teacherID']; ?></td>
								<td><?php echo $row['teacherName']; ?></td>
								<td><?php echo $row['subjectID']; ?></td>
								<td><?php echo $row['subjectName']; ?></td>
								<!-- <td class="action-btns">
									<form action="" method="POST">
										<input type="hidden" name="id" value="<?php echo $row['teacherID']; ?>">
										<button type="submit" name="edit">Edit</button>
									</form>
								</td> -->
								<td class="action-btns">
									<form action="" method="POST">
										<input type="hidden" name="teacherID" value="<?php echo $row['teacherID']; ?>">
                    					<input type="hidden" name="subjectID" value="<?php echo $row['subjectID']; ?>">
										<button type="submit" name="deleteassignment">Delete</button>
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


</div>






























<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>



<!-- Display Hide JavaScript starts -->
<script>
function showSubjectForm() {
// Hide existing form
// document.getElementById("attendance-form").style.display = "none";

// Show subject form
document.getElementById("subject-form").style.display = "block";

// Hide date form
document.getElementById("date-form").style.display = "none";
}

function showDateForm() {
// Hide existing form
// document.getElementById("attendance-form").style.display = "none";

// Hide subject form
document.getElementById("subject-form").style.display = "none";

// Show date form
document.getElementById("date-form").style.display = "block";
}



</script>


<script>
const subjectRadio = document.querySelector('input[value="subject"]');
const dateRadio = document.querySelector('input[value="date"]');
const attendanceContainer = document.getElementById('date-form');
const assignmentContainer = document.getElementById('attendance-form');

// Listen for click events on the radio buttons
subjectRadio.addEventListener('click', () => {
  // Hide the attendance container
  attendanceContainer.style.display = 'none';
  assignmentContainer.style.display = 'none';
});

dateRadio.addEventListener('click', () => {
  // Hide the attendance container
  attendanceContainer.style.display = 'block';
  assignmentContainer.style.display = 'block';
});
</script>


<!-- Display Hide JavaScript ends -->



<script>
  function resetAttendanceForm() {
    const selector = document.getElementById("attendance-form-selector");
    const radios = selector.querySelectorAll("input[name=attendance]");

    radios.forEach((radio) => {
      radio.checked = false;
    })
  }

  document.getElementById("subject-form").addEventListener("click", resetAttendanceForm);
  document.getElementById("date-form").addEventListener("click", resetAttendanceForm);
</script>

























<!-- Clear Button Code starts -->

<script>
	function resetFormFields() {
    // Replace these selectors with the appropriate selectors for your form fields
      var inputFields = document.querySelectorAll('input[type="text"]');
  
      // Loop through all the input fields and set their values to empty strings
      for (var i = 0; i < inputFields.length; i++) {
        inputFields[i].value = '';
      }
  }

  document.getElementById('clearButton').addEventListener('click', function() {
      // Call the resetFormFields function to reset all the form fields
      resetFormFields();
  
  });



</script>

<!-- Clear Button Code ends -->




</body>
</html>