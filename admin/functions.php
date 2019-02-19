<?php
function printClientForm($message){

    // prints clients registration form with given message.

    echo "<div class='reg-form'>
        <div class='form-groups'>
            <h2>Rezervuoti</h2>
            <h3 class='message'>$message</h3>
            <form class='' action='klientu_reg.php' method='post'>
                <label for='date'>Vardas</label>
                <input type='text' name='name' value='' placeholder='Jusu vardas'>

                <label for='date'>Pavarde</label>
                <input type='text' name='surname' value='' placeholder='Jusu pavarde'>

                <label for='date'>Data</label>
                <input type='date' name='date' value=''>

                <input class='btn' type='submit' name='testi' value='Tęsti'>
            </form>
    </div>
    </div>";

}
 ?>

<?php
function printAdminReg($message){

    // prints administration registration form with given message

    echo "<div class='reg_form'>
        <h2>Rezervuoti</h2>
        <div class='form-groups'>
            <h3 class='message'>$message</h3>
            <form class='' action='add_reg.php' method='post'>
                <label for='date'>Vardas</label>
                <input type='text' name='name' value='' placeholder='Jusu vardas'>

                <label for='date'>Pavarde</label>
                <input type='text' name='surname' value='' placeholder='Jusu pavarde'>

                <label for='date'>Data</label>
                <input type='date' name='date' value=''>

                <label for='worker'>Kirpėja</label>
                <select class='' name='worker' id='worker'>
                ";


                    // finds hairdressers names in db and displays as options
                    $kirpejos = getWorkers();

                    foreach ($kirpejos as $name) {
                        echo "<option value='$name'>$name</option>";
                    }

                echo "</select>
                <input class='btn' type='submit' name='testi' value='Tęsti'>
            </form>
            </div>

            </div>";
}
 ?>

<?php

function reserveVisit($visits, $username, $surname, $date, $time, $worker){

    // saves visit info into 'registracijos' table

    global $connection;

    $query = "INSERT INTO registracijos (visits, client_name, client_surname, res_date, res_time, worker) ";
    $query .= "VALUES ('$visits', '$username', '$surname', '$date', '$time', '$worker')";

    $reg_query = mysqli_query($connection, $query);

    if (!$reg_query) {
        die(mysqli_error($connection));
    }
}
 ?>

<?php

function getId($username, $surname){

    // return id of reservation where username and surname is like function
    // arguments. ID is used saved into cookies and used to delete a reservation
    // when user come back to site later

    global $connection;

    $get_id = "SELECT * FROM registracijos WHERE client_name = '$username' AND client_surname = '$surname' ";

    $id_query = mysqli_query($connection, $get_id);
    $id_data = mysqli_fetch_assoc($id_query);

    return $id_data['id'];

}

 ?>

<?php
function getVisitsCount($username, $surname){

    // returns the number of visits client have registered in 'klientai'
    // database. This number is used to calculate clients ability to get
    // a discount

    global $connection;

    $get_visit = "SELECT visits FROM klientai WHERE client_name = '$username' AND client_surname = '$surname'";

    $visit_query = mysqli_query($connection, $get_visit);
    $result = mysqli_fetch_assoc($visit_query);
    return $result['visits'];
}

 ?>
<?php
function cookieMessage(){

    // prints message about clients registered visit from saved cookies

    if (isset($_COOKIE["userName"])) {
        $cookieId = $_COOKIE['userId'];
        $cookieName = $_COOKIE['userName'];
        $cookieSurname = $_COOKIE['userSurname'];
        $cookieDate = $_COOKIE["visitDate"];
        $cookieTime = $_COOKIE["visitTime"];

        echo "Jūs jau esate užsiregistravęs: " . $cookieDate . " | " . $cookieTime . " <a class='message-btn' onClick=\"javacript: return confirm('Tikrai norite trinti?'); \" href='klientu_reg.php?delete=$cookieId&n=$cookieName&s=$cookieSurname'>Trinti</a>";

    }
}

 ?>

<?php
function deleteReservation($id, $name, $surname){

    // deletes reservation info from registracijos table and updates visits count

    global $connection;

    $today = date("Y-m-d", time());

    $query = "DELETE FROM registracijos WHERE id = $id";

    $delete_query = mysqli_query($connection, $query);

    $subtract_visit = "UPDATE klientai SET visits = visits - 1 WHERE client_name LIKE '$name' AND client_surname LIKE '$surname' AND visit >= 1 ";

    $subtract_query = mysqli_query($connection, $subtract_visit);

    setcookie('userId', '', time() - 1, '/');
    setcookie('userName', '', time() - 1, '/');
    setcookie('userSurname', '', time() - 1, '/');
    setcookie('visitDate', '', time() - 1, '/');
    setcookie('visitTime', '', time() - 1, '/');
}
 ?>
<?php
function updateReservations(){

    // deletes all reservations which are older than today

    global $connection;
    $today = date("Y-m-d", time());

    $query = "DELETE FROM registracijos WHERE res_date < '$today' ";

    $update_query = mysqli_query($connection, $query);

    if (!$update_query) {
        die(mysqli_error($connection));
    }
}
 ?>
<?php
function displayTimes($array){

    // displays all unbookded times for the particular hairdresser

    $times = [10.00, 10.15, 10.30, 10.45, 11.00, 11.15, 11.30, 11.45, 12.00, 12.15, 12.30, 12.45, 13.00, 13.15, 13.30, 13.45, 14.00, 14.15, 14.30, 14.45, 15.00, 15.15, 15.30, 15.45, 16.00, 16.15, 16.30, 16.45, 17.00, 17.15, 17.30, 17.45, 18.00, 18.15, 18.30, 18.45, 19.00, 19.15, 19.30, 19.45];

    echo "<table class='time_table'>";
    if (sizeof($array) != sizeof($times)) {
        foreach ($times as $time) {
            $time = number_format((float)$time, 2, '.', '');
            if (!in_array($time, $array)) {
                echo "<tr><td><p>" . $time . "</p><a class='btn' href='add_reg.php?time=$time'>Rezervuoti</></td></tr>";
            }else{
                echo "<tr><td><p>$time</p><p style='color: red; padding: 0.75rem'>Rezervuota</p></td></tr>";
            }
        }
        echo "</table>";
    }else{
        echo "Deja, bet kirpeja sia diena uzimta, pasirinkite kita diena!";
    }
}
 ?>
 <?php
 function displayVisits(){

     // displays all up to date registered visits in admin index.php page

     global $connection;

     if (isset($_POST['today'])) {
         $today = date("Y-m-d", time());

         $query = "SELECT * FROM registracijos WHERE res_date = '$today' ORDER BY visits DESC";
     }elseif (isset($_POST['tomorow'])) {
         $d = strtotime("tomorrow");
         $tomorow = date("Y-m-d", $d);

         $query = "SELECT * FROM registracijos WHERE res_date LIKE '$tomorow' ORDER BY visits DESC";
     }elseif (isset($_POST['data'])) {
         $date = $_POST['data'];

         $query = "SELECT * FROM registracijos WHERE res_date LIKE '$date' ORDER BY visits DESC";

     }elseif (isset($_POST['name'])) {
         $name = $_POST['name'];

         $query = "SELECT * FROM registracijos WHERE client_name = '$name' ORDER BY visits DESC";
     }else{

         $query = "SELECT * FROM registracijos ORDER BY visits DESC";

     }

     $visits_query = mysqli_query($connection, $query);

     if (!$visits_query) {
         die(mysqli_error($connection));
     }

     $count = mysqli_num_rows($visits_query);

     if ($count == 0) {
        echo "<h2>Nieko nerasta</h2>";
     }

     while ($row = mysqli_fetch_assoc($visits_query)) {

        $id = $row['id'];
        $visits = $row['visits'];
        $name = $row['client_name'];
        $surname = $row['client_surname'];
        $date = $row['res_date'];
        $time = $row['res_time'];
        $employer = $row['worker'];

        if ($visits % 5 == 0 && $visits != 0) {
            $discount = "<td class='yes'><i class='fas fa-check'></i></td>";
        }else{
            $discount = "<td><i class='fas fa-times'></i></td>";
        }

        echo"<tr>";
        echo"<td>$visits</td>";
        echo"<td>$name</td>";
        echo"<td>$surname</td>";
        echo"<td>$date</td>";
        echo"<td>$time</td>";
        echo"<td>$employer</td>";
        echo $discount;
        echo"<td> <a onClick=\"javacript: return confirm('Tikrai norite trinti?'); \" href='index.php?delete=$id&n=$name&s=$surname'><i class='fas fa-trash-alt'></i></a></td>";
        echo"</tr>";

    }}

  ?>
<?php

function updateVisitsCount($name, $surname){

    // checks if client is in db, if yes updates clients visits Count
    // if no adds client to db and adds one to visits count

    global $connection;


    $check_query = "SELECT * FROM klientai WHERE client_name LIKE '$name' AND client_surname LIKE '$surname' ";
    $check = mysqli_query($connection, $check_query);

    if (!$check) {
        die(mysqli_error($connection));
    }

    $count_client = mysqli_num_rows($check);

    if (!$count_client) {
        // add client if it is not in clients db
        $num = 1;
        $add_client = "INSERT INTO klientai (client_name, client_surname, visits) ";
        $add_client .= "VALUES('$name', '$surname', '$num')";

        $add_query = mysqli_query($connection, $add_client);
    }else{
        // updates client visits count by one if he is in db
        $update_query = "UPDATE klientai SET visits = visits + 1 WHERE client_name LIKE '$name' AND client_surname LIKE '$surname' ";
        $update = mysqli_query($connection, $update_query);
        }
    }
 ?>
 <?php

 function getBooked($worker, $date){

     // get all booked times for specific hairdresser and time from database
     // and returns array of that times

     global $connection;

     $booked = [];

     $query = "SELECT res_time FROM registracijos WHERE res_date = '$date' AND worker = '$worker'";

     $time_query = mysqli_query($connection, $query);

     while ($row = mysqli_fetch_array($time_query)) {
         array_push($booked, $row['res_time']);
     }

     return $booked;
 }
  ?>
  <?php

  function getWorkers(){

      // gets all hairdressers from database and puts them in array and returns
      // array

      global $connection;

      $workers = [];

      $query = "SELECT worker_name FROM kirpejos";

      $select_query = mysqli_query($connection, $query);

      if (!$select_query) {
          die(mysqli_error($connection));
      }

      while ($row = mysqli_fetch_array($select_query)) {
          array_push($workers, $row['worker_name']);
      }

      return $workers;
  }
   ?>
   <?php

   function displayTimesUsers($array, $worker){

       // prints table of free times for each hairdresser

       $times = [10.00, 10.15, 10.30, 10.45, 11.00, 11.15, 11.30, 11.45, 12.00, 12.15, 12.30, 12.45, 13.00, 13.15, 13.30, 13.45, 14.00, 14.15, 14.30, 14.45, 15.00, 15.15, 15.30, 15.45, 16.00, 16.15, 16.30, 16.45, 17.00, 17.15, 17.30, 17.45, 18.00, 18.15, 18.30, 18.45, 19.00, 19.15, 19.30, 19.45];

       if (sizeof($array) != sizeof($times)) {
           echo "<td class='worker'>$worker<input type='radio' name='worker' value='$worker'></td>";
           foreach ($times as $time) {
               $time = number_format((float)$time, 2, '.', '');
               if (!in_array($time, $array)) {
                   echo "<td><p>" . $time . "</p><input type='radio' name='time' value='$time'></td>";
               }else{
                   echo "<td><p style='color: black;'>X</p></td>";
               }
           }
       }else{
           echo "Deja, bet kirpeja sia diena uzimta, pasirinkite kita diena!";
       }
   }
    ?>
