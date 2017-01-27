
<?php

include('./../resources/lib/httpful/httpful.phar');
include('./../resources/config.php');

$isbn = $_GET['isbn'];
$url =  $config['pqApi']['stockCheck'] . $config['pqApi']['key'] . '&ISBN=' . $isbn;

$response = \Httpful\Request::get($url)->send();

echo (json_decode($response))->DeliveryDays;

exit();

?>
