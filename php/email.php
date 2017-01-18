<?php

include('./../resources/config.php');
require_once 'Mail.php';

function sendMail($id, $header, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron) {
    global $smtp;
    // create message body
    $body = createBody($id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron);
    // create mail object
    $mail_object =& Mail::factory("smtp", $smtp["smtp"]);
    // send email
    $mail_object->send($smtp["recipients"], $header, $body);
    // echo error or success message
    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
    } else {
      echo("<p>Message successfully sent!</p>");
    }
}

function createBody ($id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron) {
    global $smtp;
    $ref = "Order ref# " . $id . "\n";
    $book = "Book\nISBN: " . $isbn ."\nTitle: " . $title . "\nAuthor: " . $author . "\nDelivery Time: " . $deliveryTime . " days (from Coutts)" . "\n\n";
    $patron = "Patron\nName: " . $firstName . " " . $lastName . "\nAffiliation: " . $affiliation . "\nDepartment: " . $department . "\nEmail: " . $email;

    if ($delivery == "regular") {
        return $smtp["bodyRegular"] . $ref . $book . $patron;
    } else {
        return $smtp["bodyRush"] . $ref . $book . $patron;
    }
}

?>