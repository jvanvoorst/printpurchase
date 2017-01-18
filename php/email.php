<?php

include('./../resources/config.php');
require_once 'Mail.php';

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
      echo("<p>Message successfully sent!</p>");
    }
}

function createBody ($body, $id, $isbn, $title, $author, $firstName, $lastName, $affiliation, $department, $email, $delivery, $deliveryTime, $deliveryTimePatron) {
    $ref = "Order ref# " . $id . "\n\n";
    $book = "Book\nISBN: " . $isbn ."\nTitle: " . $title . "\nAuthor: " . $author . "\nDelivery Time: " . $deliveryTime . " days (from Coutts)" . "\n\n";
    $patron = "Patron\nName: " . $firstName . " " . $lastName . "\nAffiliation: " . $affiliation . "\nDepartment: " . $department . "\nEmail: " . $email;

    return $body . $ref . $book . $patron;
}

?>