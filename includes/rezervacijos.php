

        <h2>Ieskoti rezervaciju</h2>
         <!-- <a href="kirpeju.php?action=search&look=today">Siandienos</a> </li>
         <a href="kirpeju.php?action=search&look=tomorrow">Rytoj</a> </li> -->

         <form class="" action="includes/rezervacijos.php" method="post">
             <input type="submit" name="today" value="Siandien">
             <input type="submit" name="tomorow" value="Rytoj">
             <label for="data">Rezervacijos Data</label>
             <input type="date" name="data" value="" placeholder="Iveskite data">
             <input type="submit" name="submit" value="Ieskoti">

             <label for="name">Kliento Vardas</label>
             <input type="text" name="name" value="" placeholder="Iveskite varda">

             <input type="submit" name="submit" value="Ieskoti">
         </form>


         <table>
             <thead>
                 <th>id</th>
                 <th>Vardas</th>
                 <th>Pavarde</th>
                 <th>Data</th>
                 <th>Laikas</th>
                 <th>Kirpeja</th>
             </thead>

        <?php

        if (isset($_POST['submit'])) {
            if (isset($_POST['today'])) {
                        $today = date("Y-m-d", time());
                       echo $today;

                       $query = "SELECT * FROM registracijos WHERE reg_data LIKE '$today' ";

                       $regs_query = mysqli_query($connection, $query);

                       $count = mysqli_num_rows($regs_query);

                       if ($count == 0) {
                           echo "Nieko nerasta";
                       }

                       while ($row = mysqli_fetch_assoc($regs_query)) {
                           $id = $row['id'];
                           $name = $row['kliento_vardas'];
                           $surname = $row['kliento_pavarde'];
                           $date = $row['reg_data'];
                           $time = $row['reg_laikas'];
                           $employer = $row['kirpeja'];

                           echo"<tr>";
                           echo"<td>$id</td>";
                           echo"<td>$name</td>";
                           echo"<td>$surname</td>";
                           echo"<td>$date</td>";
                           echo"<td>$time</td>";
                           echo"<td>$employer</td>";
                           echo"</tr>";
            }
            // $action = $_GET['submit'];
            // switch ($action) {
            //     case 'today':
            //         $today = date("Y-m-d", time());
            //         echo $today;
            //
            //         $query = "SELECT * FROM registracijos WHERE reg_data LIKE '$today' ";
            //
            //         $regs_query = mysqli_query($connection, $query);
            //
            //         $count = mysqli_num_rows($regs_query);
            //
            //         if ($count == 0) {
            //             echo "Nieko nerasta";
            //         }
            //
            //         while ($row = mysqli_fetch_assoc($regs_query)) {
            //             $id = $row['id'];
            //             $name = $row['kliento_vardas'];
            //             $surname = $row['kliento_pavarde'];
            //             $date = $row['reg_data'];
            //             $time = $row['reg_laikas'];
            //             $employer = $row['kirpeja'];
            //
            //             echo"<tr>";
            //             echo"<td>$id</td>";
            //             echo"<td>$name</td>";
            //             echo"<td>$surname</td>";
            //             echo"<td>$date</td>";
            //             echo"<td>$time</td>";
            //             echo"<td>$employer</td>";
            //             echo"</tr>";
            //
            //         }
            //         break;
            //     case 'tomorrow':
            //     $d=strtotime("tomorrow");
            //     $tomorow = date("Y-m-d", $d);
            //
            //     echo $tomorow;
            //
            //     $query = "SELECT * FROM registracijos WHERE reg_data LIKE '$tomorow' ";
            //
            //     $regs_query = mysqli_query($connection, $query);
            //
            //     // if ($count == 0) {
            //     //     echo "Nieko nerasta";
            //     // }
            //
            //     while ($row = mysqli_fetch_assoc($regs_query)) {
            //         $id = $row['id'];
            //         $name = $row['kliento_vardas'];
            //         $surname = $row['kliento_pavarde'];
            //         $date = $row['reg_data'];
            //         $time = $row['reg_laikas'];
            //         $employer = $row['kirpeja'];
            //
            //         echo"<tr>";
            //         echo"<td>$id</td>";
            //         echo"<td>$name</td>";
            //         echo"<td>$surname</td>";
            //         echo"<td>$date</td>";
            //         echo"<td>$time</td>";
            //         echo"<td>$employer</td>";
            //         echo"</tr>";
            //
            //     }
            //         break;
            //     case 'date':
            //         // code...
            //         break;
            //     default:
            //         // code...
            //         break;
            // }
        }}?>


     </table>
    </body>
</html>
