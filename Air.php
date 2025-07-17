<?php
    //Σύνδεση με την βάση για την ανάκτηση των αεροδρομίων

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "air_ds";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT airport_name, airport_code FROM airports";

    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        $json_array = array();
        while($row = $result->fetch_assoc()) {
            $json_array[] = array(
                "name" => $row['airport_name'],
                "code" => $row['airport_code']
            );
        }
    }
    else 
    {
        echo json_encode([]);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($json_array);
    $conn->close();
?>
