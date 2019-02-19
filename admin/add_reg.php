<?php include "includes/admin_header.php" ?>

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

                    // check if client has active registration in Database

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

                        // resgistration query

                        reserveVisit($visits, $username, $surname, $date, $time, $worker);


                        // get id of reserved visit for get delete option

                        $res_id = getId($username, $surname);
                        // set cookies

                        setcookie("userId", $res_id, time() + (60*60*24*7), "/");
                        setcookie("userName", $username, time() + (60*60*24*7), "/");
                        setcookie("userSurname", $surname, time() + (60*60*24*7), "/");
                        setcookie("visitDate", $date, time() + (60*60*24*7), "/");
                        setcookie("visitTime", $time, time() + (60*60*24*7), "/");

                        $message = "Užregistruota " . $date . " dienai " . $time. " valandai";

                        $_SESSION['registered'] = true;

                        printAdminReg($message);
                    }else{
                        $message = $res_name . " " . $res_surname . " jau rezervavęs vizitą: " . $res_date . " " . $res_time;

                        printAdminReg($message);
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
                            $_SESSION['laikai'] = getBooked($worker, $date);

                            // echoes free times for specific worker and date
                            displayTimes($_SESSION['laikai']);
                        }else{
                            $message = "Atsiprašome, tačiau neturime laiko mašinos";

                            printAdminReg($message);
                        }

                    }else{
                        $message = "Privalote užpildyti visus laukelius!";

                        printAdminReg($message);
                    }
                }else{
                    if (!$_SESSION['registered']) {
                        $message = '';

                        printAdminReg($message);
                    }
                }
                    ?>
    </div>

    </body>
</html>
