<?php include "includes/admin_header.php" ?>

<nav id="navigation">
    <h1 class="logo">
        <i class="fas fa-cut"></i> KX
    </h1>
        <ul>
            <li><a href="add_reg.php">Rezervuoti</a></li>
            <li><a href="../index.php">Išeiti</a></li>
        </ul>
</nav>

<div class="main">



<div class="container">

            <h2 class="text-center l-heading">Rezervacijų Paieška</h2>
    <div class="form">

         <!-- <a href="kirpeju.php?action=search&look=today">Siandienos</a> </li>
         <a href="kirpeju.php?action=search&look=tomorrow">Rytoj</a> </li> -->

         <form class="" action="" method="post">
             <input class="btn" type="submit" name="today" value="Šiandien">
         </form>
          <form class="" action="" method="post">
             <input class="btn" type="submit" name="tomorow" value="Rytoj">
         </form>
          <form class="" action="" method="post">
             <label for="data">Data: </label>
             <input class="input" type="date" name="data" value="" placeholder="Įveskite datą">
             <input class="btn" type="submit" name="submit" value="Ieškoti">
         </form>
         <form class="" action="" method="post">
             <label for="name">Vardas: </label>
             <input class="input" type="text" name="name" value="" placeholder="Įveskite vardą">
             <input class="btn" type="submit" name="submit" value="Ieškoti">
         </form>

    </div>




             <table class="visits">
                 <thead>
                     <th>Vizitai</th>
                     <th>Vardas</th>
                     <th>Pavardė</th>
                     <th>Data</th>
                     <th>Laikas</th>
                     <th>Kirpėja</th>
                     <th>Nuolaida</th>
                     <th>Trinti</th>
                 </thead>

            <?php
                // deletes all visits that are older than today
                updateReservations();
                // displays visits based on selected condition
                displayVisits();

            ?>
         </table>
</div>
</div>
<?php

// deletes a visit from database

if (isset($_GET['delete'])) {

    $the_id = $_GET['delete'];
    $name = $_GET['n'];
    $surname = $_GET['s'];

    $query = "DELETE FROM registracijos WHERE id = $the_id";

    $delete_query = mysqli_query($connection, $query);

    $subtract_visit = "UPDATE klientai SET visits = visits - 1 WHERE client_name LIKE '$name' AND client_surname LIKE '$surname' ";

    $subtract_query = mysqli_query($connection, $subtract_visit);

    // echo "Registracija sekmingai istrinta!";

    header("Location: index.php");
}
 ?>
</body>
</html>
