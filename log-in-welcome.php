<?php include './snippet/header.php'; ?>

<?php if ($session_name !== 'Guest'): ?>
    <h1>Hello, <?php echo $session_name ?></h1>

    <h2>account info</h2>

    <div>
        <h4>id</h3>
        <h3><?php echo $session_id ?></h4>
    </div>
    <div>
        <h4>name</h3>
        <h3><?php echo $session_name ?></h4>
    </div>
    <div>
        <h4>email</h3>
        <h3><?php echo $session_email ?></h4>
    </div>
    <div>
        <h4>time</h3>
        <h3><?php echo $session_time ?></h4>
    </div>

    <p><a href="./edit.php">edit</a></p>
    <p><a href="./log-out.php">Log out</a></p>
<?php else: ?>
    <?php header('Location: ./index.php'); ?>
<?php endif ?>

<?php include './snippet/footer.php';
