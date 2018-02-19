<?php include './snippet/header.php'; ?>

<?php
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
                // Check email and password
                $sql = 'SELECT * FROM accounts WHERE email = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                // var_dump($user);
                // echo "$user->name<br>";
                // echo "$user->email<br>";
                // echo "$user->time<br>";
                // echo "$user->pw<br>";

                if (password_verify($pw, $user->pw)) {
                    // login success
                    $_SESSION['name'] = $user->name;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['time'] = $user->time;

                    header('Location: ./log-in-welcome.php');
                } else {
                    echo "Login failed";
                }
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

    <h1>Edit account info</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

        <input  type="text" name="name" placeholder="name"
                value="<?php echo isset($session_name) ? $session_name : ''; ?>" >
        <br>
    
        <p>Receive great photo by</p>
        <?php echo "$session_time<br>" ?>
<!--     
        <input type="radio" name="time" value="day"
            <?php echo $session_time === 'day' ? 'checked' : 'no'; ?>
            >Day<br>
        <input type="radio" name="time" value="week"
            <?php echo $session_time === 'week' ? 'checked' : ''; ?>
            >Week<br>
        <input type="radio" name="time" value="month"
            <?php echo $session_time === 'month' ? 'checked' : ''; ?>
            >Month<br>
        <input type="radio" name="time" value="random"
            <?php echo $session_time === 'random' ? 'checked' : ''; ?>
            >Random<br> -->

        <select name="time" class="form-control form-control-sm">
            <option value="day" <?php echo $session_time === 'day' ? 'selected' : ''; ?>>Day</option>
            <option value="week" <?php echo $session_time === 'week' ? 'selected' : ''; ?>>Week</option>
            <option value="month" <?php echo $session_time === 'month' ? 'selected' : ''; ?>>Month</option>
            <option value="random"<?php echo $session_time === 'random' ? 'selected' : ''; ?>>Random</option>
        </select>
        
        <input type="submit" name="edit" value="Edit">
        
    </form>

    <h1>Delete account</h1>
    <!-- <p>Do you want to delete this account?(Can't going back)</p> -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="submit" name="delete" value="Delete">
    </form>

    <p><a href="./index.php">Home</a></p>
    <p><a href="./log-out.php">Log out</a></p>

<?php else: ?>

    <?php header('Location: ./index.php'); ?>
    
<?php endif ?>

<?php include './snippet/footer.php';
