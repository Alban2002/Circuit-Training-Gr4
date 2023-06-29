<?php
    session_start();

    // Convert the session data to JSON
    $response = json_encode($_SESSION);

    // Send the response
    echo $response;
?>