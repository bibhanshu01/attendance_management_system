<?php
// Include the DB connection file
include '../connection/_dbconnection.php';
include '../connection/_session.php';

// Check if the form is submitted
if(isset($_POST['submit_attendance'])) {
    // Get the selected course, subject and attendance date
    $courseID = $_POST['course'];
    $subjectID = $_POST['subject'];
    $attendanceDate = $_POST['attendance_date'];

    // Get all the students enrolled for the selected course and subject
    $query = "SELECT enrollment.studentID, student.studentName, `subject`.subjectID FROM enrollment
                INNER JOIN student ON student.studentID = enrollment.studentID
                INNER JOIN `subject` ON `subject`.subjectID = enrollment.subjectID
                WHERE `subject`.courseID = '$courseID' AND `subject`.subjectID = '$subjectID'";
    $result = mysqli_query($conn, $query);

    // Insert the attendance records into the attendance table
    $attendanceID_query = "SELECT MAX(attendanceID) as max_attendanceID FROM attendance";
    $attendanceID_result = mysqli_query($conn, $attendanceID_query);
    $row = mysqli_fetch_assoc($attendanceID_result);
    $attendanceID = $row['max_attendanceID'] + 1;

    while($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['studentID'];
        $subjectID = $row['subjectID'];
        $attendanceStatus = isset($_POST[$studentID]) && $_POST[$studentID] == 'on' ? 'Present' : 'Absent';
        $insertQuery = "INSERT INTO attendance (attendanceID, studentID, subjectID, attendanceDate, attendanceStatus)
                        VALUES ('$attendanceID', '$studentID', '$subjectID', '$attendanceDate', '$attendanceStatus')";
        mysqli_query($conn, $insertQuery);
        $attendanceID++;
    }

    // Show success message after inserting the attendance records
   // echo '<div class="success">Attendance recorded successfully.</div>';
   echo "<script>alert('Attendance Recorded Successfully!.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="teacher_css/take_attendance.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    <!-- Take Attendance Form starts -->
    <div class="container">
        <h1>Welcome <?php echo $_SESSION['userName'];?></h1>
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

            <div class="attendance_date">
                <label for="attendance_date">Select Date:</label>
                <input type="date" id="attendance_date" name="attendance_date" required placeholder="Select Date">
            </div>

            <div class="buttons">
            <button type="submit" name="submit">Submit</button>
            </div>
    </form>
</div>
<div class="take_attendance_container">
    <!-- Display attendance table after form submit -->
    <?php
    if(isset($_POST['submit'])) {
        // Get the selected course and subject names
        $courseID = $_POST['course'];
        $subjectID = $_POST['subject'];
        $query = "SELECT courseName, subjectName FROM course
                    INNER JOIN `subject` ON `subject`.courseID = course.courseID
                    WHERE `subject`.subjectID = '$subjectID'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $courseName = $row['courseName'];
        $subjectName = $row['subjectName'];

        // Get all the students enrolled for the selected course and subject
        $query = "SELECT enrollment.studentID, student.studentName FROM enrollment
                    INNER JOIN student ON student.studentID = enrollment.studentID
                    WHERE enrollment.subjectID = '$subjectID'";
        $result = mysqli_query($conn, $query);

        // Display attendance table with checkbox inputs for each student
        echo '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="attendance_date" value="' . $_POST['attendance_date'] . '">
                <input type="hidden" name="course" value="' . $courseID . '">
                <input type="hidden" name="subject" value="' . $subjectID . '">
                <table>
                    <caption>'.$courseName.' - '.$subjectName.' - '.$_POST['attendance_date'].'</caption>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>'.$row['studentID'].'</td>
                    <td>'.$row['studentName'].'</td>
                    <td><input type="checkbox" name="'.$row['studentID'].'"></td>
                </tr>';
        }
        echo '</tbody>
                </table>
                <button type="submit" name="submit_attendance">Save</button>
            </form>';
    }
    ?>
    <!-- End of attendance table -->
</div>
<!-- Take Attendance Form ends -->

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
</body>

</html>