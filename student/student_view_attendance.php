<?php
  include '../connection/_dbconnection.php';
  include '../connection/_session.php';
  //session_start();
  //echo "Welcome ".$_SESSION['userName'];
  $studentID = $_SESSION['userId'];
  $studentName = $_SESSION['userName'];

  if(isset($_POST['save'])) {
     if(isset($_POST['subject'])){
      $subjectstatus = true;
       $subjectID = $_POST['subject'];
       $attendanceQuery = "SELECT * FROM attendance
       WHERE studentID = '$studentID' AND subjectID = '$subjectID'";
      }
      elseif(isset($_POST['attendance_date'])){
       $datestatus = true;
       $date = $_POST['attendance_date'];
       $attendanceQuery = "SELECT s.subjectName, a.attendanceDate, a.attendanceStatus
       FROM attendance a
       JOIN `subject` s ON s.subjectID = a.subjectID
       JOIN enrollment e ON e.studentID = a.studentID AND e.subjectID = a.subjectID
       WHERE a.studentID = '$studentID' AND a.attendanceDate = '$date'";
      }
    
      $rst = $conn->query($attendanceQuery);
      if ($rst->num_rows == 0){
        echo "<script>alert('No Record Found!!!');</script>";
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
    <link rel="stylesheet" href="student_css/student_view_attendance.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->

</head>
<body>
<div class="heading">Attendance Management System</div>

<!-- Navbar starts -->
<header>
  <nav>
    <ul>
      <li><a href="student_home.php">Home</a></li>
      <li><a href="#">View Attendance</a></li>
      <li><a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>
<!-- Navbar ends -->


<!-- Nav Radio Container starts -->
<div class="nav_radio_container">
<form id="attendance-form-selector">
  <label><input type="radio" name="attendance" value="subject" onclick="showSubjectForm()">Subject</label>
  <label><input type="radio" name="attendance" value="date" onclick="showDateForm()">Date</label>
</form>

</div>

<!-- Nav Radio Container ends -->




<!-- Subject Selection Form starts -->
<div class="subject_form_container" id="subject-form" style="display: none;">
  <form method="POST">
  <label for="subject">Select Subject:</label>
    <select name="subject" id="subject" required>
      <option value="" disabled selected hidden>Select Subject</option>
      <?php
        $subjectQuery = "SELECT `subject`.subjectID, `subject`.subjectName, `subject`.courseID
        FROM enrollment
        INNER JOIN `subject` ON enrollment.subjectID = `subject`.subjectID
        WHERE enrollment.studentID = '$studentID'";
        $result = mysqli_query($conn, $subjectQuery);
        while($row = mysqli_fetch_assoc($result)) {
          echo '<option value="'.$row['subjectID'].'">'.$row['subjectName'].'</option>';
        }
      ?>
    </select>
    <div class="buttons">
      <button type="submit" name="save" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<!-- Subject Selection Form ends -->



<!-- Date Selection Form starts -->
<div class="date_form_container" id="date-form" style="display: none;">
  <form method="POST">
    <label>Select Date:</label>
    <input type="date" id="date" name="attendance_date">
    <div class="buttons">
      <button type="submit" name="save" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<!-- Date Selection Form ends -->



<!-- Attendance Display Form starts -->
<div class="attendance_container" id="attendance-form">

<?php
if (isset($rst)) {
  if(isset($subjectstatus)){
  $subjectQuery = "SELECT * FROM `subject` WHERE subjectID='$subjectID'";
  $subjectResult = $conn->query($subjectQuery);
  $subjectRow = $subjectResult->fetch_assoc();     //mysqli_fetch_assoc($subjectResult);
  $subjectName = $subjectRow['subjectName'];
  
  $courseQuery = "SELECT course.courseName 
  FROM course 
  JOIN `subject` ON course.courseID = `subject`.courseID 
  WHERE `subject`.subjectID = '$subjectID'";
  $courseResult = $conn->query($courseQuery);
  $courseRow = $courseResult->fetch_assoc(); 
  $courseName = $courseRow['courseName'];
  echo '<h2>'.$studentName.'</h2>';
  echo '<h2>'.$studentID.'</h2>';
  echo '<h2>'.$courseName.' - '.$subjectName.'</h2>';
  if ($rst->num_rows > 0) { // Check if there are any records in the result
   
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Sr. No.</th>';
    echo '<th>Attendance Date</th>';
    echo '<th>Attendance Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $count = 0;
    //$attendanceRow = [];
    while($attendanceRow = $rst->fetch_assoc()) {
      $count++;
      echo '<tr>';
      echo '<td>'.$count.'</td>';
      echo '<td>'.$attendanceRow['attendanceDate'].'</td>';
      echo '<td>'.$attendanceRow['attendanceStatus'].'</td>';
      echo '</tr>';
      
    }

    echo '</tbody>';
    echo '</table>';
    echo '<br/><br/>';
    // Check if all records are fetched and displayed
    $attendanceRow = $rst->fetch_assoc();
    if (!$attendanceRow) {
        echo '<button onclick="printDiv()">Print</button>';

    }
    $subjectstatus = false;
  }
    else{
      echo "No Record Found!!";
    } 
  } //subjectstatus if ends
  elseif(isset($datestatus)){
    $courseQuery = "SELECT DISTINCT course.courseName
    FROM enrollment 
    INNER JOIN `subject` ON enrollment.subjectID = `subject`.subjectID 
    INNER JOIN course ON `subject`.courseID = course.courseID 
    WHERE enrollment.studentID = '$studentID'";
    $courseResult = $conn->query($courseQuery);
    $courseRow = $courseResult->fetch_assoc(); 
    $courseName = $courseRow['courseName'];

    echo '<h2>'.$studentName.'</h2>';
    echo '<h2>'.$studentID.'</h2>';
    echo '<h2>'.$courseName.'-'.$date.'</h2>';
    if ($rst->num_rows > 0) { // Check if there are any records in the result
   
      echo '<table>';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Sr. No.</th>';
      echo '<th>Subject</th>';
      echo '<th>Attendance Date</th>';
      echo '<th>Attendance Status</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
  
      $count = 0;
      //$attendanceRow = [];
      while($attendanceRow = $rst->fetch_assoc()) {
        $count++;
        echo '<tr>';
        echo '<td>'.$count.'</td>';
        echo '<td>'.$attendanceRow['subjectName'].'</td>';
        echo '<td>'.$attendanceRow['attendanceDate'].'</td>';
        echo '<td>'.$attendanceRow['attendanceStatus'].'</td>';
        echo '</tr>';
        
      }
  
      echo '</tbody>';
      echo '</table>';
      echo '<br/><br/>';
      // Check if all records are fetched and displayed
      $attendanceRow = $rst->fetch_assoc();
      if (!$attendanceRow) {
          echo '<button onclick="printDiv()">Print</button>';
  
      }
    } 
    else{
      echo "No Record Found!!";
    } 
  } //datestatus elseif ends




}
?>

</div>

<!-- Attendance Display Form ends -->


























<!-- Student Login Form starts -->
<!-- <div class="container">
		<h1>Student Login</h1>
		<form method="POST" action="">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>

			<button type="submit">Login</button>
		</form>
	</div>
 -->


<!-- Student Login Form ends -->




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
const attendanceContainer = document.getElementById('attendance-form');

// Listen for click events on the radio buttons
subjectRadio.addEventListener('click', () => {
  // Hide the attendance container
  attendanceContainer.style.display = 'none';
});

dateRadio.addEventListener('click', () => {
  // Hide the attendance container
  attendanceContainer.style.display = 'none';
});
</script>


<!-- Display Hide JavaScript ends -->


<!-- JS script for printing the div -->
<script type="text/javascript">
function printDiv(){
var printContents = document.getElementsByClassName("attendance_container")[0].innerHTML;
var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>


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









<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->

</body>
</html>