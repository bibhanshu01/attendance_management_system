<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';
  //session_start();
  //echo "Welcome ".$_SESSION['userName'];
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
  $studentName=$_POST['name'];
  $studentID=$_POST['roll_number'];
  $studentEmail=$_POST['email'];
  $courseID=$_POST['course'];
  $studentpassword=$_POST['password'];
   
    $query=mysqli_query($conn,"select * from student where studentID ='$studentID'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

      echo "<script>alert('This roll number is already registered.');</script>";
    }
    else{

    // $query=mysqli_query($conn,"insert into tblstudents(firstName,lastName,otherName,admissionNumber,password,classId,classArmId,dateCreated) 
    // value('$firstName','$lastName','$otherName','$admissionNumber','12345','$classId','$classArmId','$dateCreated')");
    
    $query_st=mysqli_query($conn,"INSERT INTO student(studentID, studentName, studentEmail, studentpassword) 
    VALUES('$studentID', '$studentName', '$studentEmail', '$studentpassword')");
    
    $query_er=mysqli_query($conn,"INSERT INTO enrollment (enrollmentID, studentID, subjectID)
    SELECT ROW_NUMBER() OVER () + (SELECT COUNT(*) FROM enrollment) AS enrollmentID, '$studentID', subjectID
    FROM subject
    WHERE courseID = '$courseID'");

    if ($query_st && $query_er) {
        
      echo "<script>alert('Registered Successfully!.');</script>";  
      //$statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
            
    }
    else
    {
      echo "<script>alert('An Error Occurred!.');</script>";
      //$statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}






?>



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
      <li><a href="../admin_teacher/admin_teacher.php">Teacher</a></li>
      <li><a href="../admin_course/admin_course.php">Course</a></li>
      <li><a href="../admin_subject/admin_subject.php">Subject</a></li>
      <li><a href="../admin_attendance/admin_attendace.php">Attendance</a></li>
      <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Student Registration Form starts -->
<div class="container">
		<h2>Student Registration</h2>
		<form action="" method="POST">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder="Enter Name">

			<label for="roll_number">Roll Number:</label>
			<input type="text" id="roll_number" name="roll_number" placeholder="Enter Roll Number">

			<label for="email">Email:</label>
			<input type="text" id="email" name="email" placeholder="Enter Email Address">

			<label for="course">Course ID:</label>
			<input type="text" id="course" name="course" placeholder="Enter Course ID">

      <label for="password">Password:</label>
			<input type="text" id="password" name="password" required placeholder="Enter Password">



			<button type="submit" name="submit">Register</button>
		</form>
	</div>



<!-- Student Registration Form ends -->


<!-- Student Table Display starts -->
<?php
// Retrieve student information from the database
$query =  "SELECT DISTINCT student.studentID, student.studentName, student.studentEmail,
 student.studentpassword, course.courseName FROM student JOIN enrollment ON enrollment.studentID = student.studentID 
 JOIN subject ON subject.subjectID = enrollment.subjectID JOIN course ON course.courseID = subject.courseID";

$result = $conn->query($query);
$num = $result->num_rows;

// Check if any results were returned
if($num > 0) {
    // Display the table header
    echo "<table><tr><th>Student ID</th><th>Student Name</th><th>Student Email</th><th>Password</th><th>Course</th></tr>";
    
    // Loop through each row of data and display it in the table
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["studentID"]."</td><td>".$row["studentName"]."</td><td>".$row["studentEmail"]."</td><td>".$row["studentpassword"]."</td><td>".$row["courseName"]."</td></tr>";
    }
    
    // Close the table
    echo "</table>";
} else {
    // If no results were returned, display a message
    echo "<script>alert('No Students Found!.');</script>";
}

// Close the database connection
mysqli_close($conn);
?>


<!-- Student Table Display ends -->



<!-- Student Table Display starts -->
<!-- <table>
  <caption>STUDENTS</caption>
  <thead>
    <tr>
      <th>Roll No.</th>
      <th>Student Name</th>
      <th>Student Email</th>
      <th>Password</th>
      <th>Course</th>
    </tr>
  </thead>
  <tbody>
    <!-- <?php
      // Retrieve student information from the database
      $query =  "SELECT DISTINCT student.studentID, student.studentName, student.studentEmail,
      student.studentpassword, course.courseName FROM student JOIN enrollment ON enrollment.studentID = student.studentID 
      JOIN subject ON subject.subjectID = enrollment.subjectID JOIN course ON course.courseID = subject.courseID";

      $result = $conn->query($query);
      $num = $result->num_rows;

      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['studentID'] . "</td>";
        echo "<td>" . $row['studentName'] . "</td>";
        echo "<td>" . $row['studentEmail'] . "</td>";
        echo "<td>" . $row['studentpassword'] . "</td>";
        echo "<td>" . $row['course'] . "</td>";
        echo "</tr>";
      }
    ?> -->
  </tbody>
</table> -->
    
<!-- Student Table Display ends -->














<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>



