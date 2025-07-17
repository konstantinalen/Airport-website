<?php

  $servername = "mysql:host=localhost;dbname=air_ds";
  $username = "root";
  $password = "";
  $dbname = "air_ds";

  try 
  {
    $conn = new PDO($servername, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      
      $stmt = $conn->query("SELECT username FROM users");
      $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

      //Ελέγχει αν υπάρχει ήδη στην βάση το username που έβαλε ο χρήστης κατά την εγγραφή του
      if (count($users) > 0)
      {
        $f = true;
        foreach ($users as $username)
        {
          if ($_POST['username'] == $username)
          {
            $f = false;

            header("Location: LoginForm.php?errorRU=RUsername&showForm=register");
            exit();
          }
        }

        $stmt = $conn->query("SELECT email FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

        //Ελέγχει αν υπάρχει ήδη στην βάση το email που έβαλε ο χρήστης κατά την εγγραφή του
        $f1 = true;
        foreach ($users as $email)
        {
          if ($_POST['email'] == $email)
          {
            $f1 = false;

            header("Location: LoginForm.php?errorEmail=Email&showForm=register");
            exit();
          }
        }

        //Κάνει εισαγωγή στην βάση τα στοιχεία του χρήστη
        if ($f == "true" && $f1 == "true")
        {
          $username = $_POST['username'];
          $password = $_POST['password'];
          $email = $_POST['email'];

          $sql = "INSERT INTO users (first_name, last_name, username, password, email) VALUES (:fname, :lname, :username, :password, :email)";
          $stmt = $conn->prepare($sql);

          $stmt->bindParam(':fname', $fname);
          $stmt->bindParam(':lname', $lname);
          $stmt->bindParam(':username', $username);
          $stmt->bindParam(':password', $password);
          $stmt->bindParam(':email', $email);

          $stmt->execute();
        }
      }
      else 
      {
        $username = $_POST['username'];

          $password = $_POST['password'];
          $email = $_POST['email'];

          $sql = "INSERT INTO users (first_name, last_name, username, password, email) VALUES (:fname, :lname, :username, :password, :email)";
          $stmt = $conn->prepare($sql);

          $stmt->bindParam(':fname', $fname);
          $stmt->bindParam(':lname', $lname);
          $stmt->bindParam(':username', $username);
          $stmt->bindParam(':password', $password);
          $stmt->bindParam(':email', $email);

          $stmt->execute();
      }
    }
  }
  catch (PDOException $e)
  {
    echo "Failed " .$e->getMessage();
  }

  header("Location: LoginForm.php");

?>