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
$stmt = $dbh->prepare("SELECT comment FROM $DB_TABLE_NAME WHERE id=$id");
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
  foreach($val as $individualVal) {
    echo $individualVal . ",";
  }
}
?>
