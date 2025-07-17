<!DOCTYPE html>
<html>
    <head>
      <title>Book Flight</title>

      <link rel="website icon" type="jpg" href="https://static.vecteezy.com/system/resources/previews/023/616/612/non_2x/airplane-aviation-logo-design-concept-airline-logo-plane-travel-icon-airport-flight-world-aviation-vector.jpg"/>

      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="Air.css?v=6">

      <script>
        const Seats = <?= json_encode($_POST['number']) ?>;
      </script>
      <script src = "Air.js?v=15"></script>
    </head>

    <!--Σύνδεση με την βάση δεδομένων για την ανάκτηση του ονοματεπώνυμου και των θέσεων που έγινε η κράτηση-->
    <?php

      $servername = "mysql:host=localhost;dbname=air_ds";
      $username = "root";
      $password = "";
      $dbname = "air_ds";

      $conn = new PDO($servername, $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $usernameIn = $_COOKIE["username"];

      $stmt = $conn->prepare("SELECT first_name FROM users WHERE username = :username");
      $stmt->execute([':username' => $usernameIn]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $fName = $result['first_name'];

      $stmt1 = $conn->prepare("SELECT last_name FROM users WHERE username = :username");
      $stmt1->execute([':username' => $usernameIn]);
      $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
      $lName = $result1['last_name'];

      $stmt2 = $conn->prepare("SELECT seats FROM reservations WHERE departure_date = :date AND departure_airport = :dep_airp AND arrival_airport = :arr_airp");
      $stmt2->execute(['date' => $_POST['date'], 'dep_airp' => $_POST['dep_airp'], 'arr_airp' => $_POST['arr_airp']]);
      $seat = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <body>

      <!--Εμφάνιση του bar menu-->
      <div class = "barmenu">

        <a href = "">Air DS</a>

        <div id = "myLinks">

          <a href = "Home.php">Home</a>
          <a href = "MyTrips.php">My Trips</a>
          <?php
            $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null;
            ?>
            <div id="user_status">
              <?php if ($username): ?>
                <a href = "Logout.php">Logout</a>
              <?php else: ?>
                <a href = "LoginForm.php">Login</a>
              <?php endif; ?>
            </div>


        </div>

        <a href="javascript:void(0);" class="icon" onclick="Show_Links()">
          <div class="line">-</div>
          <div class="line">-</div>
          <div class="line">-</div>
        </a>

      </div>

      <!--Δημιουργία μιας κρυφής φόρμας με πεδία το αεροδρόμιο αναχώρησης και άφιξης, το ονοματεοώνυμο, την ημερομηνία και τον αριθμό των επιβατών ώστε να σταλθεί στην php με όνομα MyTrips.php-->
      <form id="passengerForm" action = "MyTrips.php" method = "POST" class = "formB">

        <input type="hidden" name="dep_airp" value="<?php echo htmlspecialchars($_POST['dep_airp']); ?>">
        <input type="hidden" name="arr_airp" value="<?php echo htmlspecialchars($_POST['arr_airp']); ?>">
        <input type="hidden" name="fName" value="<?php echo htmlspecialchars($fName); ?>">
        <input type="hidden" name="lName" value="<?php echo htmlspecialchars($lName); ?>">
        <input type="hidden" name="date" value="<?php echo htmlspecialchars($_POST['date']); ?>">
        <input type="hidden" name="number" value="<?php echo htmlspecialchars($_POST['number']); ?>">

        <!--Εμφάνιση του ονοματεπώνυμου του επιβάτη που έκανε την κράτηση-->
        <h5>Passenger No.1</h5><br>
        <label class = "labels">First Name</label>
        <input name = "fName" value = "<?php echo "$fName"; ?>" disabled class = "inputs"></input><br><br>

        <label class = "labels">Last Name</label>
        <input value = "<?php echo "$lName"; ?>" disabled class = "inputs"></input><br><br>
            
        <!--Αν ο αριθμός των επιβατών είναι από δύο και πάνω εμφανίζονται αντίστοιχα πεδία συμπλήρωσης του ονοματεπωνύμου τους των υπόλοιπων επιβατών-->
        <?php if (isset($_POST['number'])):?> 
            
            <?php for ($i = 1; $i <= $_POST['number']-1; $i++): ?>
              <h5>Passenger No.<?php echo $i+1 ?></h5><br>
              <label class = "labels">First Name</label>
              <input type="text" name="first_name" class="check_input"><br><br>
              <label class = "labels">Last Name</label>
              <input type="text" name="last_name" class="check_input"><br><br>
            <?php endfor; ?>
            
        <?php endif; ?>

        <!--Επιλογή θέσεων-->
        <div id ="choose_seat" style = "display: none">

          <p>Please choose your seats!</p>
          
          <div id ="select_seat" style = "display: flex;">
            
            <!--Η εικόνα του αεροπλάνου με τις θέσεις-->
            <img src="https://static.flight-report.com/media/photos/9397/1568986195AHMB/320-15241.jpg" usemap="#image_map" id = "image_map">

            <!--Δημιουργία divs για να μπορεί ο χρήστης να επιλέγει τις θέσεις πάνω στην εικόνα-->
            <div id="highlight-1A" class="highlight" onclick="selectedSeat('highlight-1A')" data-div-id="select_seat"></div>
            <div id="highlight-1B" class="highlight" onclick="selectedSeat('highlight-1B')" data-div-id="select_seat"></div>
            <div id="highlight-1C" class="highlight" onclick="selectedSeat('highlight-1C')" data-div-id="select_seat"></div>
            <div id="highlight-1D" class="highlight" onclick="selectedSeat('highlight-1D')" data-div-id="select_seat"></div>
            <div id="highlight-1E" class="highlight" onclick="selectedSeat('highlight-1E')" data-div-id="select_seat"></div>
            <div id="highlight-1F" class="highlight" onclick="selectedSeat('highlight-1F')" data-div-id="select_seat"></div>
            <div id="highlight-2A" class="highlight" onclick="selectedSeat('highlight-2A')" data-div-id="select_seat"></div>
            <div id="highlight-2B" class="highlight" onclick="selectedSeat('highlight-2B')" data-div-id="select_seat"></div>
            <div id="highlight-2C" class="highlight" onclick="selectedSeat('highlight-2C')" data-div-id="select_seat"></div>
            <div id="highlight-2D" class="highlight" onclick="selectedSeat('highlight-2D')" data-div-id="select_seat"></div>
            <div id="highlight-2E" class="highlight" onclick="selectedSeat('highlight-2E')" data-div-id="select_seat"></div>
            <div id="highlight-2F" class="highlight" onclick="selectedSeat('highlight-2F')" data-div-id="select_seat"></div>
            <div id="highlight-3A" class="highlight" onclick="selectedSeat('highlight-3A')" data-div-id="select_seat"></div>
            <div id="highlight-3B" class="highlight" onclick="selectedSeat('highlight-3B')" data-div-id="select_seat"></div>
            <div id="highlight-3C" class="highlight" onclick="selectedSeat('highlight-3C')" data-div-id="select_seat"></div>
            <div id="highlight-3D" class="highlight" onclick="selectedSeat('highlight-3D')" data-div-id="select_seat"></div>
            <div id="highlight-3E" class="highlight" onclick="selectedSeat('highlight-3E')" data-div-id="select_seat"></div>
            <div id="highlight-3F" class="highlight" onclick="selectedSeat('highlight-3F')" data-div-id="select_seat"></div>
            <div id="highlight-4A" class="highlight" onclick="selectedSeat('highlight-4A')" data-div-id="select_seat"></div>
            <div id="highlight-4B" class="highlight" onclick="selectedSeat('highlight-4B')" data-div-id="select_seat"></div>
            <div id="highlight-4C" class="highlight" onclick="selectedSeat('highlight-4C')" data-div-id="select_seat"></div>
            <div id="highlight-4D" class="highlight" onclick="selectedSeat('highlight-4D')" data-div-id="select_seat"></div>
            <div id="highlight-4E" class="highlight" onclick="selectedSeat('highlight-4E')" data-div-id="select_seat"></div>
            <div id="highlight-4F" class="highlight" onclick="selectedSeat('highlight-4F')" data-div-id="select_seat"></div>
            <div id="highlight-5A" class="highlight" onclick="selectedSeat('highlight-5A')" data-div-id="select_seat"></div>
            <div id="highlight-5B" class="highlight" onclick="selectedSeat('highlight-5B')" data-div-id="select_seat"></div>
            <div id="highlight-5C" class="highlight" onclick="selectedSeat('highlight-5C')" data-div-id="select_seat"></div>
            <div id="highlight-5D" class="highlight" onclick="selectedSeat('highlight-5D')" data-div-id="select_seat"></div>
            <div id="highlight-5E" class="highlight" onclick="selectedSeat('highlight-5E')" data-div-id="select_seat"></div>
            <div id="highlight-5F" class="highlight" onclick="selectedSeat('highlight-5F')" data-div-id="select_seat"></div>
            <div id="highlight-6A" class="highlight" onclick="selectedSeat('highlight-6A')" data-div-id="select_seat"></div>
            <div id="highlight-6B" class="highlight" onclick="selectedSeat('highlight-6B')" data-div-id="select_seat"></div>
            <div id="highlight-6C" class="highlight" onclick="selectedSeat('highlight-6C')" data-div-id="select_seat"></div>
            <div id="highlight-6D" class="highlight" onclick="selectedSeat('highlight-6D')" data-div-id="select_seat"></div>
            <div id="highlight-6E" class="highlight" onclick="selectedSeat('highlight-6E')" data-div-id="select_seat"></div>
            <div id="highlight-6F" class="highlight" onclick="selectedSeat('highlight-6F')" data-div-id="select_seat"></div>
            <div id="highlight-7A" class="highlight" onclick="selectedSeat('highlight-7A')" data-div-id="select_seat"></div>
            <div id="highlight-7B" class="highlight" onclick="selectedSeat('highlight-7B')" data-div-id="select_seat"></div>
            <div id="highlight-7C" class="highlight" onclick="selectedSeat('highlight-7C')" data-div-id="select_seat"></div>
            <div id="highlight-7D" class="highlight" onclick="selectedSeat('highlight-7D')" data-div-id="select_seat"></div>
            <div id="highlight-7E" class="highlight" onclick="selectedSeat('highlight-7E')" data-div-id="select_seat"></div>
            <div id="highlight-7F" class="highlight" onclick="selectedSeat('highlight-7F')" data-div-id="select_seat"></div>
            <div id="highlight-8A" class="highlight" onclick="selectedSeat('highlight-8A')" data-div-id="select_seat"></div>
            <div id="highlight-8B" class="highlight" onclick="selectedSeat('highlight-8B')" data-div-id="select_seat"></div>
            <div id="highlight-8C" class="highlight" onclick="selectedSeat('highlight-8C')" data-div-id="select_seat"></div>
            <div id="highlight-8D" class="highlight" onclick="selectedSeat('highlight-8D')" data-div-id="select_seat"></div>
            <div id="highlight-8E" class="highlight" onclick="selectedSeat('highlight-8E')" data-div-id="select_seat"></div>
            <div id="highlight-8F" class="highlight" onclick="selectedSeat('highlight-8F')" data-div-id="select_seat"></div>
            <div id="highlight-9A" class="highlight" onclick="selectedSeat('highlight-9A')" data-div-id="select_seat"></div>
            <div id="highlight-9B" class="highlight" onclick="selectedSeat('highlight-9B')" data-div-id="select_seat"></div>
            <div id="highlight-9C" class="highlight" onclick="selectedSeat('highlight-9C')" data-div-id="select_seat"></div>
            <div id="highlight-9D" class="highlight" onclick="selectedSeat('highlight-9D')" data-div-id="select_seat"></div>
            <div id="highlight-9E" class="highlight" onclick="selectedSeat('highlight-9E')" data-div-id="select_seat"></div>
            <div id="highlight-9F" class="highlight" onclick="selectedSeat('highlight-9F')" data-div-id="select_seat"></div>
            <div id="highlight-10A" class="highlight" onclick="selectedSeat('highlight-10A')" data-div-id="select_seat"></div>
            <div id="highlight-10B" class="highlight" onclick="selectedSeat('highlight-10B')" data-div-id="select_seat"></div>
            <div id="highlight-10C" class="highlight" onclick="selectedSeat('highlight-10C')" data-div-id="select_seat"></div>
            <div id="highlight-10D" class="highlight" onclick="selectedSeat('highlight-10D')" data-div-id="select_seat"></div>
            <div id="highlight-10E" class="highlight" onclick="selectedSeat('highlight-10E')" data-div-id="select_seat"></div>
            <div id="highlight-10F" class="highlight" onclick="selectedSeat('highlight-10F')" data-div-id="select_seat"></div>
            <div id="highlight-11A" class="highlight" onclick="selectedSeat('highlight-11A')" data-div-id="select_seat"></div>
            <div id="highlight-11B" class="highlight" onclick="selectedSeat('highlight-11B')" data-div-id="select_seat"></div>
            <div id="highlight-11C" class="highlight" onclick="selectedSeat('highlight-11C')" data-div-id="select_seat"></div> 
            <div id="highlight-11D" class="highlight" onclick="selectedSeat('highlight-11D')" data-div-id="select_seat"></div>
            <div id="highlight-11E" class="highlight" onclick="selectedSeat('highlight-11E')" data-div-id="select_seat"></div>
            <div id="highlight-11F" class="highlight" onclick="selectedSeat('highlight-11F')" data-div-id="select_seat"></div>
            <div id="highlight-12A" class="highlight" onclick="selectedSeat('highlight-12A')" data-div-id="select_seat"></div>
            <div id="highlight-12B" class="highlight" onclick="selectedSeat('highlight-12B')" data-div-id="select_seat"></div>
            <div id="highlight-12C" class="highlight" onclick="selectedSeat('highlight-12C')" data-div-id="select_seat"></div> 
            <div id="highlight-12D" class="highlight" onclick="selectedSeat('highlight-12D')" data-div-id="select_seat"></div>
            <div id="highlight-12E" class="highlight" onclick="selectedSeat('highlight-12E')" data-div-id="select_seat"></div>
            <div id="highlight-12F" class="highlight" onclick="selectedSeat('highlight-12F')" data-div-id="select_seat"></div>
            <div id="highlight-14A" class="highlight" onclick="selectedSeat('highlight-14A')" data-div-id="select_seat"></div>
            <div id="highlight-14B" class="highlight" onclick="selectedSeat('highlight-14B')" data-div-id="select_seat"></div>
            <div id="highlight-14C" class="highlight" onclick="selectedSeat('highlight-14C')" data-div-id="select_seat"></div> 
            <div id="highlight-14D" class="highlight" onclick="selectedSeat('highlight-14D')" data-div-id="select_seat"></div>
            <div id="highlight-14E" class="highlight" onclick="selectedSeat('highlight-14E')" data-div-id="select_seat"></div>
            <div id="highlight-14F" class="highlight" onclick="selectedSeat('highlight-14F')" data-div-id="select_seat"></div>
            <div id="highlight-15A" class="highlight" onclick="selectedSeat('highlight-15A')" data-div-id="select_seat"></div>
            <div id="highlight-15B" class="highlight" onclick="selectedSeat('highlight-15B')" data-div-id="select_seat"></div>
            <div id="highlight-15C" class="highlight" onclick="selectedSeat('highlight-15C')" data-div-id="select_seat"></div> 
            <div id="highlight-15D" class="highlight" onclick="selectedSeat('highlight-15D')" data-div-id="select_seat"></div>
            <div id="highlight-15E" class="highlight" onclick="selectedSeat('highlight-15E')" data-div-id="select_seat"></div>
            <div id="highlight-15F" class="highlight" onclick="selectedSeat('highlight-15F')" data-div-id="select_seat"></div>
            <div id="highlight-16A" class="highlight" onclick="selectedSeat('highlight-16A')" data-div-id="select_seat"></div>
            <div id="highlight-16B" class="highlight" onclick="selectedSeat('highlight-16B')" data-div-id="select_seat"></div>
            <div id="highlight-16C" class="highlight" onclick="selectedSeat('highlight-16C')" data-div-id="select_seat"></div>
            <div id="highlight-16D" class="highlight" onclick="selectedSeat('highlight-16D')" data-div-id="select_seat"></div>
            <div id="highlight-16E" class="highlight" onclick="selectedSeat('highlight-16E')" data-div-id="select_seat"></div>
            <div id="highlight-16F" class="highlight" onclick="selectedSeat('highlight-16F')" data-div-id="select_seat"></div>
            <div id="highlight-17A" class="highlight" onclick="selectedSeat('highlight-17A')" data-div-id="select_seat"></div>
            <div id="highlight-17B" class="highlight" onclick="selectedSeat('highlight-17B')" data-div-id="select_seat"></div>
            <div id="highlight-17C" class="highlight" onclick="selectedSeat('highlight-17C')" data-div-id="select_seat"></div>
            <div id="highlight-17D" class="highlight" onclick="selectedSeat('highlight-17D')" data-div-id="select_seat"></div>
            <div id="highlight-17E" class="highlight" onclick="selectedSeat('highlight-17E')" data-div-id="select_seat"></div>
            <div id="highlight-17F" class="highlight" onclick="selectedSeat('highlight-17F')" data-div-id="select_seat"></div>
            <div id="highlight-18A" class="highlight" onclick="selectedSeat('highlight-18A')" data-div-id="select_seat"></div>
            <div id="highlight-18B" class="highlight" onclick="selectedSeat('highlight-18B')" data-div-id="select_seat"></div>
            <div id="highlight-18C" class="highlight" onclick="selectedSeat('highlight-18C')" data-div-id="select_seat"></div>
            <div id="highlight-18D" class="highlight" onclick="selectedSeat('highlight-18D')" data-div-id="select_seat"></div>
            <div id="highlight-18E" class="highlight" onclick="selectedSeat('highlight-18E')" data-div-id="select_seat"></div>
            <div id="highlight-18F" class="highlight" onclick="selectedSeat('highlight-18F')" data-div-id="select_seat"></div>
            <div id="highlight-19A" class="highlight" onclick="selectedSeat('highlight-19A')" data-div-id="select_seat"></div>
            <div id="highlight-19B" class="highlight" onclick="selectedSeat('highlight-19B')" data-div-id="select_seat"></div>
            <div id="highlight-19C" class="highlight" onclick="selectedSeat('highlight-19C')" data-div-id="select_seat"></div>
            <div id="highlight-19D" class="highlight" onclick="selectedSeat('highlight-19D')" data-div-id="select_seat"></div>
            <div id="highlight-19E" class="highlight" onclick="selectedSeat('highlight-19E')" data-div-id="select_seat"></div>
            <div id="highlight-19F" class="highlight" onclick="selectedSeat('highlight-19F')" data-div-id="select_seat"></div>
            <div id="highlight-20A" class="highlight" onclick="selectedSeat('highlight-20A')" data-div-id="select_seat"></div>
            <div id="highlight-20B" class="highlight" onclick="selectedSeat('highlight-20B')" data-div-id="select_seat"></div>
            <div id="highlight-20C" class="highlight" onclick="selectedSeat('highlight-20C')" data-div-id="select_seat"></div>
            <div id="highlight-20D" class="highlight" onclick="selectedSeat('highlight-20D')" data-div-id="select_seat"></div>
            <div id="highlight-20E" class="highlight" onclick="selectedSeat('highlight-20E')" data-div-id="select_seat"></div>
            <div id="highlight-20F" class="highlight" onclick="selectedSeat('highlight-20F')" data-div-id="select_seat"></div>
            <div id="highlight-21A" class="highlight" onclick="selectedSeat('highlight-21A')" data-div-id="select_seat"></div>
            <div id="highlight-21B" class="highlight" onclick="selectedSeat('highlight-21B')" data-div-id="select_seat"></div>
            <div id="highlight-21C" class="highlight" onclick="selectedSeat('highlight-21C')" data-div-id="select_seat"></div>
            <div id="highlight-21D" class="highlight" onclick="selectedSeat('highlight-21D')" data-div-id="select_seat"></div>
            <div id="highlight-21E" class="highlight" onclick="selectedSeat('highlight-21E')" data-div-id="select_seat"></div>
            <div id="highlight-21F" class="highlight" onclick="selectedSeat('highlight-21F')" data-div-id="select_seat"></div>
            <div id="highlight-22A" class="highlight" onclick="selectedSeat('highlight-22A')" data-div-id="select_seat"></div>
            <div id="highlight-22B" class="highlight" onclick="selectedSeat('highlight-22B')" data-div-id="select_seat"></div>
            <div id="highlight-22C" class="highlight" onclick="selectedSeat('highlight-22C')" data-div-id="select_seat"></div>
            <div id="highlight-22D" class="highlight" onclick="selectedSeat('highlight-22D')" data-div-id="select_seat"></div>
            <div id="highlight-22E" class="highlight" onclick="selectedSeat('highlight-22E')" data-div-id="select_seat"></div>
            <div id="highlight-22F" class="highlight" onclick="selectedSeat('highlight-22F')" data-div-id="select_seat"></div>
            <div id="highlight-23A" class="highlight" onclick="selectedSeat('highlight-23A')" data-div-id="select_seat"></div>
            <div id="highlight-23B" class="highlight" onclick="selectedSeat('highlight-23B')" data-div-id="select_seat"></div>
            <div id="highlight-23C" class="highlight" onclick="selectedSeat('highlight-23C')" data-div-id="select_seat"></div>
            <div id="highlight-23D" class="highlight" onclick="selectedSeat('highlight-23D')" data-div-id="select_seat"></div>
            <div id="highlight-23E" class="highlight" onclick="selectedSeat('highlight-23E')" data-div-id="select_seat"></div>
            <div id="highlight-23F" class="highlight" onclick="selectedSeat('highlight-23F')" data-div-id="select_seat"></div>
            <div id="highlight-24A" class="highlight" onclick="selectedSeat('highlight-24A')" data-div-id="select_seat"></div>
            <div id="highlight-24B" class="highlight" onclick="selectedSeat('highlight-24B')" data-div-id="select_seat"></div>
            <div id="highlight-24C" class="highlight" onclick="selectedSeat('highlight-24C')" data-div-id="select_seat"></div>
            <div id="highlight-24D" class="highlight" onclick="selectedSeat('highlight-24D')" data-div-id="select_seat"></div>
            <div id="highlight-24E" class="highlight" onclick="selectedSeat('highlight-24E')" data-div-id="select_seat"></div>
            <div id="highlight-24F" class="highlight" onclick="selectedSeat('highlight-24F')" data-div-id="select_seat"></div>
            <div id="highlight-25A" class="highlight" onclick="selectedSeat('highlight-25A')" data-div-id="select_seat"></div>
            <div id="highlight-25B" class="highlight" onclick="selectedSeat('highlight-25B')" data-div-id="select_seat"></div>
            <div id="highlight-25C" class="highlight" onclick="selectedSeat('highlight-25C')" data-div-id="select_seat"></div>
            <div id="highlight-25D" class="highlight" onclick="selectedSeat('highlight-25D')" data-div-id="select_seat"></div>
            <div id="highlight-25E" class="highlight" onclick="selectedSeat('highlight-25E')" data-div-id="select_seat"></div>
            <div id="highlight-25F" class="highlight" onclick="selectedSeat('highlight-25F')" data-div-id="select_seat"></div>
            <div id="highlight-26A" class="highlight" onclick="selectedSeat('highlight-26A')" data-div-id="select_seat"></div>
            <div id="highlight-26B" class="highlight" onclick="selectedSeat('highlight-26B')" data-div-id="select_seat"></div>
            <div id="highlight-26C" class="highlight" onclick="selectedSeat('highlight-26C')" data-div-id="select_seat"></div>
            <div id="highlight-26D" class="highlight" onclick="selectedSeat('highlight-26D')" data-div-id="select_seat"></div>
            <div id="highlight-26E" class="highlight" onclick="selectedSeat('highlight-26E')" data-div-id="select_seat"></div>
            <div id="highlight-26F" class="highlight" onclick="selectedSeat('highlight-26F')" data-div-id="select_seat"></div>
            <div id="highlight-27A" class="highlight" onclick="selectedSeat('highlight-27A')" data-div-id="select_seat"></div>
            <div id="highlight-27B" class="highlight" onclick="selectedSeat('highlight-27B')" data-div-id="select_seat"></div>
            <div id="highlight-27C" class="highlight" onclick="selectedSeat('highlight-27C')" data-div-id="select_seat"></div>
            <div id="highlight-27D" class="highlight" onclick="selectedSeat('highlight-27D')" data-div-id="select_seat"></div>
            <div id="highlight-27E" class="highlight" onclick="selectedSeat('highlight-27E')" data-div-id="select_seat"></div>
            <div id="highlight-27F" class="highlight" onclick="selectedSeat('highlight-27F')" data-div-id="select_seat"></div>
            <div id="highlight-28A" class="highlight" onclick="selectedSeat('highlight-28A')" data-div-id="select_seat"></div>
            <div id="highlight-28B" class="highlight" onclick="selectedSeat('highlight-28B')" data-div-id="select_seat"></div>
            <div id="highlight-28C" class="highlight" onclick="selectedSeat('highlight-28C')" data-div-id="select_seat"></div>
            <div id="highlight-28D" class="highlight" onclick="selectedSeat('highlight-28D')" data-div-id="select_seat"></div>
            <div id="highlight-28E" class="highlight" onclick="selectedSeat('highlight-28E')" data-div-id="select_seat"></div>
            <div id="highlight-28F" class="highlight" onclick="selectedSeat('highlight-28F')" data-div-id="select_seat"></div>
            <div id="highlight-29A" class="highlight" onclick="selectedSeat('highlight-29A')" data-div-id="select_seat"></div>
            <div id="highlight-29B" class="highlight" onclick="selectedSeat('highlight-29B')" data-div-id="select_seat"></div>
            <div id="highlight-29C" class="highlight" onclick="selectedSeat('highlight-29C')" data-div-id="select_seat"></div>
            <div id="highlight-29D" class="highlight" onclick="selectedSeat('highlight-29D')" data-div-id="select_seat"></div>
            <div id="highlight-29E" class="highlight" onclick="selectedSeat('highlight-29E')" data-div-id="select_seat"></div>
            <div id="highlight-29F" class="highlight" onclick="selectedSeat('highlight-29F')" data-div-id="select_seat"></div>
            <div id="highlight-30A" class="highlight" onclick="selectedSeat('highlight-30A')" data-div-id="select_seat"></div>
            <div id="highlight-30B" class="highlight" onclick="selectedSeat('highlight-30B')" data-div-id="select_seat"></div>
            <div id="highlight-30C" class="highlight" onclick="selectedSeat('highlight-30C')" data-div-id="select_seat"></div>
            <div id="highlight-30D" class="highlight" onclick="selectedSeat('highlight-30D')" data-div-id="select_seat"></div>
            <div id="highlight-30E" class="highlight" onclick="selectedSeat('highlight-30E')" data-div-id="select_seat"></div>
            <div id="highlight-30F" class="highlight" onclick="selectedSeat('highlight-30F')" data-div-id="select_seat"></div>

            <!--Όταν επιλέγεται μια θέση προστίθεται στην κλάση "reserved"-->
            <script>
              var reservedSeats = <?php echo json_encode($seat); ?>;

              window.addEventListener('DOMContentLoaded', (event) => {
                reservedSeats.forEach(function(seatObj) {

                  const seatIds = seatObj.seats.split(',');
                  seatIds.forEach(seatId => {
                    const trimmedId = seatId.trim();
                    const highlightDiv = document.getElementById('highlight-' + trimmedId);
                    
                    if (highlightDiv) 
                    {
                      highlightDiv.classList.add("reserved");
                      highlightDiv.removeAttribute('onclick');
                    } 
                  });
                });
              });

            </script>

          </div>

          <div>

            <p class = "seats"><div class = "reserved"></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reserved Seat</p>
            <p class = "seats"><div class = "selected" style = "pointer-events: none;"></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Seat</p>

          </div>
          
        </div>

        <!--Εμφάνιση των στοιχείων της κράτησης αφού ο χρήστης έχει επιλέξει τις θέσεις-->
        <h2 style="text-align: center;">Booking Details</h2>

        <div style = "text-align: left; display: none;" id = "details" class = "details">

          <div class = "label" style = "padding-left: 20px;">
            
            <p>Departure Airport: </p><br>
            <p>Arrival Airport: </p><br>
            <p>Departure Date: </p><br>
            <p>Seat: </p><br>
            <p>Total Cost: </p><br>

          </div>
          
          <div class = "input">

            <p style = "padding-left: 20px;"><?php echo $_POST['dep_airp']; ?></p><br>
            <p><?php echo $_POST['arr_airp']; ?></p><br>
            <p><?php echo $_POST['date']; ?></p><br>
            <p id = "selected-seat"></p><br>
            <p id = "totalCost"></p><br>

          </div>
        
        </div>

        <button type = "submit" id = "reserveButton" disabled style = "display: none; margin:0px; text-align: center;" onclick = "SendSeats();">Reserve!</button>

      </form>

      <!--Στέλνει τα δεδομένα στην Calculate_Cost.php και InsertTrips.php με χρήση fetch-->
      <script>
        const formData = new FormData();
        const dep_airp = "<?php echo htmlspecialchars($_POST['dep_airp']); ?>";
        const arr_airp = "<?php echo htmlspecialchars($_POST['arr_airp']); ?>";
        const date = "<?php echo htmlspecialchars($_POST['date']); ?>";
        const fName = "<?php echo htmlspecialchars($fName); ?>";
        const lName = "<?php echo htmlspecialchars($lName); ?>";

        formData.append('dep_air', dep_airp);
        formData.append('arr_airp', arr_airp);
        formData.append('date', date);
        formData.append('fName', fName);
        formData.append('lName', lName);

        fetch('Calculate_Cost.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {

          totalCost(data, "0", "0");

        })
        .catch(error => console.error('Σφάλμα:', error));

        fetch('InsertTrips.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {

          console.log(formData);
          
        })
        .catch(error => console.error('Σφάλμα:', error));

      </script>

    </body>

    <!--Εμφάνιση του footer το οποίο αποτελείται από το τηλέφωνο το email και την τοποθεσία του αεροδρομίου-->
    <footer>

      <p>Contact with us!</p>
      <p>Call us in: <a href="tel:+306984678219">+306984678219</a></p>
      <p><a href="mailto:ntinal039@gmail.com">Click here to send an email</a></p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108201.22406226683!2d23.83271057488469!3d37.91833300345378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1901ad9e75c61%3A0x38b215df0aeeb3aa!2zzpTOuc61zrjOvc6uz4IgzpHOtc-Bzr_Ou865zrzOrc69zrHPgiDOkc64zrfOvc-Ozr0gzpXOu861z4XOuM6tz4HOuc6_z4IgzpLOtc69zrnOts6tzrvOv8-C!5e0!3m2!1sel!2sgr!4v1744274823333!5m2!1sel!2sgr"></iframe>

    </footer>
</html>