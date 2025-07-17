<!DOCTYPE html>
<html>

    <head>
        
      <title>Login/Register</title>
      <link rel="website icon" type="jpg" href="https://static.vecteezy.com/system/resources/previews/023/616/612/non_2x/airplane-aviation-logo-design-concept-airline-logo-plane-travel-icon-airport-flight-world-aviation-vector.jpg"/>
      
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src = "Air.js?v=63"></script>
      <link rel="stylesheet" href="Air.css?v=4">
    </head>

    <!--Παίρνει τα errors απο την php για τα πεδία της φόρμας-->
    <?php
      $error = '';
      if (isset($_GET['error']) && $_GET['error'] === 'user')
      {
          $error = 'Λάθος username';
      }
    ?>

    <?php
      $errorRU = '';
      if (isset($_GET['errorRU']) && $_GET['errorRU'] === 'RUsername')
      {
        $errorRU = 'The username has already been used';
      }
    ?>

    <?php
      $errorEmail = '';
      if (isset($_GET['errorEmail']) && $_GET['errorEmail'] === 'Email')
      {
        $errorEmail = 'The email has already been used';
      }
    ?>

    <?php
      $errorp = '';
      if (isset($_GET['errorp']) && $_GET['errorp'] === 'password')
      {
        $errorp = 'Λάθος password';
      }
    ?>

    <body>
      <!--Εμφάνιση του bar menu-->
      <?php $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null; ?>
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

      <!--Η φόρμα που συμπληρώνει ο χρήστης όταν κάνει login στελνεται στην php με όνομα Login.php-->
      <form id = "LoginForm" action = "Login.php" method = "post" class = "formB">

        <label class = "labels">Username</label><br>
        <input type = "text" name = "username" class = "inputs" placeholder="&#128100"></input><br><br>

        <label class = "labels">Password</label><br>
        <input type = "password" name = "password" class = "inputs" placeholder="&#x1F5DD&#xFE0F"></input><br><br>

        <!--Εμφάνιση των σφαλμάτων που στάλθηκαν από την php αν υπάρχουν-->
        <?php if ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($errorp): ?>
          <p style="color: red;"><?php echo $errorp; ?></p>
        <?php endif; ?>

        <button type = "submit">Login</button>

        <p class = "Register">Don't you have an account? <a href = "javascript:void(0);" onclick="Show_Register()">Register here!</a></p>

      </form>

      <!--Η φόρμα που συμπληρώνει ο χρήστης όταν κάνει εγγραφή στέλνεται στην php με όνομα Register.php-->
      <form style = "display: none;" data-error="<?php echo htmlspecialchars($errorRU); ?>" id = "RegisterForm" action = "Register.php" method = "post" class = "formB">
        <label>First Name</label><br>
        <input type = "text" name = "fname" id = "fname" oninput="Check_FName()" class = "inputs"></input><br><br>
        <p class = "disclaimer">Must contain only characters</p><br>

        <label>Last Name</label><br>
        <input type = "text" name = "lname" id = "lname" onkeyup="Check_LName()" class = "inputs"></input><br><br>
        <p class = "disclaimer">Must contain only characters</p><br>

        <label>Username</label><br>
        <input type = "text" name = "username" id = "username" onkeyup="Check_Username()" class = "inputs"></input><br><br>

        <?php if ($errorRU): ?>
          <script>
            rform.style.display = "block";
            lform.style.display = "none";
          </script>
          <p style="color: red;"><?php echo $errorRU; ?></p>
        <?php endif; ?>

        <label>Password</label><br>
        <input type = "password" name = "password" id = "password" onkeyup="Check_Password()" class = "inputs"></input><br><br>
        <p class = "disclaimer">Must contain at least one number and length from 4 to 10</p><br>

        <label>Email</label><br>
        <input type = "email" name = "email" id = "email" onkeyup = "Check_Email()" class = "inputs"></input><br><br>
        <p class = "disclaimer">Must contain '@'</p><br>

        <?php if ($errorEmail): ?>
          <script>
            rform.style.display = "block";
            lform.style.display = "none";
          </script>
          <p style="color: red;"><?php echo $errorEmail; ?></p>
        <?php endif; ?>

        <!--Αν υπάρχουν λάθη ή κενά στα πεδία που συμπλήρωσε ο χρήστης το κουμπί παραμένει ανενεργό-->
        <button type = "submit" id = "regBtn" disabled>Register!</button>
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