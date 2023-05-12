<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="student_css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->

</head>
<body>
<div class="heading">Attendance Management System</div>

<!-- Navbar starts -->
<header>
  <nav>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../admin/admin_login.php">Admin</a></li>
      <li><a href="#">Student</a></li>
      <li><a href="../teacher/teacher_login.php">Teacher</a></li>
    </ul>
  </nav>
</header>
<!-- Navbar ends -->





<!-- Student Login Form starts -->
<div class="container">
		<h1>Student Login</h1>
		<form method="POST" action="">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>

			<button type="submit">Login</button>
		</form>
	</div>



<!-- Student Login Form ends -->



<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->

</body>
</html>