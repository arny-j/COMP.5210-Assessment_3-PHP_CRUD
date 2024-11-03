<?php

    include "credentials.php";
    
    // Make a Database Connection
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    // Select All Records From Tabel
    $record = $connection->prepare("SELECT * FROM scp");
    $record->execute();
    $result = $record->get_result();

?>