<?php

function getBooked($worker, $date){
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

  function displayTimes($array, $worker){
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
