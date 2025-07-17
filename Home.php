<!DOCTYPE html>
<html>

  <head>

    <title>Air Ds</title>

    <link rel="icon" type="jpg" href="https://static.vecteezy.com/system/resources/previews/023/616/612/non_2x/airplane-aviation-logo-design-concept-airline-logo-plane-travel-icon-airport-flight-world-aviation-vector.jpg"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="Air.css?v=4">
    <script src = "Air.js?v=5"></script>
    
  </head>

  <!--Παίρνει τα errors απο την php για τα πεδία της φόρμας-->
  <?php
    $errorRes = '';
    if (isset($_GET['errorRes']) && $_GET['errorRes'] === 'Res')
    {
      $errorRes = 'You have to fill all the inputs';
    }

    $errorRes1 = '';
    if (isset($_GET['errorRes1']) && $_GET['errorRes1'] === 'Res1')
    {
      $errorRes1 = 'Please put a valid date';
    }
  ?>

  <body>
    <!--Αν ο χρήστης είναι συνδεδεμένος φτιάχνει το bar menu με το κουμπί logout-->
    <?php $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null; ?>
    <?php if($username): ?> 
      <div class = "barmenu">
  
        <div class = "bar">
          <a>Air DS</a>

          <div id = "myLinks">

            <a href = "Home.php">Home</a>
                  
            <a href="MyTrips.php">My Trips</a>

            <!--Πάιρνει το όνομα του χρήστη για να το εμφανίσει-->
            <?php
              $servername = "mysql:host=localhost;dbname=air_ds";
              $username1 = "root";
              $password1 = "";
              $dbname = "air_ds";
          
              $conn1 = new PDO($servername, $username1, $password1);
              $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
              $stmt = $conn1->prepare("SELECT first_name FROM users WHERE username = :username");
              $stmt->execute(['username' => $username]);
              $name = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <div id="user_status">
              <a href = "Logout.php">Logout</a>
            </div>

          </div>
        </div>

        <div>
          <a>Welcome&nbsp; <?php echo   $name['first_name']; echo "!" ?></a>
        </div>

        <a href="javascript:void(0);" class="icon" onclick="Show_Links()">
          <div class="line">-</div>
          <div class="line">-</div>
          <div class="line">-</div>
        </a>
        
      </div>
    <?php endif; ?>

    <!--Αν ο χρήστης δεν είναι συνδεδεμένος φτιάχνει το bar menu με το κουμπί login-->
    <?php if (!$username): ?>
      <div class = "barmenu">
  
        <div class = "bar">
          <a>Air DS</a>

          <div id = "myLinks">

            <a href = "Home.php">Home</a>

              <div id="user_status">
                
                <a href = "LoginForm.php">Login</a>
              </div>

          </div>
        </div>
        <a href="javascript:void(0);" class="icon" onclick="Show_Links()">
          <div class="line">-</div>
          <div class="line">-</div>
          <div class="line">-</div>
        </a>

      </div>
    <?php endif; ?>

    <!--Η φόρμα που θα συμπληρώσει ο χρήστης σχετικά με τα αεροδρόμια άφιξης και αναχώρισης, την ημερομηνία και τον αριθμό των επιβατών στέλνεται στην php με όνομα Can_Reserve.php-->
    <form action = "Can_Reserve.php" method = "post" class = "formB">

      <h4>Make a reservation</h4>

      <div class = "reservation">

        <label class = "labels">Departure Airport</label>
        <select name = "Dep_Airp" id = "airport-select" class = "inputs">

          <option disabled selected>Loading airports...</option>

        </select><br><br><br>

        <label class = "labels">Arrival Airport</label>
        <select name = "Arr_Airp" id = "airport_select" class = "inputs">

          <option disabled selected>Loading airports...</option>

        </select><br><br><br>

        <label class = "labels">Departure Date</label>
        <input type = "date"  name = "date" id = "date" placeholder="Date" onblur = "CheckDate()" class = "inputs"></input><br><br><br>

        <label class = "labels">Number of People</label>
        <input type = "number"  name = "number" placeholder="Number of People" class = "inputs"></input><br><br><br>

      </div>

      <br><br><br>

    <!--Εμφανίζει τα σφάλματα σχετικά με τα κενά πεδία αν υπάρχουν-->
      <?php if ($errorRes): ?>
        <p style="color: red;"><?php echo $errorRes; ?></p>
      <?php endif; ?>

      <?php if ($errorRes1): ?>
        <p style="color: red;"><?php echo $errorRes1; ?></p>
      <?php endif; ?>
      
      <!--Αν ο χρήστης δεν είναι συνδεδεμένος το κουμπί παραμένει ανενεργό-->
      <button type = "submit" <?php if (!$username) echo 'disabled'; ?>>Make a reservation</button>
      
    </form>
    
  </body>

  <!--Εμφάνιση του footer το οποίο αποτελείται από το τηλέφωνο το email και την τοποθεσία του αεροδρομίου-->
  <footer>

    <p>Contact with us!</p>
    <p>Call us in: <a href="tel:+306984678219">+306984678219</a></p>
    <p><a href="mailto:ntinal039@gmail.com">Click here to send an email</a></p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108201.22406226683!2d23.83271057488469!3d37.91833300345378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1901ad9e75c61%3A0x38b215df0aeeb3aa!2zzpTOuc61zrjOvc6uz4IgzpHOtc-Bzr_Ou865zrzOrc69zrHPgiDOkc64zrfOvc-Ozr0gzpXOu861z4XOuM6tz4HOuc6_z4IgzpLOtc69zrnOts6tzrvOv8-C!5e0!3m2!1sel!2sgr!4v1744274823333!5m2!1sel!2sgr"></iframe>

  </footer>

</html>