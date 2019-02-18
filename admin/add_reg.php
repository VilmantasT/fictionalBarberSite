<?php include "includes/admin_header.php" ?>
<?php session_start() ?>
<nav id="navigation">
    <h1 class="logo">
        <i class="fas fa-cut"></i> KX
    </h1>
        <ul>
            <li><a href="index.php">Atgal</a></li>
        </ul>
</nav>

    <div class="container">

                <?php
                if (isset($_GET['time'])) {
                    $time = $_GET['time'];
                    $username = $_SESSION['username'];
                    $username = ucfirst($username);
                    $surname = $_SESSION['surname'];
                    $surname = ucfirst($surname);
                    $date = $_SESSION['date'];
                    $worker = $_SESSION['worker'];

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
                        $get_visit = "SELECT visits FROM klientai WHERE client_name = '$username' AND client_surname = '$surname'";

                        $visit_query = mysqli_query($connection, $get_visit);
                        $result = mysqli_fetch_assoc($visit_query);
                        $visit = $result['visits'];

                        // resgistration query

                        $query = "INSERT INTO registracijos (visits, client_name, client_surname, res_date, res_time, worker) ";
                        $query .= "VALUES ('$visit', '$username', '$surname', '$date', '$time', '$worker')";

                        $reg_query = mysqli_query($connection, $query);

                        if (!$reg_query) {
                            die(mysqli_error($connection));
                        }

                        echo "<p class='message'>Jūs sėkmingai užsiregistravote " . $date . " dienai " . $time. " valandai</p>";
                    }else{
                        echo "<p class='message'>" . $res_name . " " . $res_surname . " jau rezervavęs vizitą: " . $res_date . " " . $res_time . " <a href=''>Trinti</a></p>";
                    }
                }

                 ?>
                <?php
                if (isset($_POST['testi'])) {
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $date = $_POST['date'];
                    $worker = $_POST['worker'];
                    if (!empty($name) && !empty($surname) && !empty($date) && !empty($worker)) {
                        if ($date >= date("Y-m-d", time())) {

                            $_SESSION['username'] = $name;
                            $_SESSION['surname'] = $surname;
                            $_SESSION['date'] = $date;
                            $_SESSION['worker'] = $worker;
                            $_SESSION['laikai'] = [];

                            $query = "SELECT res_time FROM registracijos WHERE res_date = '$date' AND worker = '$worker'";

                            $time_query = mysqli_query($connection, $query);

                            while ($row = mysqli_fetch_array($time_query)) {
                                array_push($_SESSION['laikai'], $row['res_time']);
                            }

                            displayTimes($_SESSION['laikai']);
                        }else{
                            echo "<p class='message'>Atsiprašome , tačiau neturime laiko mašinos</p>";
                        }

                    }else{
                        echo "<p class='message'>Privalote užpildyti visus laukelius!</p>";
                    }
                }else{ ?>

            <div class="reg_form">
                <h2>Rezervuoti</h2>
                <div class="form-groups">
                    <form class="" action="add_reg.php" method="post">
                        <label for="date">Vardas</label>
                        <input type="text" name="name" value="" placeholder="Jusu vardas">

                        <label for="date">Pavarde</label>
                        <input type="text" name="surname" value="" placeholder="Jusu pavarde">

                        <label for="date">Data</label>
                        <input type="date" name="date" value="">

                        <label for="worker">Kirpėja</label>
                        <select class="" name="worker" id="worker">

                            <?php

                            // finds hairdressers names in db and displays as options
                            $kirpejos = getWorkers();

                            foreach ($kirpejos as $name) {
                                echo "<option value='$name'>$name</option>";
                            }

                             ?>
                        </select>
                        <input class="btn" type="submit" name="testi" value="Tęsti">
                    </form>
    </div>
    </div>
                    <?php } ?>

    </div>
    </body>
</html>
