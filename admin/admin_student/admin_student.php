<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';
  require '../../vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  //session_start();
  //echo "Welcome ".$_SESSION['userName'];
  // if($_SERVER["REQUEST_METHOD"] == "POST")
  if(isset($_POST['submit'])){
    $studentID=$_POST['roll_number'];
    $studentName=$_POST['name'];
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
      FROM `subject`
      WHERE courseID = '$courseID'");
  
      if ($query_st && $query_er) {
          
        echo "<script>alert('Registered Successfully!.');</script>";  
              
      }
      else
      {
        echo "<script>alert('An Error Occurred!.');</script>";
       
      }
    }
  }
  
  if(isset($_POST['fsubmit'])){

    if(isset($_FILES['excel_file']['name']) && !empty($_FILES['excel_file']['name'])){

    $fileName = $_FILES['excel_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext)){

      $inputFileNamePath = $_FILES['excel_file']['tmp_name'];

      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
      //$spreadsheet = IOFactory::createReader($inputFileNamePath);

      $data= $spreadsheet->getActiveSheet()->toArray();

      $count ="0";
      foreach($data as $row){

        if($count > 0){
          $studentID = $row['0'];
          $studentName = $row['1'];
          $studentEmail = $row['2'];
          $courseID = $row['3'];
          $studentpassword = $row['4'];
          
          $query=mysqli_query($conn,"select * from student where studentID ='$studentID'");
          $ret=mysqli_fetch_array($query);
  
          if($ret > 0){ 
  
            echo "<script>alert('Trying To Register Duplicate Data!!!');</script>";
          }
          else{
  
    
      
            $query_st=mysqli_query($conn,"INSERT INTO student(studentID, studentName, studentEmail, studentpassword) 
            VALUES('$studentID', '$studentName', '$studentEmail', '$studentpassword')");
      
            $query_er=mysqli_query($conn,"INSERT INTO enrollment (enrollmentID, studentID, subjectID)
            SELECT ROW_NUMBER() OVER () + (SELECT COUNT(*) FROM enrollment) AS enrollmentID, '$studentID', subjectID
            FROM `subject`
            WHERE courseID = '$courseID'");
  
            $msg = true;
          } 

        } //is count > 0 ends
        else{
          $count = "1";
        }

      } //foreach ends

      if(isset($msg)){
        echo "<script>alert('Students Registered Successfully.');</script>";
      }
      else
      {
        echo "<script>alert('Some Error Occurred!.');</script>";

      }



    } //if allowed ends
    else{
      echo "<script>alert('Invalid File Format!!!');</script>";
    }
   
  } //file presence and filename check
  else{
    echo "<script>alert('File Is Missing Or Invalid File Format!!!');</script>";
  }



  } //is fsubmit ends
 
  



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
      <li><a href="../admin_course/admin_course.php">Course</a></li>
      <li><a href="../admin_subject/admin_subject.php">Subject</a></li>
      <li><a href="#">Student</a></li>
      <li><a href="../admin_teacher/admin_teacher.php">Teacher</a></li>
      <li><a href="../admin_attendance/admin_attendance.php">Attendance</a></li>
      <li><a href="../../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>


<!-- Student Registration Form starts -->
<div class="container">
    <h2>Student Registration</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <input type="radio" id="file_registration" name="registration_type" checked>
            <label for="file_registration">File Registration</label>
        </div>
        <div class="file_registration">
            <label for="excel_file">Upload Excel:</label>
            <input type="file" id="excel_file" name="excel_file">
        </div>

        <div>
            <input type="radio" id="manual_registration" name="registration_type">
            <label for="manual_registration">Manual Registration</label>
        </div>
        <div class="manual_registration" style="display:none;">
            <label for="roll_number">Roll Number:</label>
            <input type="text" id="roll_number" name="roll_number" placeholder="Enter Roll Number">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter Name">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter Email Address">

            <label for="course">Course ID:</label>
            <input type="text" id="course" name="course" placeholder="Enter Course ID">

            <label for="password">Password:</label>
            <input type="text" maxlength="50" id="password" name="password" placeholder="Enter Password">
        </div>

        <div class="buttons">
            <button type="submit" id="fsubmit" name="fsubmit">Register</button>
            <button type="submit" id="msubmit" name="submit" style="display:none;">Register</button>
            <button type="reset" id="clearButton" name="clearButton" onclick="resetFormFields()" class="btn btn-secondary" style="display:none;">Clear</button>
        </div>
    </form>
</div>




<!-- Student Registration Form ends -->













<!-- Student Registration Form starts -->
<!-- <div class="container">
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
		<input type="text" maxlength="50" id="password" name="password" required placeholder="Enter Password">

    <div class="buttons">

			<button type="submit" name="submit">Register</button>
      <button type="reset" id="clearButton" name="clearButton" onclick="resetFormFields()" class="btn btn-secondary">Clear</button>
    </div>
	</form>
</div> -->



<!-- Student Registration Form ends -->


<!-- Student Table Display starts -->
<?php
// Retrieve student information from the database
$query =  "SELECT DISTINCT student.studentID, student.studentName, student.studentEmail,
 student.studentpassword, course.courseName FROM student JOIN enrollment ON enrollment.studentID = student.studentID 
 JOIN `subject` ON `subject`.subjectID = enrollment.subjectID JOIN course ON course.courseID = `subject`.courseID";

$result = $conn->query($query);
$num = $result->num_rows;

// Check if any results were returned
if($num > 0) {
    // Display the table header
    echo "<table><tr><th>Roll Number</th><th>Student Name</th><th>Student Email</th><th>Password</th><th>Course</th></tr>";
    
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
     <?php
      // Retrieve student information from the database
    //   $query =  "SELECT DISTINCT student.studentID, student.studentName, student.studentEmail,
    //   student.studentpassword, course.courseName FROM student JOIN enrollment ON enrollment.studentID = student.studentID 
    //   JOIN subject ON subject.subjectID = enrollment.subjectID JOIN course ON course.courseID = subject.courseID";

    //   $result = $conn->query($query);
    //   $num = $result->num_rows;

    //   while($row = $result->fetch_assoc()) {
    //     echo "<tr>";
    //     echo "<td>" . $row['studentID'] . "</td>";
    //     echo "<td>" . $row['studentName'] . "</td>";
    //     echo "<td>" . $row['studentEmail'] . "</td>";
    //     echo "<td>" . $row['studentpassword'] . "</td>";
    //     echo "<td>" . $row['course'] . "</td>";
    //     echo "</tr>";
    //   }
    // ?> 
  </tbody>
</table> -->
    
<!-- Student Table Display ends -->



<!-- JavaScript Code For File And Manual Registration Radio starts -->
<script>
const fileRegistrationRadio = document.getElementById('file_registration');
const manualRegistrationRadio = document.getElementById('manual_registration');
const msubmitButton = document.getElementById('msubmit');
const mclearButton = document.getElementById('clearButton');
const fsubmitButton = document.getElementById('fsubmit');

const fileRegistrationDiv = document.querySelector('.file_registration');
const manualRegistrationDiv = document.querySelector('.manual_registration');

fileRegistrationRadio.addEventListener('click', () => {
  fileRegistrationDiv.style.display = 'block';
  manualRegistrationDiv.style.display = 'none';
  msubmitButton.style.display = 'none';
  mclearButton.style.display = 'none';
  fsubmitButton.style.display = 'inline-block';
});

manualRegistrationRadio.addEventListener('click', () => {
  manualRegistrationDiv.style.display = 'block';
  fileRegistrationDiv.style.display = 'none';
  msubmitButton.style.display = 'inline-block';
  mclearButton.style.display = 'inline-block';
  fsubmitButton.style.display = 'none';
});


</script>


<!-- JavaScript Code For File And Manual Registration Radio ends -->








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










<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>



