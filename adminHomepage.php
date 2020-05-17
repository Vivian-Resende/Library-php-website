<?php

session_start();
if($_SESSION["type"] == 'admin') {
}else {
	die;
}
?>

Welcome <?php echo
$_SESSION['username'];

echo "<br/>";

?>

<?php
echo "<br/>";
include('db.php');

$stmt = $DBH->prepare("SELECT b.id,b.name,b.author,b.isbn,t.user_id,t.book_id, t.returned, u.student_id FROM books b LEFT OUTER JOIN transaction t ON b.id = t.book_id LEFT OUTER JOIN users u ON u.id = t.user_id ORDER BY b.id " );
$stmt->bindParam(1, $title);
$stmt->execute();
include('errordb.php');


$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "<table>";
echo "<tr><th>Id</th><th>Name</th><th>Author</th><th>ISBN</th><th>Due date</th><th>Student ID</th><th>Passed due date</th><th>Check in </th></tr>";
 foreach($rows as $row){
           echo "<tr>";
	echo "<td>";
	echo $row['id'];
	echo "</td>";
	echo "<td>";
	echo $row['name'];
	echo "</td>";
	echo "<td>";
	echo $row['author'];
	echo "</td>";
	echo "<td>";
	echo $row['isbn'];
	echo "</td>";
	echo "<td>";
	echo $row['returned'];
	echo "</td>";
	echo "<td>";
	echo $row['student_id'];
	echo "</td>";
	if ((date('Y-m-d') > $row['returned']) && ($row['returned'] != NULL)) { 
		echo "<td>";		
		echo "Yes";
		echo "</td>";
		}
	else if ((date('Y-m-d') < $row['returned']) && ($row['returned'] != NULL)) {
		echo "<td>";		
		echo "No";
		echo "</td>";
	}
		
	if ($row['user_id'] != NULL) { 
		echo "<td>";		
		echo "<a href=checkin.php?id=".$row['book_id'].">Check In</a>";
		echo "</td>";
		}
	
	echo "</tr>";

}
echo "</table>"; ?>

<?php


$name = "";
$author = "";
$isbn = 0;


if ($_POST) {
$name = $_POST['name'];
$author = $_POST['author'];
$isbn = $_POST['isbn'];


$stmt = $DBH->prepare("INSERT into books(name, author, isbn)
Values(:name,:author,:isbn)");
$stmt->bindValue(':author', $author);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':isbn', $isbn);
$stmt->execute();

header("Location: adminHomepage.php");
}
?>



<h2>Add a new book</h2>
<form action="adminHomepage.php" method="post">
Name: <input type="text" name="name" value="<?php echo $name; ?>"/>
Author: <input type="text" name="author" value="<?php echo
$author; ?>"/>
ISBN: <input type="text" name="isbn" minlength='10' maxlength='10' value="<?php echo $isbn; ?>"  />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" name="submit" value="Add" class='button'/>
</form>
<form action="logout.php" method="post">  
<input type="submit" value="Logout" /> 

</form>