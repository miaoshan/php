<?php
$myData = array();
$DB_USERNAME = "uczchan";
$DB_TABLE_NAME = "instg033_data_79";

try {
   $dbh = new PDO("mysql:dbname=$DB_USERNAME");
} catch (PDOException $e) {
   print $e->getLine() . " Error!: " . $e->getMessage() . "<br/>";
   die();
}
$requestParam = htmlspecialchars($_GET["ins"]);
$searchBy = htmlspecialchars($_GET["searchBy"]);
$searchColumn = '';
if($searchBy=='inscription') { 
    $searchColumn = 'inscraw';
} else if($searchBy=='address') {
    $searchColumn = 'address';
} else if($searchBy=='title') {
    $searchColumn = 'title';
}
if($searchColumn=='') {
  $stmt = $dbh->prepare("SELECT * FROM $DB_TABLE_NAME");
} else {
  $stmt = $dbh->prepare("SELECT * FROM $DB_TABLE_NAME WHERE $searchColumn like '%$requestParam%'");
}
if($searchBy=='postcode') {
  $result = file_get_contents("http://uk-postcodes.com/postcode/" . $requestParam . ".json");
  $decodedresult = json_decode( $result, true );
  $approximatelat = floatval($decodedresult['geo']['lat']);
  $approximatelng = floatval($decodedresult['geo']['lng']);
  $approximaty = 0.1;
  if($approximatelat!=0 && $approximatelng!=0) {
    $stmt = $dbh->prepare("SELECT * FROM $DB_TABLE_NAME WHERE lat >= $approximatelat-$approximaty AND lat <= $approximatelat+$approximaty AND lng >= $approximatelng-$approximaty AND lng <= $approximatelng+$approximaty ");
  }
}

$stmt->execute();
$myData = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<script type='text/javascript'>";
echo "var opData = ".json_encode($myData,JSON_NUMERIC_CHECK);
echo "</script>";


?>
