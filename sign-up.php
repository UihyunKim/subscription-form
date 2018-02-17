<?php include './snippet/header.php' ?>

<?php
    $msg = '';
    $msgClass = '';

    // Check for submit
    if (isset($_POST['sign-up'])) {
        // Get Form Data
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $pw = strip_tags($_POST['pw']);
        $pw = filter_var($pw, FILTER_SANITIZE_STRIPPED);
        $pwHash = password_hash($pw, PASSWORD_DEFAULT);

        $time = $_POST['time'];
        $time = filter_var($time, FILTER_SANITIZE_STRING);

        // Check Required Fields
        if (!empty($name) && !empty($email) && !empty($pw)) {
            // Passed
            // Check email expression *@*.*
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // failed
                $msg = 'Please use valid email';
                $msgClass = 'alert-danger';
            } else {
                // Check duplicate email
                $sql = 'SELECT * FROM accounts WHERE email = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $duplicate = $stmt->fetchAll();

                if ($duplicate) {
                    $msg = 'Already regitered account';
                    $msgClass = 'alert-danger';

                } else {
                    // Complete Sign up
                    echo "Signed up!";
                    $signUp = true;

                    // Insert account
                    $sql = 'INSERT INTO accounts(name, email, pw, time) VALUES (:name, :email, :pw, :time)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['name'=>$name, 'email'=>$email, 'pw'=>$pwHash, 'time'=>$time]);

                    // Assign session_name & _email
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['time'] = $time;

                    // Redirect to welcome page
                    header('Location: ./sign-up-welcome.php');
                }
                
            }
        } else {
            // Failed
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
?>

<!-- Init -->
<?php if ($session_name === 'Guest'): ?>
    <h1>Sign up <br>Daily Photo</h1>
    <?php if ($msg != ''): ?>
        <div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
    <?php endif; ?>

    <!-- Sign Up Form-->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input  type="text" name="name" placeholder="name"
                value="<?php echo isset($name) ? $name : ''; ?>" >
        <br>
        <input  type="text" name="email" placeholder="email"
                value="<?php echo isset($email) ? $email : ''; ?>" >
        <br>
        <input  type="password" name="pw" placeholder="password">
        <br>
        <input  type="password" name="pw-confirm" placeholder="confirm password">
        <br>

        <p>Receive great photo by</p>
        <input type="radio" name="time" value="day" checked   >Day<br>
        <input type="radio" name="time" value="week"          >Week<br>
        <input type="radio" name="time" value="month"         >Month<br>
        <input type="radio" name="time" value="random"        >Random<br>

        <input type="submit" name="sign-up" value="Sign Up">
    </form>

    <!-- Log In Link-->
    <div><p>Already have an account? <a href="./log-in.php">Log in</a></p></div>

<?php endif; ?>


<?php include './snippet/footer.php'; ?>
