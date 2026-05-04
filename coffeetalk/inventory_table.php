<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "inventory_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS inventory (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    supplier_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Inventory table created successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
