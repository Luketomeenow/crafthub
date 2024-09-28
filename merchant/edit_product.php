
<?php
include 'dbcon.php';

if (isset($_POST['delete'])) {
    // Handle the delete action
    $product_id = $_POST['product_id'];

    // Delete the associated colors and sizes first
    $deleteColor = "DELETE FROM product_color WHERE product_id = '$product_id'";
    $deleteSize = "DELETE FROM product_sizes WHERE product_id = '$product_id'";
    $resultColor = mysqli_query($connection, $deleteColor);
    $resultSize = mysqli_query($connection, $deleteSize);

    // After deleting associated colors and sizes, delete the product
    $deleteProduct = "DELETE FROM merchant_products WHERE product_id = '$product_id'";
    $resultProduct = mysqli_query($connection, $deleteProduct);

    if (!$resultProduct || !$resultColor || !$resultSize) {
        die("Deletion Failed: " . mysqli_error($connection));
    } else {
        // Redirect to the product list page after deletion
        echo "<script>alert('Product Deleted Successfully!');
            window.location.href = 'mprofile.php';
            </script>";
        exit();
    }
}


    if (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
        $product_desc = mysqli_real_escape_string($connection, $_POST['product_desc']);
        $stock = intval($_POST['stock']);
        $category = mysqli_real_escape_string($connection, $_POST['product_category']);
        $material = mysqli_real_escape_string($connection, $_POST['material']);

        // Check if a new product image is uploaded
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

            // Ensure the uploads directory exists
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    die("Failed to create upload directory.");
                }
            }

            // Check if the file type is allowed
            if (in_array($imageFileType, $allowed_types)) {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    // Update product_image field in the database
                    $updateImage = "UPDATE merchant_products SET product_img = '$target_file' WHERE product_id = '$product_id'";
                    if (!mysqli_query($connection, $updateImage)) {
                        error_log("Image Update Failed: " . mysqli_error($connection));
                        echo "<script>alert('Image Update Failed!');
                            window.location.href = 'mprofile.php';
                            </script>";
                        die("Image Update Failed: " . mysqli_error($connection));
                    }
                } else {
                    error_log("Image Upload Failed");
                    echo "<script>alert('Image Upload Failed!');
                        window.location.href = 'mprofile.php';
                        </script>";
                    die("Image Upload Failed");
                }
            } else {
                error_log("Invalid file type: $imageFileType");
                echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
                    window.location.href = 'mprofile.php';
                    </script>";
                die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
            }
        }

        // Update merchant_products table
        $updateProduct = "UPDATE merchant_products 
                        SET product_name = '$product_name', product_desc = '$product_desc',  stock = $stock, category = '$category', material = '$material'
                        WHERE product_id = '$product_id'";

        if (!mysqli_query($connection, $updateProduct)) {
            error_log("Product Update Failed: " . mysqli_error($connection));
            die("Product Update Failed: " . mysqli_error($connection));
        }

        // Update colors
        $colors = $_POST['color'];
        $colorIds = isset($_POST['color_id']) ? $_POST['color_id'] : [];

        foreach ($colors as $index => $color) {
            $color = mysqli_real_escape_string($connection, $color);
            if (isset($colorIds[$index])) {
                $colorId = intval($colorIds[$index]);
                $updateColor = "UPDATE product_color SET color = '$color' WHERE color_id = $colorId";
                mysqli_query($connection, $updateColor);
            } else {
                $insertColor = "INSERT INTO product_color (product_id, color) VALUES ('$product_id', '$color')";
                mysqli_query($connection, $insertColor);
            }
        }

        // Update sizes
        $sizes = $_POST['size'];
        $prices = $_POST['price'];
        $sizeIds = isset($_POST['size_id']) ? $_POST['size_id'] : [];

        foreach ($sizes as $index => $size) {
            $size = mysqli_real_escape_string($connection, $size);
            $price = floatval($prices[$index]);
            if (isset($sizeIds[$index])) {
                $sizeId = intval($sizeIds[$index]);
                $updateSize = "UPDATE product_sizes SET sizes = '$size', price = $price WHERE size_id = $sizeId";
                mysqli_query($connection, $updateSize);
            } else {
                $insertSize = "INSERT INTO product_sizes (product_id, sizes, price) VALUES ('$product_id', '$size', $price)";
                mysqli_query($connection, $insertSize);
            }
        }

        echo "<script>alert('Product Update Successfully!');
            window.location.href = 'meditproduct.php?product_id=$product_id';
            </script>";
        exit();
    }
?>