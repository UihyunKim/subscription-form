<?php include './snippet/header.php'; ?>

<?php
    $stmt = $pdo->query('SELECT * FROM accounts');
?>
<?php while ($row = $stmt->fetch()): ?>
    <div> <?php echo $row->name; ?> </div>
<?php endwhile ?>

<?php include './snippet/footer.php'; ?>
