<?php
session_start();

if (isset($_SESSION["username"]))  {
		echo "<br/>Logged in as: ".$_SESSION["username"];
		$user_id = $_SESSION["id"];
		
}



include('db.php');


if ($_GET){
$pid = $_GET['id'];  
$stmt = $DBH->prepare("DELETE FROM transaction WHERE book_id = $pid ");
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':user_id', $user_id); 
$stmt->bindValue(':book_id', $pid);
//$stmt->bindValue(':returned', $time); 
$stmt->execute();

include('errordb.php');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<table>";
//echo "<tr><th>Name</th><th>Author</th><th>Return Date</th>";
 foreach($rows as $row){
    echo "<tr>";
//echo "<td>";
//echo $row['id'];
//echo "</td>";
	echo "<td>";
	echo $row['name'];
	echo "</td>";
	echo "<td>";
	echo $row['author'];
	echo "</td>";
//	echo "<td>";
//	echo $row['returned'];
//	echo "</td>";
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
<form action="adminhomepage.php" method="post">  
<input type="submit" value="Return" /> 
</form>
<br>
<form action="logout.php" method="post">  
<input type="submit" value="Logout" /> 
</form>


</body>
</html>

