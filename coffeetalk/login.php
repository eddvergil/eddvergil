<?php

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php';

$error = "";

if (isset($_POST['btnLogin'])) {

    $username = trim($_POST['txtUsername']);
    $password = $_POST['txtPassword'];

    if ($username === "" || $password === "") {
        $error = "Please enter both username and password.";
    } else {
        $sql  = "SELECT * FROM employee WHERE FirstName = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($password === $row['Password']) {
                $_SESSION['logged_in']   = true;
                $_SESSION['username']    = $row['FirstName'];
                $_SESSION['employeeID']  = $row['EmployeeID'];
                $_SESSION['role']        = $row['Role'];

                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – CoffeeTalk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="center-page">

    <div class="login-card">

        <div class="card-logo">☕ CoffeeTalk</div>
        <p class="card-subtitle">Staff Login Portal</p>

        <?php if ($error !== ""): ?>
            <p class="error-msg">❌ <?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <div class="input-group">
                <span class="icon">👤</span>
                <input
                    type="text"
                    name="txtUsername"
                    placeholder="First Name (e.g. admin)"
                    value="<?php echo isset($_POST['txtUsername']) ? htmlspecialchars($_POST['txtUsername']) : ''; ?>"
                    required
                    autocomplete="username"
                >
            </div>

            <div class="input-group">
                <span class="icon">🔒</span>
                <input
                    type="password"
                    name="txtPassword"
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" name="btnLogin" class="login-btn">
                Log In
            </button>

        </form>

        <p class="card-footer-link">
            Use your <strong>First Name</strong> and <strong>Password</strong> from the employee table.
        </p>

    </div>

</body>
</html>