<?php
session_start();

session_destroy();

?>

<?php include './snippet/header.php'; ?>

<h2>Logged out</h2>
<p class="mt-auto">Go back to <a href="./index.php">Home</a></p>

<?php include './snippet/footer.php'; ?>