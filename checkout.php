<?php
session_start();

if (isset($_SESSION["username"]))  {
		echo "<br/>Logged in as: ".$_SESSION["username"];
		$user_id = $_SESSION["id"];
		
}
//print_r($_POST);
//print_r($_GET);

if ($_GET){
$pid = $_GET['id']; 
//echo $pid;
include('db.php');


$date = date('Y-m-d', strtotime(' + 7days'));
$time = $date;


$stmt = $DBH->prepare("INSERT INTO transaction (user_id,book_id,returned) VALUES (:user_id,:book_id,:returned)");
$stmt->bindValue(':user_id', $user_id);   
$stmt->bindValue(':book_id', $pid);
$stmt->bindValue(':returned', $time);
$stmt->execute();


echo "<br>";

include('errordb.php');

$stmt = $DBH->prepare("SELECT b.name, b.author, t.returned FROM books b INNER JOIN transaction t ON b.id = t.book_id WHERE t.user_id = ?");
$stmt->bindValue(1, $user_id); //join tables
$stmt->execute();
include('errordb.php');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<table>";
echo "<tr><th>Name</th><th>Author</th><th>Return Date</th>";
 foreach($rows as $row){
    echo "<tr>";
//echo "<td>";
//echo $row['id'];
//echo "</td>";
	echo "<td>";
	echo $row['name'];
	echo "</td>";
	echo "<td>";
	 echo "&emsp;";
	echo $row['author'];
	echo "</td>";
	echo "<td>";
	 echo "&emsp;";
	echo $row['returned'];
	echo "</td>";
//	echo "<td>";
//	echo $row['user_id'];
//	echo "</td>";
	//echo "<td>";
	//echo "<a href=checkout.php?id=".$row['id'].">Checkout</a>";
	//echo "</td>";
	//echo "<td>";
	//echo "<a href=updateProduct.php?id=".$row['id'].">Edit</a>";
	//echo "</td>";
	
 

	echo "</tr>";
 }


 
echo "</table>"; 
}



?>









<!DOCTYPE html>
<html>
<body>
<br>
<form action="studenthomepage.php" method="post">  
<input type="submit" value="Return" /> 
</form>


</body>
</html>

