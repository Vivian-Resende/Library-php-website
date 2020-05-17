<?php

session_start();
if($_SESSION["type"] == 'student') {
}else {
	die;
}
?>

Welcome <?php echo
$_SESSION['username'];

 
?>

<?php


include('db.php');
if($_POST){
$title = $_POST['search'];
$title = "%".$title."%";
$user_id = $_SESSION["id"];

$stmt = $DBH->prepare("SELECT b.id,b.name,b.author,b.isbn,t.user_id,t.book_id FROM books  b LEFT OUTER JOIN transaction t ON b.id = t.book_id WHERE name LIKE ?" );
$stmt->bindParam(1, $title);

$stmt->execute();
include('errordb.php');
echo "&emsp;";
 echo "<br/>";
//print("PDO::FETCH_ASSOC: ");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($results);
$books =  $stmt->rowCount();
//echo "<tr><th>Id</th>&nbsp;&nbsp;&nbsp;<th>Book</th>";
 echo "<br/>";
for ($i=0; $i<$books; $i++) { 
 echo "<tr><th>Id</th>";
 echo "&emsp;";
 echo $results[$i]['id'];
  echo "&emsp;";
echo "<tr><th>Book</th>"; 
  echo "&emsp;";
  echo $results[$i]['name']; 
   echo "&emsp;";
  echo "<tr><th>Author</th>"; 
  echo "&emsp;";
   echo $results[$i]['author']; 
    echo "&emsp;";
   echo "<tr><th>ISBN</th>"; 
  echo "&emsp;";
   echo $results[$i]['isbn']; 
   echo "&emsp;";
  // print_r($results); 
   if ($results[$i]['user_id'] == NULL) { 
		echo "<td>";		
		echo "<a href=checkout.php?id=".$results[$i]['id'].">Checkout</a>";
		echo "</td>";
		
		}
	else     
	echo 'Book already checked out'; 
	} 
//print_r($result);
//print("\n");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Search</title><br> </br>
    </head>
    <body>
<form action="studentHomepage.php" method="post">  
Search book: <input type="text" name="search" /> <br>  
<input type="submit" value="Search" /> 
</form>
<form action=checkout.php?id=".$results[$i]['id']." method="post">  
<input type="submit" value="Checked out books" /> 
</form>
<form action="logout.php" method="post">  
<input type="submit" value="Logout" /> 

</form>
</body>
</html>

