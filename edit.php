<?php include './snippet/header.php'; ?>

<?php
    $msg = '';
    $msgClass = '';

    // update account
    if (isset($_POST['edit'])) {

        $msg = '';
        $msgClass = '';

        // Get Form Data
        $newName = $_POST['name'];
        $newName = filter_var($newName, FILTER_SANITIZE_STRING);

        $newTime = $_POST['time'];
        $newTime = filter_var($newTime, FILTER_SANITIZE_STRING);

        // Check Required Fields
        if (!empty($newName)) {
            // Passed

            // Update Name or Time
            if ($newName !== $session_name or $newTime !== $session_time) {

                // Update Name
                if ($newName !== $session_name) {
                    // update db
                    $sql = 'UPDATE accounts SET name = :name WHERE id = :id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['name' => $newName, 'id' => $session_id]);

                    // update session var
                    $_SESSION['name'] = $newName;
                }
                
                // Update Time
                if ($newTime !== $session_time) {
                    // update db
                    $sql = 'UPDATE accounts SET time = :time WHERE id = :id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['time' => $newTime, 'id' => $session_id]);
    
                    // update session var
                    $_SESSION['time'] = $newTime;
                }

                // Redirect login welcome page
                header('Location: ./log-in-welcome.php');           
            }
            
            else {
                // Nothing changed
                $msg = 'Nothing changed';
                $msgClass = 'alert-danger';
            }
        }
        
        else {
            // Failed
            $msg = 'Please fill in name';
            $msgClass = 'alert-danger';
        }
    }

?>

<?php
    // delete account
    if (isset($_POST['delete'])) {
        $sql = 'DELETE FROM accounts WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $session_id]);

        session_destroy();

        header('Location: ./index.php');
    }
?>


<?php if ($session_name !== 'Guest'): ?>
    <h2>Edit account info</h2>

    <?php if ($msg != ''): ?>
        <div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="edit-form-container">
        <!-- Edit form -->
        <form   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
                method="post"
                class="needs-validation sign-up-form mt-sm-3" 
                novalidate>

            <div class="form-group row">
                <label  for="name" 
                        class="col-4 col-form-label">name</label>
                <div class="col-8">
                    <input  type="text"
                            id="name" 
                            name="name" 
                            placeholder="name"
                            class="form-control"
                            value="<?php echo isset($session_name) ? $session_name : ''; ?>" 
                            required>
                </div>
                <div    class="invalid-feedback col-12">Please fill name</div>
            </div>
        
            <div class="form-group row">
                <label  for="selectTime" 
                        class="col-7 col-form-label">Receive photos every</label>
                <div    class="col-5">
                    <select name="time" 
                            id="selectTime" 
                            class="form-control" >
                        <option value="day" <?php echo $session_time === 'day' ? 'selected' : ''; ?>>Day</option>
                        <option value="week" <?php echo $session_time === 'week' ? 'selected' : ''; ?>>Week</option>
                        <option value="month" <?php echo $session_time === 'month' ? 'selected' : ''; ?>>Month</option>
                        <option value="random" <?php echo $session_time === 'random' ? 'selected' : ''; ?>>Random</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <input  type="submit" 
                        name="edit" 
                        value="Edit" 
                        class="btn btn-primary col">
            </div>
        </form>
    </div>

    <!-- Delete form -->
    <div class="delete-form-container mt-auto">
        <h2>Delete account</h2>
        <!-- <p>Do you want to delete this account?(Can't going back)</p> -->
        <form   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                method="post">
            <div class="form-group">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger col">
            </div>
        </form>
    </div>

    <!-- Links -->
    <div class="link-container mt-auto d-flex justify-content-around">
        <p><a href="./index.php">Home</a></p>
        <p><a href="./log-out.php" class="text-danger">Log out</a></p>
    </div>
<?php else: ?>

    <?php header('Location: ./index.php'); ?>
    
<?php endif ?>

<?php include './snippet/footer.php';
