<?php 
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'connection/_dbconnection.php';
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $password = md5($password);

    //Verify for Administrator Login
    if($userType == "Administrator"){
      $query = "SELECT * FROM admin WHERE adminID = '$username' AND adminpassword = '$password'";

      $result = $conn->query($query);
      $num = $result->num_rows;
      $rows = $result->fetch_assoc();

      if($num == 1){

        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['userId'] = $rows['adminID'];
        $_SESSION['userName'] = $rows['adminName'];
        $_SESSION['userEmail'] = $rows['adminEmail'];
        
        //echo "Welcome ".$_SESSION['userName'];
        header("location: admin/admin_student/admin_student.php");
        
      }
      
      else{
        echo "<script>alert('Invalid username or password.');</script>";


      }

    } //Administrator if statement ends here
 
    //Verify for Teacher Login
    else if($userType == "Teacher"){
      $query = "SELECT * FROM teacher WHERE teacherID = '$username' AND teacherpassword = '$password'";

      $result = $conn->query($query);
      $num = $result->num_rows;
      $rows = $result->fetch_assoc();

      if($num == 1){

        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['userId'] = $rows['teacherID'];
        $_SESSION['userName'] = $rows['teacherName'];
        $_SESSION['userEmail'] = $rows['teacherEmail'];
        
        //echo "Welcome ".$_SESSION['userName'];
        header("location: teacher/teacher_home.php");
        
      }
      
      else{
        echo "<script>alert('Invalid username or password.');</script>";


      }

    } //Teacher if statement ends here

    //Verify for Student Login
    else if($userType == "Student"){
      $query = "SELECT * FROM student WHERE studentID = '$username' AND studentpassword = '$password'";

      $result = $conn->query($query);
      $num = $result->num_rows;
      $rows = $result->fetch_assoc();

      if($num == 1){

        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['userId'] = $rows['studentID'];
        $_SESSION['userName'] = $rows['studentName'];
        $_SESSION['userEmail'] = $rows['studentEmail'];
        
        //echo "Welcome ".$_SESSION['userName'];
        header("location: student/student_home.php");
        
      }
      
      else{
        echo "<script>alert('Invalid username or password.');</script>";


      }

    } //Student if statement ends here

    else{
        echo "<script>alert('Invalid Selection.');</script>";
    }




  }
  elseif($_SERVER["REQUEST_METHOD"] == "GET") {
    // Set input field values to empty when the page is refreshed
    $userType = "";
    $username = "";
    $password = "";
  }



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->

</head>
<body>
<div class="heading">Attendance Management System</div>






<!-- Navbar starts -->
<header>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <!-- <li><a href="#">Admin</a></li>
      <li><a href="../student/student_login.php">Student</a></li>
      <li><a href="../teacher/teacher_login.php">Teacher</a></li> -->
    </ul>
  </nav>
</header>
<!-- Navbar ends -->










<!-- Navbar starts -->
<!-- <header>
  <nav>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="#">Admin</a></li>
      <li><a href="../student/student_login.php">Student</a></li>
      <li><a href="../teacher/teacher_login.php">Teacher</a></li>
    </ul>
  </nav>
</header> -->
<!-- Navbar ends -->



<!-- Admin Login Form starts -->
<div class="container">
		<h1>Login</h1>
		<form method="POST" action="">
    <label for="userType">Login as:</label>
			<select required name="userType">
                <option value="" disabled selected hidden>--Select User Role--</option>
                <option value="Administrator">Administrator</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
			</select>
      

			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required placeholder="Enter Username">

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required placeholder="Enter Password">

			<button type="submit">Login</button>
		</form>
	</div>


<!-- Admin Login Form ends -->

<!-- PHP Variables from LOGIN FORM SET starts -->














<!-- PHP Variables from LOGIN FORM SET ends -->







<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->

</body>
</html>