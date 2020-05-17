<?php

session_start();

$usernameErr = "";
$username = "";
$student_idErr = "";
$student_id = "";
$passwordErr = "";
$password = "";

if($_POST){
	
	include "recaptchalib.php";
	
    $username = $_POST['username'];
    $password = $_POST['password'];
	$student_id = $_POST['student_id'];
	
	if (empty($username) || strlen($username) < 4 ) 
               $usernameErr = "Username is required, at least 4 chars";
		   
		   if (strlen ($student_id) != 7){
			   $student_idErr = 'Sorry you did not enter a correct Student_id!';
		   }

			if(strlen($password) < 6){
				$passwordErr = 'Password is too short!';
			}
		
	
	
	
	
	if (empty($usernameErr) and empty($student_idErr) and
	empty($passwordErr)) {		   
    
	  try {
        $host = '127.0.0.1';
        $dbname = 'library';
        $user = 'root';
        $pass = '';
        # MySQL with PDO_MYSQL
 		
        # MySQL with PDO_MYSQL
		
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
   

		$sql = "INSERT INTO Users (username, password, student_id) VALUES (?, ?, ?);";
		$sth = $DBH->prepare($sql);
		
		
		
		$sth->bindParam(1, $username);
		$sth->bindParam(2, $password);
		$sth->bindParam(3, $student_id);
		
		$sth->execute();
		
		
		$_SESSION["username"] = $username;
		$_SESSION["student_id"] = $student_id;
		//$_SESSION[""] = ;
		header('Location: index.php');
		exit();
		
		
		echo 'You are now registered!';
		 } catch(PDOException $e) {echo 'Error' . $e;} 

	}	 
}
?>



<!DOCTYPE>
<html>
<head>
 
</head>
<body>
<h2> Registration Form</h2>
<form  action="register.php" method="post">
Username: <input type="text" name="username" value="<?php echo $username; ?>"/> <br>
         <span class = "error"><?php echo $usernameErr;?></span> <br>
Student_id: <input type="text" name="student_id" value="<?php echo $student_id; ?>"/> <br>
<span class = "error"><?php echo $student_idErr;?></span> <br>
Password: <input type="password" name="password" id = "password" minlength='6' maxlength='10' required /> <br>
<span class = "error"><?php echo $passwordErr;?></span> <br>
<div class="g-recaptcha" data-sitekey="6Lfg8zoUAAAAAD3VgriYwrk7IEc3ZPbyWDBPhxkX"></div> <br>
<input type="submit" class='button' name='submit' value= 'Register'/>
</form>
 <!--js-->
   <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>