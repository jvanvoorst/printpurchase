<?php

include('./../resources/config.php');

$query = $db->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");
$tables = $query->fetchAll(PDO::FETCH_COLUMN);

if (empty($tables)) {
    echo "<p>There are no tables in database \"{$database}\".</p>";
} else {
    echo "<p>Database \"{$config['db']['dbName']}\" has the following tables:</p>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>{$table}</li>";
    }
    echo "</ul>";
}

?>