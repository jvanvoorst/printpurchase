<?php

include('./../resources/lib/httpful/httpful.phar');
include('./../resources/config.php');
include('./../resources/db.php');
require_once 'Mail.php';

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

// email for patron
$bodyPatron = createBody($config["bodyPatron"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTimePatron);
$config["headerPatron"]["To"] = $email;
sendMail($email, $config["headerPatron"], $bodyPatron);

// if delivery speed is regular order book and send email to staff
if ($delivery === "regular") {
    // order with ProQuest API
    $url =  $config['pqApi']['order'] . $config['pqApi']['key'] . '&ISBN=' . $isbn;
    $response = \Httpful\Request::get($url)->send();
    $res = json_decode($response);
    // if order is successfull ie code = 100 send success message to staff
    if ($res->Code === 100) {
        $body = createBody($config["bodyRegular"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
        sendMail($addr["staff"], $config["headerRegular"], $body);
    // else send error message to staff
    } else {
        $body = createBody($config["bodyError"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime) . "\n\n" . $res->Message;
        sendMail($addr["staff"], $config["headerError"], $body);
    }
// else delivery speed is expedite just send email to staff
} else if ($delivery === "rush") { 
    // email for staff
    $body = createBody($config["bodyRush"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
    sendMail($addr["staff"], $config["headerRush"], $body);
}

function sendMail($recipients, $header, $body) {    
    global $config;
    // create mail object
    $smtpMail = Mail::factory("smtp", $config["smtp"]);
    // send email
    $mail = $smtpMail->send($recipients, $header, $body);
    // echo error or success message
    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
    } else {
      echo "\nMessage sent to " . $recipients;
    }
}

function createBody($msg, $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $dt) {
    $ref = "Order ref# $id \n\n";
    $book = "Book\nISBN: $isbn \nTitle: $title \nAuthor: $author \nDelivery Time: $dt \n\n";
    $patron = "Patron\nName: $firstName $lastName \nAffiliation: $affiliation \nDepartment: $department \nEmail: $email";

    return $msg . $ref . $book . $patron;
}

$db = null;
exit();

?>