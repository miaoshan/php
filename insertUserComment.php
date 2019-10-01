<?php
$DB_USERNAME = "uczchan";
$DB_TABLE_NAME = "instg033_data_79_comments";

try {
   $dbh = new PDO("mysql:dbname=$DB_USERNAME");
} catch (PDOException $e) {
   print $e->getLine() . " Error!: " . $e->getMessage() . "<br/>";
   die();
}
$id = htmlspecialchars($_GET["id"]);
$comment = htmlspecialchars($_GET["comment"]);
$stmt = $dbh->prepare("INSERT INTO $DB_TABLE_NAME VALUES($id, '$comment')");
$stmt->execute();
?>
