<?php
  error_reporting(0);
  include '../connection/_dbconnection.php';
  include '../connection/_session.php';

  if(isset($_POST['submit'])) {
    $courseID = $_POST['course'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['date'];

    // Get course name
    $query = "SELECT courseName FROM course WHERE courseID='$courseID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $courseName = $row['courseName'];

    // Get subject name
    $query = "SELECT subjectName FROM `subject` WHERE subjectID='$subjectID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $subjectName = $row['subjectName'];

    // Get enrollment records for selected subject
    $query = "SELECT enrollment.studentID, studentName FROM enrollment INNER JOIN student ON enrollment.studentID=student.studentID WHERE enrollment.subjectID='$subjectID'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
      echo "
        <table>
          <tr>
            <td>Course:</td>
            <td>$courseName</td>
          </tr>
          <tr>
            <td>Subject:</td>
            <td>$subjectName</td>
          </tr>
          <tr>
            <td>Date:</td>
            <td>$attendanceDate</td>
          </tr>
          <tr>
            <th>Sr. No.</th>
            <th>Roll No.</th>
            <th>Student Name</th>
            <th>Attendance Status</th>
          </tr>
      ";

      $i = 1;
      while($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['studentID'];
        $studentName = $row['studentName'];

        echo "
          <tr>
            <td>$i</td>
            <td>$studentID</td>
            <td>$studentName</td>
            <td><input type='checkbox' name='attendance[$studentID]' value='present'></td>
          </tr>
        ";

        $i++;
      }

      echo "
        </table>
        <button type='submit' name='save'>Save Attendance</button>
      ";
    } else {
      echo "No records found.";
    }
  }

  if(isset($_POST['save'])) {
    $attendance = $_POST['attendance'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['date'];

    // Get last attendance ID
    $query = "SELECT MAX(attendanceID) AS maxAttendanceID FROM attendance";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $attendanceID = $row['maxAttendanceID'] + 1;

    foreach($attendance as $studentID => $status) {
      $query = "INSERT INTO attendance (attendanceID, studentID, subjectID, attendanceDate, attendanceStatus) VALUES ('$attendanceID', '$studentID', '$subjectID', '$attendanceDate', '$status')";
      mysqli_query($conn, $query);
    }

    echo "Attendance saved successfully.";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="teacher_css/style.css">
</head>
<body>
<div class="heading">Attendance Management System</div>

<!-- Navbar starts -->
<header>
  <nav>
    <ul>
      <li><a href="teacher_home.php">Home</a></li>
      <li><a href="#">Take Attendance</a></li>
      <li><a href="teacher_view_attendance.php">View Attendance</a></li>
      <li><a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </nav>
</header>
<!-- Navbar ends -->

<div class="container">
  <h1>Welcome <?php echo $_SESSION['userName'];?></h1>

  <form method="POST" action="">
    <label for="course">Select Course:</label>
    <select id="course" name="course" required>
      <option value="">--Select Course--</option>
      <?php
        $query = "SELECT * FROM course";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value='".$row['courseID']."'>".$row['courseName']."</option>";
        }
      ?>
    </select>
    
    <br><br>
    
    <label for="subject">Select Subject:</label>
    <select id="subject" name="subject" required>
      <option value="">--Select Subject--</option>
      <?php
        $query = "SELECT * FROM subject";
        $result = mysqli_query($conn, $query);
    
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value='".$row['subjectID']."'>".$row['subjectName']."</option>";
        }
      ?>
    </select>
    
    <br><br>
    
    <label for="date">Attendance Date:</label>
    <input type="date" id="date" name="date" required>
    
    <br><br>
    
    <button type="submit" name="submit">Take Attendance</button>
    </form>
    </div>
    
    </body>
    </html>