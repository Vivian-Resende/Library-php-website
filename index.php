
<?php
if($_POST){
	
	//get the variables from the post
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$valid = 'true';
	
	//check with the database
	if($valid == 'true'){
	
	 try {
        $host = '127.0.0.1';
        $dbname = 'library';
        $user = 'root';
        $pass = '';
		
		# MySQL with PDO_MYSQL
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$q = $DBH->prepare("select * from users where username = :username and password = :password LIMIT 1");
		$q->bindValue(':username', $username);
		$q->bindValue(':password', $password);
		$q->execute();
		
		$row = $q->fetch(PDO::FETCH_ASSOC);
		 
			$message = '';
		
		if (!empty($row)) {
		// taking data from the row
		$id = $row['id'];
			$password = $row['password'];
				$username = $row['username'];
				$type =$row['type'];
				
				session_start();
				//put into session
				$_SESSION["id"] = $id;
				$_SESSION["username"] = $username;
				$_SESSION["password"] = $password;
				$_SESSION["type"] = $type;
				
				if($type == 'student'){
				//to the student page
				header('Location: studentHomepage.php');
				}else if($type == 'admin'){
				//to the admin
				header('Location: adminHomepage.php');
				
			} else {
		    $message= 'Sorry your log in details are not correct';
		}
		}
		
	 } catch(PDOException $e) {echo $e->getMessage();}
	
}
}
?>

<html>
<h2> Welcome to the Library </h2>

<head>
Login  <br>
<input type="radio" name="name" value="student" checked> Student <br>
<input type="radio" name="name" value="admin" checked> Admin <br>
</head> <br>
<body>
<form action ="index.php" method = "post" />
Username: <input type = "text" name = "username" id = "username" minlength='3' maxlength='40' required />
Password: <input type = "password" name = "password"  /> <br>
<input type = "submit" value = "Submit"/> <br>
</form>
<form action="register.php" method="post">  
New student? <input type="submit" value="Register" /> 
</form>

</body>

</html>