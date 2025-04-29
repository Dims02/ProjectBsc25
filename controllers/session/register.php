<?php
$heading   = "";
$tabname   = "Register";
$pos       = "max-w-7xl";

// 1) Pull raw inputs and trim
$email     = trim($_POST['email']    ?? '');
$password  = trim($_POST['password'] ?? '');
$honeypot  = trim($_POST['website']  ?? '');

// 2) If already logged in, bounce
if (isLoggedIn()) {
    $_SESSION['error_message'] = "You're already logged in.";
    header("Location: /dashboard");
    exit;
}

// 3) See if we have a temp-user JWT
$user     = getUserFromJWT();
$greeting = ($user && $user->role === 'temp')
    ? "Your temporary account #{$user->name} will be finalized."
    : "Welcome! Please register.";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $email !== '' && $password !== '') {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // 5a) Upgrade a temp-user
    if ($user && $user->role === 'temp') {
        $user->email    = $email;
        $user->password = $password;  // we’ll hash in the helper
        finalizeTemp($user);
        logout();  // clear the temp JWT from the cookie
        loginUser($email, $password);  // re-login so the JWT in their cookie now has role="user" & correct sub/email

        $_SESSION['success_message'] = "Your account has been finalized.";
        header("Location: /dashboard");
        exit;
    }

    // 5b) New registration path
    $result = registerUser($email, $password);
    if ($result === true) {
        header("Location: /dashboard");
        exit;
    } else {
        $error = $result;  // e.g. “Email already taken”
    }

}

// 6) optional inline background override for your view
$overrideStyle = "
    background-color:    #0c2340;
    background-image:     url('media/watermark.png');
    background-repeat:    no-repeat;
    background-position:  bottom right;
    background-size:      contain;
";

require "./views/session/registerView.php";
?>
