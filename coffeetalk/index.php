<?php

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

$result   = mysqli_query($con, "SELECT * FROM product ORDER BY Category, ProductName");
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CoffeeTalk Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">

        <a href="index.php" class="nav-logo">

            <img src="images/logo.png" alt="CoffeeTalk Logo">
            <span>CoffeeTalk</span>
        </a>

        <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="add_customer.php">Add Customer</a></li>
    <li><a href="add_order.php">Add Order</a></li>
    <li><a href="add_reservation.php">Add Reservation</a></li>
    <li><a href="add_product.php">Add Product</a></li>
    <li><a href="add_employee.php">Add Employee</a></li>
    <li><a href="logout.php" class="nav-login">Logout</a></li>
</ul>

    </nav>

    <section class="hero">

        <div class="hero-gif-wrapper">
            <img src="images/hero.gif" alt="Coffee Animation">
        </div>

        <h1>We Serve the Richest<br>Coffee in the City!</h1>
        <p>Experience the warmth of every cup crafted with love, served with a smile.</p>

        <div style="display:flex; gap:14px; flex-wrap:wrap; justify-content:center;">
            <a href="add_order.php" class="btn">Order Now</a>
            <a href="add_customer.php" class="btn btn-accent">Register Customer</a>
        </div>

    </section>



</body>
</html>
