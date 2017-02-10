<?php
include('./../resources/config.php');

$db = new PDO(
	"mysql:host={$config["db"]["host"]};dbname={$config["db"]["dbName"]}",
	$config["db"]["userName"],
	$config["db"]["password"]
);

?>