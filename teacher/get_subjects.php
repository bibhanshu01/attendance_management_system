<?php
  error_reporting(0);
  include '../connection/_dbconnection.php';
  include '../connection/_session.php';

  // Get course ID from request query parameters
$cId = $_GET['course_id'];

// Query database for subjects belonging to selected course
$subjectQuery = "SELECT * FROM `subject` WHERE courseID='$cId'";
$rs = mysqli_query($conn, $subjectQuery);

$subjects = [];
while ($row = mysqli_fetch_assoc($rs)) {
  $subjects[] = $row;
}

// Return subjects as a JSON array
header('Content-Type: application/json');
echo json_encode($subjects);







  ?>