<?php include './snippet/header.php'; ?>

<?php if ($session_name !== 'Guest'): ?>
    <h2>Hello, <?php echo ucfirst($session_name) ?></h2>

    <h3 class=mt-md-3>account info</h3>

    <div class="row mt-md-3">
        <h4 class="col-4">name</h4>
        <h5 class="col-8"><?php echo $session_name ?></h5>
    </div>
    <div class="row">
        <h4 class="col-4">email</h4>
        <h5 class="col-8"><?php echo $session_email ?></h5>
    </div>
    <div class="row">
        <h4 class="col-4">every</h4>
        <h5 class="col-8"><?php echo $session_time ?></h5>
    </div>

    <div class="row mt-auto">
        <p class="col text-center"><a href="./edit.php" class="">edit</a></p>
        <p class="col text-center"><a href="./view-members.php" class="">members</a></p>
        <p class="col text-center"><a href="./log-out.php" class="text-danger">Log out</a></p>
    </div>
<?php else: ?>
    <?php header('Location: ./index.php'); ?>
<?php endif ?>

<?php include './snippet/footer.php';
