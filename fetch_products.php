<?php
// Include the database connection
include 'dbcon.php';

// Initialize the base query
$query = "SELECT * FROM merchant_products WHERE 1=1";

// Check for category filter in POST request
if (isset($_POST['category']) && !empty($_POST['category'])) {
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $query .= " AND category = '$category'";
}

// Check for search query in GET request
if (isset($_GET['searchbar']) && !empty($_GET['searchbar'])) {
    $searchQuery = mysqli_real_escape_string($connection, $_GET['searchbar']);
    $query .= " AND (product_name LIKE '%$searchQuery%' OR product_desc LIKE '%$searchQuery%')";
}

// Execute the query
$result = mysqli_query($connection, $query);

// Check if the query failed
if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}

// Fetch and display the products
while ($row = mysqli_fetch_assoc($result)) {
    $imagePath = 'uploads/' . basename($row['product_img']);

    echo '<div class="product-card" >';
    echo '    <div class="product-image">';
    echo '        <img src="' . htmlspecialchars($imagePath) . '" alt="Product Image">';
    echo '    </div>';
    echo '    <div class="product-details">';
    echo '        <h5 class="product-name">' . htmlspecialchars($row['product_name']) . '</h5>';
    echo '        <a href="buynow.php?product_id=' . $row['product_id'] . '">';
    echo '            <button class="buybtn" name="buy-now">View Product</button>';
    echo '        </a>';
    echo '    </div>';
    echo '</div>';
}

// Close the connection
mysqli_close($connection);
?>
