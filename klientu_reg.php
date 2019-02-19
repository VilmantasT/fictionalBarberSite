<?php include "includes/header.php" ?>
        <link rel="stylesheet" href="css/reg_style.css">
    </head>
    <body>

<nav id="navigation">
    <h1 class="logo">
        <i class="fas fa-cut"></i> KX
    </h1>
        <ul>
            <li><a href="index.php">Atgal</a></li>
        </ul>
</nav>

<div class='message'>

    <?php

    cookieMessage();

     ?>

</div>

    <div class="container-reg">

                <?php
                if (isset($_POST['reserve'])) {
                    $time = $_POST['time'];
                    $username = $_SESSION['username'];
                    $username = ucfirst($username);
                    $surname = $_SESSION['surname'];
                    $surname = ucfirst($surname);
                    $date = $_SESSION['date'];
                    $worker = $_POST['worker'];

                    // check if client has active registration in SQLiteDatabase

                    $check_reserv = "SELECT * FROM registracijos WHERE client_name = '$username' AND client_surname = '$surname' ";

                    $check_visit = mysqli_query($connection, $check_reserv);
                    $visit_data = mysqli_fetch_assoc($check_visit);

                    $res_id = $visit_data['id'];
                    $res_name = $visit_data['client_name'];
                    $res_surname = $visit_data['client_surname'];
                    $res_date = $visit_data['res_date'];
                    $res_time = $visit_data['res_time'];

                    $count_visit = mysqli_num_rows($check_visit);

                    // if there is registered visit prints message else registers new visit
                    if (!$count_visit) {

                        // update reservations Count
                        updateVisitsCount($username, $surname);

                        // gets client visits count from klientai db

                        $visits = getVisitsCount($username, $surname);

                        // reserve a visit in registracijos table

                        reserveVisit($visits, $username, $surname, $date, $time, $worker);

                        // get id of reserved visit for get delete option

                        $res_id = getId($username, $surname);
                        echo $res_id;
                        // set cookies

                        setcookie("userId", $res_id, time() + (60*60*24*7), "/");
                        setcookie("userName", $username, time() + (60*60*24*7), "/");
                        setcookie("userSurname", $surname, time() + (60*60*24*7), "/");
                        setcookie("visitDate", $date, time() + (60*60*24*7), "/");
                        setcookie("visitTime", $time, time() + (60*60*24*7), "/");

                        echo "<p>Sėkmingai užsiregistruota " . $date . " dienai " . $time. " valandai</p>";

                    }else{
                        echo $res_name . " " . $res_surname . " jau rezervavęs vizitą: " . $res_date . " " . $res_time . " <a href='klientu_reg.php'>Trinti</a>";
                    }
                }

                 ?>
                <?php
                if (isset($_POST['testi'])) {
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $date = $_POST['date'];

                    if (!empty($name) && !empty($surname) && !empty($date)) {
                        if ($date >= date("Y-m-d", time())) {

                            $_SESSION['username'] = $name;
                            $_SESSION['surname'] = $surname;
                            $_SESSION['date'] = $date;

                            echo "<form action='klientu_reg.php' method='post'>";
                            echo "<table class='book-times'>";
                            $workers= getWorkers();

                            foreach ($workers as $worker) {
                                echo "<tr>";
                                $booked = getBooked($worker, $_SESSION['date']);
                                displayTimesUsers($booked, $worker);
                                echo "</tr>";

                            }

                            echo "</table>";
                            echo "<input class='btn' type='submit' name='reserve' value='Rezervuoti'>";
                            echo "</form>";

                        }else{
                            echo "<p class='message'>Atsiprašome , tačiau neturime laiko mašinos</p>";
                        }

                    }else{
                        echo '<script> showMessage("message"); </script>';
                        // echo "<p class='message'>Privalote užpildyti visus laukelius!</p>";
                    }
                }else{ ?>

            <div class="reg-form">
                <div class="form-groups">
                    <h2>Rezervuoti</h2>
                    <p id="message"></p>
                    <form class="" action="klientu_reg.php" method="post">
                        <label for="date">Vardas</label>
                        <input type="text" name="name" value="" placeholder="Jusu vardas">

                        <label for="date">Pavarde</label>
                        <input type="text" name="surname" value="" placeholder="Jusu pavarde">

                        <label for="date">Data</label>
                        <input type="date" name="date" value="">

                        <input class="btn" type="submit" name="testi" value="Tęsti">
                    </form>
            </div>
            </div>
                    <?php } ?>

    </div>
    <?php

    // deletes a visit from database

    if (isset($_GET['delete'])) {

        $the_id = $_GET['delete'];
        $name = $_GET['n'];
        $surname = $_GET['s'];

        deleteReservation($the_id, $name, $surname);

        header("Location: klientu_reg.php");
    }
     ?>

    </body>
     <script src="js/main.js" charset="utf-8"></script>
</html>
