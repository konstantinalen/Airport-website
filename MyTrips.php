<!DOCTYPE html>
<html>

    <!--Σύνδεση με την βάση ώστε να πάρει όλες τις κρατήσεις που έχει κάνει ο χρήστης-->
    <?php  

      $servername = "mysql:host=localhost;dbname=air_ds";
      $username = "root";
      $password = "";
      $dbname = "air_ds";

      $username1 = $_COOKIE['username'];
      
      try 
      {
        $conn = new PDO($servername, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt1 = $conn->prepare("SELECT first_name FROM users WHERE username = :fname");
        $stmt1->execute(['fname' => $username1]);
        $fName = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $conn->prepare("SELECT last_name FROM users WHERE username = :fname");
        $stmt2->execute(['fname' => $username1]);
        $lName = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT * FROM reservations WHERE first_name = :fname AND last_name = :lname");
        $stmt->execute(['fname' => $fName[0]['first_name'], 'lname' => $lName[0]['last_name']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt3 = $conn->prepare("SELECT departure_date FROM reservations WHERE first_name = :fName AND last_name = :lName");
        $stmt3->execute(['fName' => $fName[0]['first_name'], 'lName' => $lName[0]['last_name']]);
        $date = $stmt3->fetchAll(PDO::FETCH_ASSOC);

      }
      catch(PDOException $e)
      {
          echo "Failed " .$e->getMessage();
      }  
    
    ?>

    <head>

        <title>My Trips</title>

        <link rel="website icon" type="jpg" href="https://static.vecteezy.com/system/resources/previews/023/616/612/non_2x/airplane-aviation-logo-design-concept-airline-logo-plane-travel-icon-airport-flight-world-aviation-vector.jpg"/>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="Air.css?v=4">
        <script src = "Air.js?v=35"></script>

    </head>

    <body class = "trips">

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

      <!--Δημιουργία πίνακα με όλες τις κρατήσεις που έχει κάνει ο χρήστης. Αν δεν υπάρχουν κρατήσεις σε αυτό το όνομα, εμφανίζεται κατάλληλο μήνυμα-->
      <?php if (count($result)=="0"):?>
        <p class = "trips">You have no trips yet!</p>
      <?php else: ?>
        <p class = "title">My Trips</p>
        <div class = "page-wrapper">
          <main class="content-area" style="overflow-x: auto;">
            <table class = "table">
                <tr>

                  <th>Departure Airport</th>
                  <th>Arrival Airport</th>
                  <th>Departure Date</th>
                  <th>Seats</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Taxes</th>
                  <th>Seat Cost</th>
                  <th></th>

                </tr>
                <?php foreach ($result as $row): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['departure_airport']); ?></td>
                    <td><?php echo htmlspecialchars($row['arrival_airport']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['seats']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['taxes']); ?></td> 
                    <td><?php echo htmlspecialchars($row['seat_cost']); ?></td>

                    <!--Αν η διαφορά της τωρινής ημερομηνίας με την ημερομηνία κράτησης είναι μεγαλύτερη του 30, εμφανίζεται ένα κουμπί ώστε να μπορεί ο χρήστης να κάνει ακύρωση-->
                    <?php

                      $today = new DateTime();
                      $flightDate = new DateTime($row['departure_date']);
                      $interval = $today->diff($flightDate);

                      if ($interval->days >= 30 && $flightDate > $today):?>
                        <td><button style = "font-size: 12px; padding: 5px 10px;" onclick = "Cancel_Res(<?php echo $row['res_id']; ?>)" data-id="<?php echo $row['res_id']; ?>">Cancel</button></td> 
                      <?php else: ?>
                        <td><p>-</p></td> 
                      <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
            </table>
          </main>
        </div>
      <?php endif; ?>                
      
    </body>

    <!--Εμφάνιση του footer το οποίο αποτελείται από το τηλέφωνο το email και την τοποθεσία του αεροδρομίου-->
    <?php $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null; ?>
    <?php if(count($result)=="0"): ?> 
    <footer class = "FT">

        <p>Contact with us!</p>
        <p>Call us in: <a href="tel:+306984678219">+306984678219</a></p>
        <p><a href="mailto:ntinal039@gmail.com">Click here to send an email</a></p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108201.22406226683!2d23.83271057488469!3d37.91833300345378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1901ad9e75c61%3A0x38b215df0aeeb3aa!2zzpTOuc61zrjOvc6uz4IgzpHOtc-Bzr_Ou865zrzOrc69zrHPgiDOkc64zrfOvc-Ozr0gzpXOu861z4XOuM6tz4HOuc6_z4IgzpLOtc69zrnOts6tzrvOv8-C!5e0!3m2!1sel!2sgr!4v1744274823333!5m2!1sel!2sgr"></iframe>

    </footer>
    <?php else: ?>
        <footer>

            <p>Contact with us!</p>
            <p>Call us in: <a href="tel:+306984678219">+306984678219</a></p>
            <p><a href="mailto:ntinal039@gmail.com">Click here to send an email</a></p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108201.22406226683!2d23.83271057488469!3d37.91833300345378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1901ad9e75c61%3A0x38b215df0aeeb3aa!2zzpTOuc61zrjOvc6uz4IgzpHOtc-Bzr_Ou865zrzOrc69zrHPgiDOkc64zrfOvc-Ozr0gzpXOu861z4XOuM6tz4HOuc6_z4IgzpLOtc69zrnOts6tzrvOv8-C!5e0!3m2!1sel!2sgr!4v1744274823333!5m2!1sel!2sgr"></iframe>

        </footer>
    <?php endif; ?>
</html>

