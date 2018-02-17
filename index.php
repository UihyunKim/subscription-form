<?php
    session_start();

    $session_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
    $session_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Unsubscribed';
    $session_time = isset($_SESSION['time']) ? $_SESSION['time'] : 'Unsubscribed';
    

    // If not sign-in
    if ($session_name === 'Guest') {
        header('Location: ./sign-up.php');
    } else {
        header('Location: ./log-in.php');
    }
?>