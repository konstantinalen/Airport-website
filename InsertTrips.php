<?php

  $servername = "mysql:host=localhost;dbname=air_ds";
  $username = "root";
  $password = "";
  $dbname = "air_ds";

  $dep_airp = html_entity_decode($_POST['dep_air']);
  $arr_airp = html_entity_decode($_POST['arr_airp']);
  $date = $_POST['date'];
  $seats = $_POST['seatList'];
  $taxes = $_POST['taxes'];
  $fName = $_POST['fName'];
  $lName = $_POST['lName'];
  $seat_cost = $_POST['cost'];

  try 
  {
    $conn = new PDO($servername, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Εισαγωγή κράτησης στην βάση 
    $sql = "INSERT INTO reservations (departure_airport, arrival_airport, departure_date, seats, taxes, first_name, last_name, seat_cost) VALUES (:dep_airp, :arr_airp, :date, :seats, :taxes, :fName, :lName, :cost)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':dep_airp', $dep_airp);
    $stmt->bindParam(':arr_airp', $arr_airp);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':seats', $seats);
    $stmt->bindParam(':taxes', $taxes);
    $stmt->bindParam(':fName', $fName);
    $stmt->bindParam(':lName', $lName);
    $stmt->bindParam(':cost', $seat_cost);

    $stmt->execute();

  }
  catch(PDOException $e)
  {
    echo "Failed " .$e->getMessage();
  }

    
?>