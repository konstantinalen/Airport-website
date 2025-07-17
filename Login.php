<?php

  $servername = "mysql:host=localhost;dbname=air_ds";
  $username = "root";
  $password = "";
  $dbname = "air_ds";

  try
  {
    $conn = new PDO($servername, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Αν το username που πληκτρολόγησε ο χρήστης κατά την σύνδεση του δεν υπάρχει στην βάση, στέλνει μήνυμα λάθους
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $inputUsername = $_POST['username'];
      $password = $_POST['password'];

      $stmt = $conn->query("SELECT username FROM users");
      $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

      $f = true;
      foreach ($users as $username)
      {
        if ($_POST['username'] == $username)
        {
          $f = false;
        }
      }

      //Αν το username που πληκτρολόγησε ο χρήστης κατά την σύνδεση του υπάρχει στην βάση ελέγχει το αντίστοιχο password. Αν δεν ταιριάζουν στέλνει μήνυμα λάθους
      if ($f)
      {
        header("Location: LoginForm.php?error=user");
        exit();
      }
      else
      {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $inputUsername);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbPassword = $result['password'];

        if ($dbPassword != $password)
        {
          header("Location: LoginForm.php?errorp=password");
          exit();
        }
      }
    } 
  }
  catch (PDOException $e)
  {
    echo "Failed " .$e->getMessage();
  }

  //Δημιουργία cookie όταν συνδέεται ο χρήστης
  if (!isset($_COOKIE["username"])) 
  {
    setcookie("username", $inputUsername, time() + (86400 * 30), "/");
    setcookie("password", $password, time() + (86400 * 30), "/");
  }

  header("Location: Home.php");

?>