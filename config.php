<?php

/*
This file contains db configuration assuming you are running MySQL using user "root" and password "".
*/

define('DB_SERVER', '127.0.0.1:4306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'signup_details');

// try to connect to the db;
$conn  = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die('Error: Cannot connect. ' . mysqli_connect_error());
    
}
//else{
  //  echo'Welcome here ,  Connection Successfully applied';
//}

// If you have additional code related to directory operations, please provide more details.

?>
