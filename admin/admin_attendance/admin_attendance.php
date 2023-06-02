<?php
  error_reporting(0);
  include '../../connection/_dbconnection.php';
  include '../../connection/_session.php';
  require '../../vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



  if(isset($_POST['save'])) {
    $courseID = $_POST['course'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['attendance_date'];
   
   if(isset($_POST['attendance_type'])){
    $selected_radio = $_POST['attendance_type'];
    if($selected_radio == "All") {
      
         $attendanceQuery = "SELECT student.studentID, student.studentName, `subject`.subjectName, attendance.attendanceDate, attendance.attendanceStatus
         FROM attendance
         INNER JOIN student
         ON attendance.studentID = student.studentID
         INNER JOIN `subject`
         ON attendance.subjectID = `subject`.subjectID
         WHERE `subject`.courseID = '$courseID'
         AND `subject`.subjectID = '$subjectID'";
    } elseif($selected_radio == "Single") {
      
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
  
  if(isset($_POST['export'])) {
   
    $courseID = $_POST['course'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['attendance_date'];

   if(isset($_POST['attendance_type'])){
    $selected_radio = $_POST['attendance_type'];
    if($selected_radio == "All") {

         $attendanceQuery = "SELECT student.studentID, student.studentName, `subject`.subjectName, attendance.attendanceDate, attendance.attendanceStatus
         FROM attendance
         INNER JOIN student
         ON attendance.studentID = student.studentID
         INNER JOIN `subject`
         ON attendance.subjectID = `subject`.subjectID
         WHERE `subject`.courseID = '$courseID'
         AND `subject`.subjectID = '$subjectID'";
    } elseif($selected_radio == "Single") {
     
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
      $filename = 'Attendance_'. $courseID.'_' . date('Ymd') . '.xlsx';

      if(mysqli_num_rows($rst) > 0){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Roll No.");
        $sheet->setCellValue('B1', "Student Name");
        $sheet->setCellValue('C1', "Subject Name");
        $sheet->setCellValue('D1', "Attendance Date");
        $sheet->setCellValue('E1', "Attendance Status");

        $rowCount = 2;
        foreach($rst as $data){
          $sheet->setCellValue('A' . $rowCount, $data['studentID']);
          $sheet->setCellValue('B' . $rowCount, $data['studentName']);
          $sheet->setCellValue('C' . $rowCount, $data['subjectName']);
          $sheet->setCellValue('D' . $rowCount, $data['attendanceDate']);
          $sheet->setCellValue('E' . $rowCount, $data['attendanceStatus']);
          $rowCount++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        $writer->save('php://output');

      }
      else {
        //echo 'No attendance records found.';
        echo "<script>alert('No Record Found!!!');</script>";
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
 
  $subjectQuery = "SELECT * FROM `subject` WHERE subjectID='$subjectID'";
  $subjectResult = mysqli_query($conn, $subjectQuery);
  $subjectRow = $subjectResult->fetch_assoc();     //mysqli_fetch_assoc($subjectResult);
  $subjectName = $subjectRow['subjectName'];
  
  $courseQuery = "SELECT courseName FROM course WHERE courseID = '$courseID'";
  $courseResult = mysqli_query($conn, $courseQuery);
  $courseRow = $courseResult->fetch_assoc(); 
  $courseName = $courseRow['courseName'];
  echo '<h2>'.$courseName.' - '.$subjectName.'</h2>';

  if ($rst->num_rows > 0) { // Check if there are any records in the result
   
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
    while($attendanceRow = $rst->fetch_assoc()) {
      $count++;
      echo '<tr>';
      echo '<td>'.$count.'</td>';
      echo '<td>'.$attendanceRow['studentID'].'</td>';
      echo '<td>'.$attendanceRow['studentName'].'</td>';
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
     
        echo '<button onclick="printDiv()">Print</button>';?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
          <input type="hidden" name="course" value="<?php echo $_POST['course']; ?>">
          <input type="hidden" name="subject" value="<?php echo $_POST['subject']; ?>">
          <input type="hidden" name="attendance_type" value="<?php echo $_POST['attendance_type']; ?>">
          <input type="hidden" name="attendance_date" value="<?php echo $_POST['attendance_date']; ?>">
          <button type="submit" name="export" class="btn btn-primary" style="display:inline-block;">Excel</button>
        </form>
   <?php }
   
  } else {
    //echo 'No attendance records found.';
    echo "<script>alert('No Record Found!!!');</script>";
  }
}


?>


    
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




<!-- JS script for printing the div starts -->
<script type="text/javascript">
function printDiv(){
var printContents = document.getElementsByClassName("attendance_container")[0].innerHTML;
var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
<!-- JS script for printing the div ends -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/js/font-awesome.min.js"></script>

</body>
</html>