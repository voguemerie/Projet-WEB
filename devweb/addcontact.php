<?php 
    
    // Connect to the database
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'devweb';
    $conn = mysqli_connect($host, $user, $pass, $dbname);

    if (!$conn) {
    die('Erreur de connection à la base de donnée');
    }

    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);

    // Insert the data into the database
    $sql = "INSERT INTO contact (email, subject, text) VALUES ('$email', '$subject', '$text')"; 
    $result = mysqli_query($conn, $sql);

    if (!$result) {
    die('Error inserting data into database');
    }

    // Close the connection
    mysqli_close($conn);


?>


