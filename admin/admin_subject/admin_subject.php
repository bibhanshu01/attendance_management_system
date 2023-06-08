<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';

   // Code to get the details of selected subject and fill the form fields
   if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    //$sql = "SELECT * FROM `subject` WHERE courseID = '$id'";
    $sql = "SELECT * FROM `subject` WHERE subjectID = '$id'";
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
    <link rel="stylesheet" href="admin_subject_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="heading">Attendance Management System</div>

<header>
  <nav>
    <ul>
      <li><a href="#">Admin</a></li>
	  <li><a href="../admin_course/admin_course.php">Course</a></li>
      <li><a href="#">Subject</a></li>
      <li><a href="../admin_student/admin_student.php">Student</a></li>
      <li><a href="../admin_teacher/admin_teacher.php">Teacher</a></li>
      <li><a href="../admin_attendance/admin_attendance.php">Attendance</a></li>
      <li><a href="../../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Subject Form starts -->
<div class="container">
	<h2>Add Subjects</h2>
	<form method="post" action="">

		<label for="subjectID">Subject ID:</label>
		<input type="text" id="subjectID" name="subjectID" value="<?php echo isset($row) ? $row['subjectID'] : '';?>" required placeholder="Enter Subject ID">
		
		<label for="subjectName">Subject Name:</label>
		<input type="text" id="subjectName" name="subjectName" value="<?php echo isset($row) ? $row['subjectName'] : '';?>" required placeholder="Enter Subject Name">
		
		<label for="courseID">Course ID:</label>
		<input type="text" id="courseID" name="courseID" value="<?php echo isset($row) ? $row['courseID'] : '';?>" required placeholder="Enter Course ID">

		<div class="buttons">
		<?php
            if (isset($row))
            {
        ?>
        <input type="hidden" name="UID" value="<?php echo $row['subjectID']; ?>">
        <button type="submit" name="update" class="btn btn-warning">Update</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
        <?php
            } else {           
        ?>
        <button type="submit" name="save" class="btn btn-primary">Save</button>
        <?php
            }         
        ?>
		<button type="reset" id="clearButton" name="clearButton" onclick="resetFormFields()" class="btn btn-secondary">Clear</button>
		</div>

	</form>
</div>

<div class="subject_container">
	<h2>Subjects</h2>
	<table>
		<thead>
			<tr>
				<th>Sr. No.</th>
				<th>Subject ID</th>
				<th>Subject Name</th>
				<th>Course ID</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
		<?php
				// If form submitted, insert data into database
				if (isset($_POST['save'])) {
					$subjectID = $_POST['subjectID'];
					$subjectName = $_POST['subjectName'];
					$courseID = $_POST['courseID'];
				

					$query=mysqli_query($conn,"select * from subject where subjectID ='$subjectID'");
					$ret=mysqli_fetch_array($query);

					if($ret > 0){ 

						echo "<script>alert('Already registered.');</script>";
					}
					else{
						$sql = "INSERT INTO `subject` (subjectID, subjectName, courseID)
						VALUES ('$subjectID', '$subjectName', '$courseID')";

						if ($conn->query($sql) === TRUE) {
							echo "<script>alert('Registered Successfully!');</script>";
						} 
						else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}

					}

					
				}

				//update and delete
				if (isset($_POST['update'])) {
					$id = $_POST['UID'];    //UID is id of Update button
					$subjectID = $_POST['subjectID'];
					$subjectName = $_POST['subjectName'];
					$courseID = $_POST['courseID'];

					$query = "UPDATE `subject` SET `subjectID`='$subjectID', `subjectName`='$subjectName', `courseID`='$courseID' WHERE `subjectID`='$id'";
					$result = mysqli_query($conn, $query);
					if($result) {
						echo "<script>alert('Subject Details Updated Successfully!');</script>";
					} else {
						echo "<script>alert('Updation Failed!!!');</script>";
					}
				}

				if (isset($_POST['delete'])) {
					$id = $_POST['id'];

					$query = "DELETE FROM `subject` WHERE `subjectID`='$id'";
					$result = mysqli_query($conn, $query);
					if($result) {
						echo "<script>alert('Subject Deleted Successfully!');</script>";
					} else {
						echo "<script>alert('Deletion Failed!!!');</script>";
					}
				}










			// Fetch subjects from database and display in table
			$sql = "SELECT * FROM `subject`";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				$i = 1;
				while ($row = $result->fetch_assoc()) { ?>
					<tr>
						<td><?php echo $i++; ?></td> 
						<td><?php echo $row['subjectID']; ?></td>
						<td><?php echo $row['subjectName']; ?></td>
						<td><?php echo $row['courseID']; ?></td>
						<td class="action-btns">
							<form action="" method="POST">
								<input type="hidden" name="id" value="<?php echo $row['subjectID']; ?>">
								<button type="submit" name="edit">Edit</button>
							</form>
						</td>
						<td class="action-btns">
							<form action="" method="POST">
								<input type="hidden" name="id" value="<?php echo $row['subjectID']; ?>">
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