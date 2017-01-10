<?php

include('./../resources/lib/httpful/httpful.phar');
include('./../resources/config.php');
include('email.php');

// get data from POST
$isbn = $_POST['isbn'];
$title = $_POST['title'];
$author = $_POST['author'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$affiliation = $_POST['affiliation'];
$department = $_POST['department'];
$email = $_POST['email'];
$delivery = $_POST['delivery'];
$deliveryTimePatron = $_POST['deliveryTimePatron'];
$deliveryTime = $_POST['deliveryTime'];

	
// insert into db
try {
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO orders (isbn, title, author, firstname, lastname, affiliation, department, email, delivery, deliveryTime, deliveryTimePatron)
    VALUES ('$isbn', '$title', '$author', '$firstName', '$lastName', '$affiliation', '$department', '$email', '$delivery', '$deliveryTime', '$deliveryTimePatron')";
    // use exec() because no results are returned
    $db->exec($sql);
    echo "New record created successfully";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

// if delivery speed is regular order book and send email
if ($delivery == "regular") {
	// set appropriate header and call email function
	$header = $smtp["headerRegular"];
	sendMail($header, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron);

 	// order with ProQuest API
    $url =  $config['pqApi']['order'] . $config['pqApi']['key'] . '&ISBN=' . $isbn;
    // $response = \Httpful\Request::get($url)->send();

// else delivery speed is expedite, set header and call email function
} else { 
	$header = $smtp["headerRush"];
	sendMail($header, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron);
}

?>