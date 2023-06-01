<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';


  if(isset($_POST['save'])) {
    $courseID = $_POST['course'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['attendance_date'];
   // $allAttendance = isset($_POST['attendance_type']) ? false : true; //rearranged
   // echo $allAttendance;
   if(isset($_POST['attendance_type'])){
    $selected_radio = $_POST['attendance_type'];
    if($selected_radio == "All") {
      // $attendanceQuery = "SELECT * FROM attendance WHERE subjectID='$subjectID'";
         $attendanceQuery = "SELECT student.studentID, student.studentName, `subject`.subjectName, attendance.attendanceDate, attendance.attendanceStatus
         FROM attendance
         INNER JOIN student
         ON attendance.studentID = student.studentID
         INNER JOIN `subject`
         ON attendance.subjectID = `subject`.subjectID
         WHERE `subject`.courseID = '$courseID'
         AND `subject`.subjectID = '$subjectID'";
    } elseif($selected_radio == "Single") {
      // $attendanceQuery = "SELECT * FROM attendance WHERE subjectID='$subjectID' AND attendanceDate='$attendanceDate'";
         $attendanceQuery = "SELECT student.studentID, student.studentName, `subject`.subjectName, attendance.attendanceDate, attendance.attendanceStatus
         FROM attendance
         INNER JOIN student
         ON attendance.studentID = student.studentID
         INNER JOIN `subject`
         ON attendance.subjectID = `subject`.subjectID
         WHERE `subject`.courseID = '$courseID'
         AND `subject`.subjectID = '$subjectID'
         AND attendance.attendanceDate = '$attendanceDate'";
      }
   
      $rst = $conn->query($attendanceQuery);
  
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
    <link rel="stylesheet" href="admin_attendance_style.css">
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
      <li><a href="../admin_student/admin_student.php">Student</a></li>
      <li><a href="../admin_teacher/admin_teacher.php">Teacher</a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="../../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Admin Login Form starts -->
<!-- <div class="container"> -->
		<!-- <h1>Admin Login</h1>
		<form method="POST" action="">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>

			<button type="submit">Login</button>
		</form>
	</div> -->



<!-- Admin Login Form ends -->

<div class="container">
  <form method="POST" action="">
    <label for="course">Select Course:</label>
    <select name="course" id="course" required>
      <option value="" disabled selected hidden>Select Course</option>
      <?php
        $courseQuery = "SELECT * FROM course";
        $result = mysqli_query($conn, $courseQuery);
        while($row = mysqli_fetch_assoc($result)) {
          echo '<option value="'.$row['courseID'].'">'.$row['courseName'].'</option>';
        }
      ?>
    </select>

    <label for="subject">Select Subject:</label>
    <select name="subject" id="subject" required>
      <option value="" disabled selected hidden>Select Subject</option>
    </select>
    


    <br/><br/>
    <input type="radio" id="single_day" name="attendance_type" value="Single" checked>
    <label for="single_day" id="label_single">Select Date:</label>
    <label for="date"></label>
    <input type="date" id="attendance_date" name="attendance_date">
   
    <br/><br/>

    <input type="radio" id="all" name="attendance_type" value="All">     
    <label for="all" id="label_all">All</label>




    <!-- <br/><br/>
    <input type="radio" id="single_day" name="attendance_type" value="Single" checked>
    <label for="single_day" id="label_single">One Day Attendance</label>
    
    
    <input type="radio" id="all" name="attendance_type" value="All">     
    <label for="all" id="label_all">All</label>

    <br/><br/>
    <div id="attendance_date">
      <label for="date">Select Date:</label>
      <input type="date" id="attendance_date" name="attendance_date">
    </div> -->

    <br/><br/>
    <div class="buttons">
      <button type="submit" name="save" class="btn btn-primary">Submit</button>
      <button type="reset" name="reset">Reset</button>
    </div>
  </form>
</div>
<div class="attendance_container">
<?php
if (isset($rst)) {
  //$attendanceRow = $rst->fetch_assoc();
  $subjectQuery = "SELECT * FROM `subject` WHERE subjectID='$subjectID'";
  $subjectResult = mysqli_query($conn, $subjectQuery);
  $subjectRow = $subjectResult->fetch_assoc();     //mysqli_fetch_assoc($subjectResult);
  $subjectName = $subjectRow['subjectName'];
  
  $courseQuery = "SELECT courseName FROM course WHERE courseID = '$courseID'";
  $courseResult = mysqli_query($conn, $courseQuery);
  $courseRow = $courseResult->fetch_assoc(); 
  $courseName = $courseRow['courseName'];
  echo '<h2>'.$courseName.' - '.$subjectName.'</h2>';
  //echo $attendance['studentID'];
  if ($rst->num_rows > 0) { // Check if there are any records in the result
   
    //echo '<table id="attendanceTable">';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Sr. No.</th>';
    echo '<th>Roll No.</th>';
    echo '<th>Student Name</th>';
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
      echo '<td>'.$attendanceRow['studentID'].'</td>';
      echo '<td>'.$attendanceRow['studentName'].'</td>';
      echo '<td>'.$attendanceRow['attendanceDate'].'</td>';
      echo '<td>'.$attendanceRow['attendanceStatus'].'</td>';
      echo '</tr>';
      
      // Get the next row
     
        //$attendanceRow = $rst->fetch_assoc();
    }

    echo '</tbody>';
    echo '</table>';
    echo '<br/><br/>';
    // Check if all records are fetched and displayed
    $attendanceRow = $rst->fetch_assoc();
    if (!$attendanceRow) {
      //echo '<button onclick="printTable()">Print</button>';
        //echo '<button onclick="window.print()">Print</button>';
        echo '<button onclick="printDiv()">Print</button>';

    }
    // if ($attendanceRow->num_rows = 0){
      // echo '<button onclick="window.print()">Print</button>';
    //}
  } else {
    //echo 'No attendance records found.';
    echo "<script>alert('No Record Found!!!');</script>";
  }
}

























// if (isset($result)) {
//   // $subjectQuery = "SELECT * FROM `subject` WHERE subjectID='$subjectID'";
//   // $subjectResult = mysqli_query($conn, $subjectQuery);
//   // $subjectRow = mysqli_fetch_assoc($subjectResult);
//   $attendanceRow = $result->fetch_assoc();
//   echo '<h2>'.$courseID.' - '.$attendanceRow['subjectName'].'</h2>';
//   echo '<table>';
//   echo '<thead>';
//   echo '<tr>';
//   echo '<th>Sr. No.</th>';
//   echo '<th>Roll No.</th>';
//   echo '<th>Student Name</th>';
//   echo '<th>Attendance Date</th>';
//   echo '<th>Attendance Status</th>';
//   echo '</tr>';
//   echo '</thead>';
//   echo '<tbody>';
  
 
//   //= $result->fetch_assoc()
//   $count = 0;
//   while($attendanceRow) {
//     $count++;
//     // $studentID = $attendanceRow['studentID'];
//     // $attendanceStatus = $attendanceRow['attendanceStatus'];
//     // $attendanceDate = $attendanceRow['attendanceDate'];

//     // $studentQuery = "SELECT * FROM student WHERE studentID='$studentID'";
//     // $studentResult = mysqli_query($conn, $studentQuery);
//     // $studentRow = $studentResult->fetch_assoc();

//     echo '<tr>';
//     echo '<td>'.$count.'</td>';
//     echo '<td>'.$attendanceRow['studentID'].'</td>';
//     echo '<td>'.$attendanceRow['studentName'].'</td>';
//     echo '<td>'.$attendanceRow['attendanceDate'].'</td>';
//     echo '<td>'.$attendanceRow['attendanceStatus'].'</td>';
//     echo '</tr>';
//   }

//   echo '</tbody>';
//   echo '</table>';
//   echo '<br/><br/>';
//   echo '<button onclick="window.print()">Print</button>';
// }
?>































  <!-- <?php
    if(isset($result)) {
      $subjectQuery = "SELECT * FROM `subject` WHERE subjectID='$subjectID'";
      $subjectResult = mysqli_query($conn, $subjectQuery);
      $subjectRow = mysqli_fetch_assoc($subjectResult);
      echo '<h2>'.$courseID.' - '.$subjectRow['subjectName'].'</h2>';
      echo '<table>';
      echo '<tr><th>Sr. No.</th><th>Roll No.</th><th>Student Name</th><th>Attendance Date</th><th>Attendance Status</th></tr>';

      $count = 0;
      while($attendanceRow = $result->fetch_assoc()) {
        echo $count;
        $studentID = $attendanceRow['studentID'];
        $attendanceStatus = $attendanceRow['attendanceStatus'];
        $attendanceDate = $attendanceRow['attendanceDate'];

        $studentQuery = "SELECT * FROM student WHERE studentID='$studentID'";
        $studentResult = mysqli_query($conn, $studentQuery);
        $studentRow = mysqli_fetch_assoc($studentResult);
       
        echo '<tr><td>'.$count.'</td><td>'.$studentRow['studentID'].'</td><td>'.$studentRow['studentName'].'</td><td>'.$attendanceDate.'</td><td>'.$attendanceStatus.'</td></tr>';
      }
      echo '</table>';
      
      echo '<br/><br/>';
      echo '<button onclick="window.print()">Print</button>';
    }

    ?> -->
    
</div>
    
  <script>
    
    document.getElementById("all").addEventListener("click", function() {
    document.getElementById("attendance_date").style.display = "none";
    });
    
    document.getElementById("label_all").addEventListener("click", function() {
    document.getElementById("attendance_date").style.display = "none";
    });

    document.getElementById("single_day").addEventListener("click", function() {
    document.getElementById("attendance_date").style.display = "block";
    });

    document.getElementById("label_single").addEventListener("click", function() {
    document.getElementById("attendance_date").style.display = "block";
    });

  </script>

  <script>
      const courseDropdown = document.getElementById('course');
      const subjectDropdown = document.getElementById('subject');

      courseDropdown.addEventListener('change', function() {
        const courseId = this.value;
        subjectDropdown.innerHTML = '<option value="">Loading...</option>';

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_subjects.php?course_id=' + courseId, true);
        xhr.onload = function() {
          if (this.status === 200) {
            const subjects = JSON.parse(this.responseText);

            let optionsHtml = '<option value="" disabled selected hidden>Select Subject</option>';
            subjects.forEach(function(subject) {
              optionsHtml += `<option value="${subject.subjectID}">${subject.subjectName}</option>`;
            });

            subjectDropdown.innerHTML = optionsHtml;
          }
        };
        xhr.send();
      });
  </script>


<!-- <script>
function printTable() {
  var content = document.getElementsByTagName('table')[0].outerHTML;
  var newWindow = window.open();
  newWindow.document.write(content);
  newWindow.print();
  newWindow.close();
}
</script> -->

<!-- <script>
function printTable() {
  var table = document.getElementById("attendanceTable");
  var newWin = window.open("", "Print-Window");
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">' + table.outerHTML + '</body></html>');
  newWin.document.close();
}
</script> -->


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




<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>