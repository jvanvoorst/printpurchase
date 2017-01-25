<?php

include('./../resources/lib/httpful/httpful.phar');
include('./../resources/config.php');
include('./../resources/db.php');
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
    $id = $db->lastInsertId();
    echo "New record created successfully";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

// if delivery speed is regular order book and send email to staff
if ($delivery == "regular") {
    // email for staff
    $body = createBody($smtp["bodyRegular"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
    sendMail($smtp["recipients"], $smtp["headerRegular"], $body);

    // order with ProQuest API
    $url =  $config['pqApi']['order'] . $config['pqApi']['key'] . '&ISBN=' . $isbn;
    $response = \Httpful\Request::get($url)->send();

// else delivery speed is expedite just send email to staff
} else { 
    // email for staff
    $body = createBody($smtp["bodyRush"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
    sendMail($smtp["recipients"], $smtp["headerRush"], $body);
}
// email for patron
$bodyPatron = createBody($smtp["bodyPatron"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTimePatron);
sendMail($email, $smtp["headerPatron"], $bodyPatron);

$db = null;
exit();

?>