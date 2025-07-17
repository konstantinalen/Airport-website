<!DOCTYPE html>
<html>

  <body>

    <?php if (isset($_POST['Dep_Airp'], $_POST['Arr_Airp'], $_POST['date'], $_POST['number'])):?>
      
      <!--Δημιουργία κρυφής φόρμας ώστε να σταλθούν τα δεδομένα στην Book_Flight.php-->
      <form id = "data" action="Book_Flight.php" method="POST">

        <input type="hidden" name="dep_airp" value="<?= htmlspecialchars($_POST['Dep_Airp']) ?>">
        <input type="hidden" name="arr_airp" value="<?= htmlspecialchars($_POST['Arr_Airp']) ?>">
        <input type="hidden" name="date" value="<?= htmlspecialchars($_POST['date']) ?>">
        <input type="hidden" name="number" value="<?= htmlspecialchars($_POST['number']) ?>">

      </form>

      <!--Υποβολή της κρυφής φόρμας-->
      <script>
        document.getElementById('data').submit();
      </script>

    <?php endif; ?>

    <script src = "Air.js"></script>
  
  </body>
  
</html>

<?php 
  //Ελέγχει αν η ημερομνία αναχώρησης που έβαλε ο χρήστης είναι μετά την τωρινή. Αν δεν είναι στέλνει κατάλληλο μήνυμα
  $today = new DateTime();
  $today->format('Y-m-d');
  $date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
  $f = true;

  if ($date < $today)
  {
    $f = false;
  }
 
  //Ελέγχει αν όλα τα πεδία της φόρμας είναι συμπληρωμλενα από τον χρήστη. Αν δεν είναι στέλνει κατάλληλο μήνυμα
  if (empty($_POST['Dep_Airp']) || empty($_POST['Arr_Airp']) || empty($_POST['date']) || empty($_POST['number']))
  {
    header("Location: Home.php?errorRes=Res");
    exit();
  }
  else if ($f == false)
  {
    header("Location: Home.php?errorRes1=Res1");
    exit();
  }
?>