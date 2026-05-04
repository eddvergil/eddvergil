<?php

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

$products = [];
$result = mysqli_query($con, "SELECT * FROM product ORDER BY Category, ProductName");
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List – CoffeeTalk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-wrapper {
            padding: 40px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--brown-dark);
        }

        .page-header a {
            background-color: var(--accent);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .page-header a:hover {
            background-color: var(--brown-warm);
        }

        .table-wrapper {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 8px 30px var(--shadow);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--brown-dark);
            color: var(--cream);
        }

        thead th {
            padding: 14px 18px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        tbody tr {
            border-bottom: 1px solid #f0e8e0;
            transition: background-color 0.15s;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover { background-color: var(--cream-light); }

        tbody td {
            padding: 13px 18px;
            font-size: 14px;
            color: var(--text-dark);
        }

        .badge {
            background-color: var(--cream);
            color: var(--brown-mid);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .cat-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .cat-Hot-Coffee   { background: #fdf3e7; color: #c8813a; border: 1px solid #f0c88a; }
        .cat-Cold-Coffee  { background: #eaf4fb; color: #2980b9; border: 1px solid #aed6f1; }
        .cat-Non-Coffee   { background: #eafaf1; color: #27ae60; border: 1px solid #a9dfbf; }
        .cat-Pastry       { background: #f4ecf7; color: #8e44ad; border: 1px solid #d2b4de; }

        .btn-edit {
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 7px;
            background-color: #d4a843;
            color: var(--white);
            transition: background-color 0.2s;
        }

        .btn-edit:hover { background-color: #b8922e; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state span {
            font-size: 48px;
            display: block;
            margin-bottom: 12px;
        }

        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success { background-color: #eafaf1; color: #27ae60; border: 1px solid #a9dfbf; }
        .alert-error   { background-color: #fdf0ed; color: #c0392b; border: 1px solid #f5b7b1; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="nav-logo">
            <img src="images/logo.png" alt="CoffeeTalk Logo">
            <span>CoffeeTalk</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="logout.php" class="nav-login">Logout</a></li>
        </ul>
    </nav>

    <div class="page-wrapper">

        <?php if (isset($_GET['success'])): ?>
            <p class="alert alert-success">✅ <?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <p class="alert alert-error">❌ <?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <div class="page-header">
            <h2>☕ Product Records</h2>
            <a href="add_product.php">+ Add New Product</a>
        </div>

        <div class="table-wrapper">
            <?php if (count($products) === 0): ?>
                <div class="empty-state">
                    <span>🛒</span>
                    <p>No products found. Add your first item!</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price (₱)</th>
                            <th>Stock</th>
                            <th>Roast Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $i => $p): ?>
                            <?php
                                $catClass = 'cat-' . str_replace(' ', '-', $p['Category'] ?? '');
                            ?>
                            <tr>
                                <td><span class="badge"><?php echo $i + 1; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($p['ProductName']); ?></strong></td>
                                <td>
                                    <span class="cat-badge <?php echo $catClass; ?>">
                                        <?php echo htmlspecialchars($p['Category'] ?? '—'); ?>
                                    </span>
                                </td>
                                <td>₱<?php echo number_format($p['Price'], 2); ?></td>
                                <td><?php echo $p['StockQuantity']; ?></td>
                                <td><?php echo htmlspecialchars($p['RoastLevel'] ?? '—'); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $p['ProductID']; ?>" class="btn-edit">✏️ Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>