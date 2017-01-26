<?php

include('./../resources/lib/httpful/httpful.phar');
include('./../resources/config.php');
include('./../resources/db.php');
require_once 'Mail.php';
// include('email.php');

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
$bodyPatron = createBody($smtp["bodyPatron"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTimePatron);
sendMail($email, $smtp["headerPatron"], $bodyPatron);

// if delivery speed is regular order book and send email to staff
if ($delivery == "regular") {
    // email for staff
    $body = createBody($smtp["bodyRegular"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
    sendMail($smtp["recipients"], $smtp["headerRegular"], $body);

    // order with ProQuest API
    // $url =  $config['pqApi']['order'] . $config['pqApi']['key'] . '&ISBN=' . $isbn;
    // $response = \Httpful\Request::get($url)->send();

// else delivery speed is expedite just send email to staff
} else { 
    // email for staff
    $body = createBody($smtp["bodyRush"], $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime);
    sendMail($smtp["recipients"], $smtp["headerRush"], $body);
}

function sendMail($recipients, $header, $body) {
    global $smtp;
    // create mail object
    $mail_object =& Mail::factory("smtp", $smtp["smtp"]);
    // send email
    $mail_object->send($recipients, $header, $body);
    // echo error or success message
    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
    } else {
      echo "\nMessage sent to " . $recipients;
    }
}

function createBody($body, $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $dt) {
    $ref = "Order ref# " . $id . "\n\n";
    $book = "Book\nISBN: " . $isbn ."\nTitle: " . $title . "\nAuthor: " . $author . "\nDelivery Time: " . $dt . "\n\n";
    $patron = "Patron\nName: " . $firstName . " " . $lastName . "\nAffiliation: " . $affiliation . "\nDepartment: " . $department . "\nEmail: " . $email;

    return $body . $ref . $book . $patron;
}

$db = null;
exit();

?>