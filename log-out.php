<?php
session_start();

session_destroy();

?>

<?php include './snippet/header.php'; ?>

<h1>Logged out</h1>
<p>Go back to <a href="./index.php">Home</a></p>

<?php include './snippet/footer.php'; ?>