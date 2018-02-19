<?php include './snippet/header.php'; ?>

<?php
    $msg = '';
    $msgClass = '';

    // Check for submit
    if (isset($_POST['log-in'])) {
        // Get Form Data
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $pw = strip_tags($_POST['pw']);
        $pw = filter_var($pw, FILTER_SANITIZE_STRIPPED);
        $pwHash = password_hash($pw, PASSWORD_DEFAULT);

        // Check Required Fields
        if (!empty($email) && !empty($pw)) {
            // Passed
            // Check email expression *@*.*
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // failed
                $msg = 'Please use valid email';
                $msgClass = 'alert-danger';
            } else {
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

                if ($user and password_verify($pw, $user->pw)) {
                    // login success
                    $_SESSION['id'] = $user->id;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['time'] = $user->time;

                    header('Location: ./log-in-welcome.php');
                } else {
                    echo "Login failed";
                }
            }
        } else {
            // Failed
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
?>

<?php if ($session_name === 'Guest'): ?>
    <!-- Render Login page -->
    <h2>Log in </h2>

    <?php if ($msg != ''): ?>
        <div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form 
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        method="post"
        class="needs-validation log-in-form mt-sm-3"
        novalidate>

        <div class="form-group email">
            <input  type="text" 
                    name="email" 
                    placeholder="email"
                    class="form-control" 
                    value="<?php echo isset($email) ? $email : ''; ?>" 
                    required>
            <div    class="invalid-feedback">Please use valid email</div>
        </div>
        <div class="form-group password">
            <input  type="password" 
                    name="pw" 
                    class="form-control" 
                    placeholder="password"
                    required
                    minlength=4 >
            <div    class="invalid-feedback">Required 4 characters minimum</div>
        </div>

        <div class="form-group">
            <input  type="submit" 
                    name="log-in" 
                    value="Log In" 
                    class="btn btn-primary col">
        </div>
    </form>

    <div><p>Back to <a href="./index.php">Sign up</a></p></div>
<? else: ?>
    <!-- When logged in -->
    <?php header('Location: ./log-in-welcome.php'); ?>

<? endif; ?>

<?php include './snippet/footer.php'; ?>
