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
    <h2>Sign up</h2>
    <?php if ($msg != ''): ?>
        <div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
    <?php endif; ?>

    <!-- Sign Up Form-->
    <form   action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
            method="post" 
            class="needs-validation sign-up-form mt-sm-3" 
            novalidate>

        <div class="form-group name">
            <input  type="text" 
                    name="name" 
                    placeholder="name" 
                    class="form-control"
                    value="<?php echo isset($name) ? $name : ''; ?>" 
                    required>
            <div    class="invalid-feedback">Please fill name</div>
        </div>

        <div class="form-group email">
            <input  type="email" 
                    name="email" 
                    placeholder="email" 
                    class="form-control"
                    value="<?php echo isset($email) ? $email : ''; ?>" 
                    required>
            <div    class="invalid-feedback">Please fill valid email</div>
        </div>
        <div class="form-group password">
            <input  type="password" 
                    name="pw" 
                    placeholder="password" 
                    class="form-control" 
                    required 
                    minlength=4 >
            <div    class="invalid-feedback">Required 4 characters minimum</div>
        </div>
        <div class="form-group password-confirm">
            <input  type="password" 
                    name="pw-confirm" 
                    placeholder="confirm password" 
                    class="form-control pw-confirm-input" >
            <div    class="invalid-feedback">Please write same password as above</div>
        </div>
        <div class="form-group row">
            <label  for="selectTime" 
                    class="col-sm-8 col-form-label">Receive photos every</label>
            <div    class="col-sm-4">
                <select name="time" 
                        id="selectTime" 
                        class="form-control" >
                    <option value="day" selected>Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="random">Random</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <input  type="submit" 
                    name="sign-up" 
                    value="Sign up" 
                    class="btn btn-primary col">
        </div>
    </form>

    <!-- Log In Link-->
    <div><p>Already have an account? <a href="./log-in.php">Log in</a></p></div>

<?php endif; ?>


<?php include './snippet/footer.php'; ?>