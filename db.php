<?php

$db['db_host'] = 'sql300.epizy.com';
$db['db_user'] = 'epiz_23463516';
$db['db_pass'] = 'E8XB8Zdq87Y';
$db['db_name'] = 'epiz_23463516_kirpyklax';

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//if ($connection) {
    //echo "We are connected";
//}


 ?>
