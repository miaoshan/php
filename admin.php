<?php

$username = null;
$password = null;

if (isset($_SERVER['PHP_AUTH_USER'])) {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
} elseif (isset($_SERVER['HTTP_AUTHENTICATION'])) {
        if (strpos(strtolower($_SERVER['HTTP_AUTHENTICATION']),'basic')===0)
          list($username,$password) = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}
if (is_null($username) || $username!='admin' || $password!='password') {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'sorry you are not authenticated';
    die();
} else {
    echo "<p>Hello {$username}.</p>";
    $myData = array();
    $DB_USERNAME = "uczchan";
    $DB_TABLE_NAME = "instg033_data_79";

    try {
       $dbh = new PDO("mysql:dbname=$DB_USERNAME");
    } catch (PDOException $e) {
       print $e->getLine() . " Error!: " . $e->getMessage() . "<br/>";
       die();
    }
    
    $pattern = '/(.*)@(.*)/';
    foreach($_GET as $key => $value){
        preg_match($pattern, htmlspecialchars($key), $matches, PREG_OFFSET_CAPTURE);
        $recordid = $matches[1][0];
	$recordcolumn = $matches[2][0];
        $stmt = $dbh->prepare("UPDATE $DB_TABLE_NAME SET $recordcolumn = '$value' WHERE id='$recordid'");
        $stmt->execute();
    }

    $stmt = $dbh->prepare("SELECT id,colour, date_erected, lat, lng, inscraw, address, country, locality, organisation, photofulluri, license, licenseuri, photographer, title FROM $DB_TABLE_NAME order by id");
    $stmt->execute();
    $myData = $stmt->fetchAll(PDO::FETCH_ASSOC);    
   
    $idcolumnvalue; 
    echo "<form>";
    echo "<table border='1'>";
    echo "<tr><th>id</th><th>colour</th><th>date_erected</th><th>lat</th><th>lng</th><th>inscraw</th><th>address</th><th>country</th><th>locality</th><th>organisation</th><th>photofulluri</th><th>license</th><th>licenseuri</th><th>photographer</th><th>title</th></tr>";
    foreach($myData as $rownum=>$rowvalue) {
      echo "<tr>";
      foreach($rowvalue as $columnname=>$cellvalue) {
        if($columnname=='id') {$idcolumnvalue=$cellvalue;}
        echo "<td>";
        echo "<input type='text' name='$idcolumnvalue@$columnname' value='$cellvalue'/>";
        echo "</td>";
      }  
      echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit'/>";
    echo "</form>";
    }
?>
