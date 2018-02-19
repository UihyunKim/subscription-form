<?php include './snippet/header.php'; ?>

<h2 class="mb-3">Our members</h2>

<?php
    $stmt = $pdo->query('SELECT * FROM accounts');
?>

<?php while ($row = $stmt->fetch()): ?>
    <div class="row">
        <div class="col-4"> <?php echo ucfirst($row->name); ?> </div>
        <div class="col-8"> <?php echo $row->email; ?> </div>
    </div>
<?php endwhile ?>

<!-- Links -->
<div class="link-container mt-auto d-flex justify-content-around">
    <p><a href="./index.php">Home</a></p>
    <p><a href="./log-out.php" class="text-danger">Log out</a></p>
</div>

<?php include './snippet/footer.php'; ?>
