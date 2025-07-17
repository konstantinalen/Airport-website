<?php

$servername = "mysql:host=localhost;dbname=air_ds";
$username = "root";
$password = "";
$dbname = "air_ds";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    try 
    {

        $conn = new PDO($servername, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $reservation_id = $_POST['reservation_id'];

        //Διαγραφή κράτησης από την βάση
        $stmt = $conn->prepare("DELETE FROM reservations WHERE res_id = :reservation_id");
        $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } 
    catch (Exception $e) 
    {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
