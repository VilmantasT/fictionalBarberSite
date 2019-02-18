<?php session_start() ?>
<?php include "functions.php" ?>
<?php include "db.php" ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Netikra kirpykla</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/reg_style.css">
    </head>
    <body>

<nav id="navigation">
    <h1 class="logo">
        <i class="fas fa-cut"></i> KX
    </h1>
        <ul>
            <li><a href="../index.php">Atgal</a></li>
        </ul>
</nav>
<div id='message'>

    <?php


    if (isset($_COOKIE["userName"])) {
        $cookieId = $_COOKIE['userId'];
        $cookieName = $_COOKIE['userName'];
        $cookieSurname = $_COOKIE['userSurname'];
        $cookieDate = $_COOKIE["visitDate"];
        $cookieTime = $_COOKIE["visitTime"];

        echo "Jūs jau esate užsiregistravęs: " . $cookieDate . " | " . $cookieTime . " <a href='klientu_reg.php?delete=$cookieId&n=$cookieName&s=$cookieSurname'>Trinti</a>";

        }else {
        $someOne = "";
        }

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
                        $check_query = "SELECT * FROM klientai WHERE client_name LIKE '$username' AND client_surname LIKE '$surname' ";
                        $check = mysqli_query($connection, $check_query);

                        if (!$check) {
                            die(mysqli_error($connection));
                        }

                        $count_client = mysqli_num_rows($check);
                        echo $count_client;

                        if (!$count_client) {
                            // add client if it is not in clients db
                            $num = 1;
                            $add_client = "INSERT INTO klientai (client_name, client_surname, visits) ";
                            $add_client .= "VALUES('$username', '$surname', '$num')";

                            $add_query = mysqli_query($connection, $add_client);
                        }else{
                            // updates client visits count by one if he is in db
                            $update_query = "UPDATE klientai SET visits = visits + 1 WHERE client_name LIKE '$username' AND client_surname LIKE '$surname' ";
                            $update = mysqli_query($connection, $update_query);

                            if (!$update) {
                                die(mysqli_error($connection));
                            }
                        }

                        // gets client visits count from klientai db
                        $get_visit = "SELECT visits FROM klientai WHERE client_name = '$username' AND client_surname = '$surname'";

                        $visit_query = mysqli_query($connection, $get_visit);
                        $result = mysqli_fetch_assoc($visit_query);
                        $visits = $result['visits'];

                        // resgistration query

                        $query = "INSERT INTO registracijos (visits, client_name, client_surname, res_date, res_time, worker) ";
                        $query .= "VALUES ('$visits', '$username', '$surname', '$date', '$time', '$worker')";

                        $reg_query = mysqli_query($connection, $query);

                        if (!$reg_query) {
                            die(mysqli_error($connection));
                        }
                        // get id for get delete assert_options

                        $get_id = "SELECT * FROM registracijos WHERE client_name = '$username' AND client_surname = '$surname' ";

                        $id_query = mysqli_query($connection, $get_id);
                        $id_data = mysqli_fetch_assoc($id_query);

                        $res_id = $id_data['id'];

                        // set cookies
                        $id_cookie = "userId";
                        $id_value = $res_id;
                        $expiration = time() + (60*60*24*7);

                        setcookie($id_cookie, $id_value, $expiration);


                        $name_cookie = "userName";
                        $name_value = $username;
                        $expiration = time() + (60*60*24*7);

                        setcookie($name_cookie, $name_value, $expiration);

                        $surname_cookie = "userSurname";
                        $surname_value = $surname;
                        $expiration = time() + (60*60*24*7);

                        setcookie($surname_cookie, $surname_value, $expiration);

                        $date_cookie = "visitDate";
                        $date_value = $date;
                        $expiration = time() + (60*60*24*7);

                        setcookie($date_cookie, $date_value, $expiration);

                        $time_cookie = "visitTime";
                        $time_value = $time;
                        $expiration = time() + (60*60*24*7);

                        setcookie($time_cookie, $time_value, $expiration);
                        ?>
                        <script type="text/javascript">
                            writeMessage($res_id, $username, $surname);
                        </script>


                        <?php
                        // echo "<br><br><p>Jūs sėkmingai užsiregistravote " . $date . " dienai " . $time. " valandai</p>";

                    
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
                            $_SESSION['laikai'] = [];
                            $_SESSION['workers'] = [];

                            echo "<form action='klientu_reg.php' method='post'>";
                            echo "<table class='book-times'>";
                            $_SESSION['workers'] = getWorkers();

                            foreach ($_SESSION['workers'] as $worker) {
                                echo "<tr>";
                                $booked = getBooked($worker, $_SESSION['date']);
                                displayTimes($booked, $worker);
                                echo "</tr>";

                            }

                            echo "</table>";
                            echo "<input class='btn' type='submit' name='reserve' value='Rezervuoti'>";
                            echo "</form>";

                        }else{
                            echo "Atsiprašome , tačiau neturime laiko mašinos";
                        }

                    }else{
                        echo "<p>Privalote užpildyti visus laukelius!</p>";
                    }
                }else{ ?>

            <div class="reg-form">
                <div class="form-groups">
                    <h2>Rezervuoti</h2>
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

        $query = "DELETE FROM registracijos WHERE id = $the_id";

        $delete_query = mysqli_query($connection, $query);

        $subtract_visit = "UPDATE klientai SET visits = visits - 1 WHERE client_name LIKE '$name' AND client_surname LIKE '$surname' ";

        $subtract_query = mysqli_query($connection, $subtract_visit);

        // echo "Registracija sekmingai istrinta!";
        // unset cookies
        $id_cookie = "userId";
        $id_value = '';
        $expiration = time() - 1;

        setcookie($id_cookie, $id_value, $expiration);


        $name_cookie = "userName";
        $name_value = '';
        $expiration = time() - 1;

        setcookie($name_cookie, $name_value, $expiration);

        $surname_cookie = "userSurname";
        $surname_value = '';
        $expiration = time() - 1;

        setcookie($surname_cookie, $surname_value, $expiration);

        $date_cookie = "visitDate";
        $date_value = '';
        $expiration = time() - 1;

        setcookie($date_cookie, $date_value, $expiration);

        $time_cookie = "visitTime";
        $time_value = '';
        $expiration = time() - 1;

        setcookie($time_cookie, $time_value, $expiration);

        header("Location: klientu_reg.php");
    }
     ?>
    <script src="../js/main.js" type="text/javascript"></script>
    </body>
</html>
