<?php
  error_reporting(0);
  include '../connection/_dbconnection.php';
  include '../connection/_session.php';
  

  // Get course ID from request query parameters
$cId = $_GET['course_id'];
$tId = $_GET['teach_id'];

// Query database for subjects belonging to selected course
 $subjectQuery = "SELECT `subject`.subjectID, `subject`.subjectName 
 FROM `subject` 
 INNER JOIN teacher_subject ON `subject`.subjectID = teacher_subject.subjectID 
 WHERE teacher_subject.teacherID = '$tId' AND `subject`.courseID = '$cId'";
//$subjectQuery = "SELECT * FROM `subject` WHERE courseID='$cId'";
$rs = mysqli_query($conn, $subjectQuery);

$subjects = [];
while ($row = mysqli_fetch_assoc($rs)) {
  $subjects[] = $row;
}

// Return subjects as a JSON array
header('Content-Type: application/json');
echo json_encode($subjects);


// `subject`.subjectID, `subject`.subjectName


?>