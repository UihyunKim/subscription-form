<?php include './snippet/header.php'; ?>

<?php if ($session_name !== 'Guest'): ?>
    <!-- Success Sign Up -->
    <h1>Thank <?php echo "$session_name"; ?> for sign up!</h1>
    <h2>Great photos are delivered to <?php echo $session_email; ?>

    <div>
        <h3><a href="./view-members.php">View our members</a></h3>
    </div>
<?php else: ?>
    <!-- Not signed up -->
    <!-- Link to log-in page -->
    <div>
        <p><a href="./log-in.php">Log in</a></p>
    </div>
<?php endif; ?>

<?php include './snippet/footer.php'; ?>
