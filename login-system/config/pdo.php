<?php

// Connect to the MySQL database using PDO
$pdo = new PDO('mysql:host=localhost;dbname=login-system-db;port=8889', 'akaki', 'akaki1234');

// check db connection
// if ($pdo) {
//     echo 'Successfuly connected to the MySQL database';
// } else {
//     echo 'Cannot connect to the MySQL database';
// }