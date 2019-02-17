<?php
function updateReservations(){
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

        if ($visits % 5 == 0) {
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
        echo"<td> <a href='index.php?delete=$id&n=$name&s=$surname'><i class='fas fa-trash-alt'></i></a></td>";
        echo"</tr>";

    }}

  ?>
