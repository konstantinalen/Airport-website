<?php 

$servername = "mysql:host=localhost;dbname=air_ds";
$username = "root";
$password = "";
$dbname = "air_ds";

try
{
  $conn = new PDO($servername, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dep_airp = html_entity_decode($_POST['dep_air']); 
  $arr_airp = html_entity_decode($_POST['arr_airp']); 

  //Ανάκτηση του φόρου του αεροδρομίου αναχώρησης
  $stmt = $conn->prepare("SELECT airport_tax FROM airports WHERE airport_name = :dep_airp");
  $stmt->execute(['dep_airp' => $dep_airp]);
  $taxes1 = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode($taxes1);

  //Ανάκτηση του φόρου του αεροδρομίου άφιξης
  $stmt1 = $conn->prepare("SELECT airport_tax FROM airports WHERE airport_name = :arr_airp");
  $stmt1->execute(['arr_airp' => $arr_airp]);
  $taxes2 = $stmt1->fetch(PDO::FETCH_ASSOC);

  echo json_encode($taxes2);

  //Ανάκτηση του γεωγραφικού πλάτους του αεροδρομίου αναχώρησης
  $stmt2 = $conn->prepare("SELECT latitude FROM airports WHERE airport_name = :dep_airp");
  $stmt2->execute(['dep_airp' => $dep_airp]);
  $dep_lat = $stmt2->fetch(PDO::FETCH_ASSOC);

  echo json_encode($dep_lat);

  //Ανάκτηση του γεωγραφικού μήκους του αεροδρομίου αναχώρησης
  $stmt3 = $conn->prepare("SELECT longitude FROM airports WHERE airport_name = :dep_airp");
  $stmt3->execute(['dep_airp' => $dep_airp]);
  $dep_long = $stmt3->fetch(PDO::FETCH_ASSOC);

  echo json_encode($dep_long);

  //Ανάκτηση του γεωγραφικού πλάτους του αεροδρομίου άφιξης
  $stmt4 = $conn->prepare("SELECT latitude FROM airports WHERE airport_name = :arr_airp");
  $stmt4->execute(['arr_airp' => $arr_airp]);
  $arr_lat = $stmt4->fetch(PDO::FETCH_ASSOC);

  echo json_encode($arr_lat);

  //Ανάκτηση του γεωγραφικού μήκους του αεροδρομίου άφιξης
  $stmt5 = $conn->prepare("SELECT longitude FROM airports WHERE airport_name = :arr_airp");
  $stmt5->execute(['arr_airp' => $arr_airp]);
  $arr_long = $stmt5->fetch(PDO::FETCH_ASSOC);

  echo json_encode($arr_long);

  
}
catch (PDOException $e)
{
  echo "Failed " .$e->getMessage();
}

?>
