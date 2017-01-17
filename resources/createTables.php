<?php

include('./../resources/config.php');
include('./../resources/db.php');

try {
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE orders (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NULL,
    title VARCHAR(100) NULL,
    author VARCHAR(50) NULL, 
    firstname VARCHAR(30) NULL,
    lastname VARCHAR(30) NULL,
    affiliation VARCHAR(10) NULL,
    department VARCHAR(100) NULL,
    email VARCHAR(50) NULL,
    delivery VARCHAR(10) NULL,
    deliveryTime INT(6) NULL,
    deliveryTimePatron INT(6) NULL,
    date TIMESTAMP
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table orders created successfully";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$db = null;

?>