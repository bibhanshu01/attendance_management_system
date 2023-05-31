<?php
  error_reporting(0);
  include '../connection/_dbconnection.php';
  include '../connection/_session.php';
  $tID = $_SESSION['userId'];


  // Get course ID from request query parameters
$cId = $_GET['course_id'];

// Query database for subjects belonging to selected course
$subjectQuery = "SELECT `subject`.subjectID, `subject`.subjectName 
FROM `subject` 
INNER JOIN teacher_subject ON `subject`.subjectID = teacher_subject.subjectID 
WHERE teacher_subject.teacherID = '$tID' AND `subject`.courseID = '$cID'";
$rs = mysqli_query($conn, $subjectQuery);

$subjects = [];
while ($row = mysqli_fetch_assoc($rs)) {
  $subjects[] = $row;
}

// Return subjects as a JSON array
header('Content-Type: application/json');
echo json_encode($subjects);







  ?>