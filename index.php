<?php include './snippet/header.php' ?>

    <?php
        $msg = '';
        $msgClass = '';

        $signUp = false;
        $signIn = false;
        
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
                    }
                    
                }
            } else {
                // Failed
                $msg = 'Please fill in all fields';
                $msgClass = 'alert-danger';
            }
        } elseif (isset($_POST['sign-in'])) {
            // echo "Sign in clicked";
            $signIn = true;
        }

    ?>

    <!-- Init -->
    <?php if ($signUp == false && $signIn == false): ?>
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

        <!-- Sign In Link-->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="sign-in">Already have an account?</label>
            <input type="submit" name="sign-in" value="Sign In">
        </form>

    <!-- Success Sign Up -->
    <?php elseif ($signUp == true && $signIn == false): ?>
        <!-- Insert account -->
        <?php
            $sql = 'INSERT INTO accounts(name, email, pw, time) VALUES (:name, :email, :pw, :time)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name'=>$name, 'email'=>$email, 'pw'=>$pwHash, 'time'=>$time]);
            echo 'Account added';
        ?>
    
        <h1>Thank <?php echo "$name"; ?> for sign up!</h1>
        <h2>Great photos are delivered to <?php echo $email; ?>, every <?php echo $time; ?></h2>

        <div>
            <h3>View our members</h3>
            <?php
                $stmt = $pdo->query('SELECT * FROM accounts');
            ?>
            <?php while ($row = $stmt->fetch()): ?>
                <div> <?php echo $row->name; ?> </div>
            <?php endwhile ?>

        </div>
    
    <!-- Sign In Form -->
    <?php elseif ($signUp == false && $signIn == true): ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input  type="text" name="email" placeholder="email"
                    value="<?php echo isset($email) ? $email : ''; ?>" >
            <br>
            <input  type="password" name="pw" placeholder="password">
            <br>

            <input type="submit" name="sign-in" value="Sign In">
        </form>
    <?php endif; ?>

<?php include './snippet/footer.php';
