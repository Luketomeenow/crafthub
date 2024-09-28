<?php 
    include 'dbcon.php';

    if (isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];

        $selectproduct = "SELECT * FROM merchant_products WHERE product_id = '$product_id'";
        $result = mysqli_query($connection, $selectproduct);

        if(!$result){
            die("Query Failed: " . mysqli_error($connection));
        } else {
            $row = mysqli_fetch_assoc($result);
        }

        $selectcolor = "SELECT * FROM product_color WHERE product_id = '$product_id'";
        $color = $connection->query($selectcolor);

        $selectsize = "SELECT * FROM product_sizes WHERE product_id = '$product_id'";
        $sizes = $connection->query($selectsize);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/maddproduct.css">
    <link rel="stylesheet" href="css/mnavigation.css">
    <link rel="stylesheet" href="css/mfooter.css">
</head>
<body>
        <!--=============== NAVIGATION ==============-->
        <div class="flexMain sticky-top py-4" id="mainNavigation">
            <div class="flex3">
                <ul class="list-unstyled d-md-block">
                    <li class="mx-4 d-inline-block"><a href="mdashboard.php" class="logo"><img src="images/navlogo.png"></a></li>
                </ul>
            </div>
            <div class="flex5">
                <ul class="list-unstyled navigation-menu">
                    <li class="mx-4 d-inline-block"><a href="mdashboard.php">Dashboard</a></li>
                    <li class="mx-4 d-inline-block"><a href="mprofile.php">Products</a></li>
                    <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
                    <li class="mx-4 d-inline-block"><a href="maccount.php">Settings</a></li>
                    <li class="mx-4 d-inline-block"><a href="../login.php">Logout</a></li>
                </ul>
            </div>
            <nav class="responsive">
                <input type="checkbox" id="sidebar-active">
                <label for="sidebar-active" class="open-sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="42" viewBox="0 -960 960 960" width="32">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                    </svg>
                </label>
                <label id="overlay" for="sidebar-active"></label>
                <div class="links-container">
                    <label for="sidebar-active" class="close-sidebar-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32">
                            <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                        </svg>
                    </label>
                    <a href="mprofile.php">Profile</a>
                    <a href="">Messages</a>
                    <a href="morders.php">Orders</a>
                    <a href="maccount.php">Settings</a>
                    <a href="index.php">Log out</a>
                </div>
            </nav>
        </div>
<!--=============== END NAVIGATION ==============-->

    <div class="container">
        <form id="product-form" action="edit_product.php" method="POST" enctype="multipart/form-data">
            <!-- Basic Product Information -->
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="text" name="product_name" class="form-input" placeholder="Product Name" value = "<?php echo htmlspecialchars($row['product_name']); ?>">
            <input type="text" name="product_desc" class="form-input" placeholder="Product Description" value = "<?php echo htmlspecialchars($row['product_desc']); ?>">
            <input type="text" name="stock" class="form-input" placeholder="Stock" value = "<?php echo htmlspecialchars($row['stock']); ?>">
            <label for="product_category" class="form-input">Product Category</label>
            <select name="product_category" id="product_category">
                <option value="categ1" <?php if ($row['category'] == 'Rugs') echo 'selected'; ?>>Rugs</option>
                <option value="categ2" <?php if ($row['category'] == 'Tables') echo 'selected'; ?>>Tables</option>
                <option value="categ3" <?php if ($row['category'] == 'Dining') echo 'selected'; ?>>Dining</option>
                <option value="categ4" <?php if ($row['category'] == 'Lighting') echo 'selected'; ?>>Lighting</option>
                <option value="categ5" <?php if ($row['category'] == 'Storage') echo 'selected'; ?>>Storage</option>
                <option value="categ6" <?php if ($row['category'] == 'Furniture') echo 'selected'; ?>>Furniture</option>
                <option value="categ7" <?php if ($row['category'] == 'Kitchen') echo 'selected'; ?>>Kitchen</option>
                <option value="categ8" <?php if ($row['category'] == 'Decor') echo 'selected'; ?>>Decor</option>
                <option value="categ8" <?php if ($row['category'] == 'Coasters') echo 'selected'; ?>>Coasters</option>
                <option value="categ8" <?php if ($row['category'] == 'Trays') echo 'selected'; ?>>Trays</option>
                <option value="categ8" <?php if ($row['category'] == 'Accessories') echo 'selected'; ?>>Accessories</option>

            </select>
            <hr class="solid">

            <!-- Color Fields -->
            <div id="colors">
                <?php 
                    while($colors = mysqli_fetch_assoc($color)){
                ?>
                <div class="color form-input" data-color-id="<?php echo $colors['color_id']; ?>">
                    <input type="hidden" name="color_id[]" value="<?php echo $colors['color_id']; ?>">
                    <input type="text" name="color[]" placeholder="Color" value="<?php echo htmlspecialchars($colors['color']); ?>">
                    <button type="button" class="btn btn-primary remove-color">Remove</button>
                </div>
                <?php 
                    }
                ?>
                <!-- Default empty color input -->
                <div class="color form-input">
                    <input type="text" name="color[]" placeholder="Color">
                    <button type="button" class="btn btn-primary remove-color">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-success" id="add-color">Add Color</button>
            <hr class="solid">

            <!-- Size Fields -->
            <div id="sizes" class="form-input">
                <?php 
                    while($size = mysqli_fetch_assoc($sizes)){
                ?>
                <div class="size form-input" data-size-id="<?php echo $size['size_id']; ?>">
                    <input type="hidden" name="size_id[]" value="<?php echo $size['size_id']; ?>">
                    <input type="text" name="size[]" placeholder="Size" value="<?php echo htmlspecialchars($size['sizes']); ?>">
                    <input type="text" name="price[]" placeholder="Price" value="<?php echo htmlspecialchars($size['price']); ?>">
                    <button type="button" class="btn btn-primary remove-size">Remove</button>
                </div>
                <?php 
                    }
                ?>
                <!-- Default empty size input -->
                <div class="size form-input">
                    <input type="text" name="size[]" placeholder="Size">
                    <input type="text" name="price[]" placeholder="Price">
                    <button type="button" class="btn btn-primary remove-size">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-success" id="add-size">Add Size</button>
            <hr class="solid">
            
            <label for="product_image" class="form-label">Upload Product Images</label>
                                <input type="file" name="product_image" id="product_images" class="form-control" accept="image/*" multiple onchange="previewImages(event)" required>
                                <div id="images_preview"></div>
            
            <button type="submit" class="btn btn-success" id="add_product" name="edit_product">Edit Product</button>
        </form>
    </div>

    <!-- Footer and other HTML code here -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Add new color
        document.getElementById("add-color").addEventListener("click", function() {
            var colorContainer = document.getElementById("colors");
            var newColor = document.createElement("div");
            newColor.classList.add("color", "form-input");
            newColor.innerHTML = `
                <input type="text" name="color[]" placeholder="Color">
                <button type="button" class="btn btn-primary remove-color">Remove</button>
            `;
            colorContainer.appendChild(newColor);
        });

        // Add new size
        document.getElementById("add-size").addEventListener("click", function() {
            var sizeContainer = document.getElementById("sizes");
            var newSize = document.createElement("div");
            newSize.classList.add("size", "form-input");
            newSize.innerHTML = `
                <input type="text" name="size[]" placeholder="Size">
                <input type="text" name="price[]" placeholder="Price">
                <button type="button" class="btn btn-primary remove-size">Remove</button>
            `;
            sizeContainer.appendChild(newSize);
        });

        // Event delegation for remove buttons
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-color")) {
                var colorId = event.target.parentNode.getAttribute('data-color-id');
                if (colorId) {
                    fetch('delete_color.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: colorId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            event.target.parentNode.remove();
                        } else {
                            alert('Failed to remove color.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Failed to remove color.');
                    });
                } else {
                    event.target.parentNode.remove();
                }
            } else if (event.target.classList.contains("remove-size")) {
                var sizeId = event.target.parentNode.getAttribute('data-size-id');
                if (sizeId) {
                    fetch('delete_size.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: sizeId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            event.target.parentNode.remove();
                        } else {
                            alert('Failed to remove size.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Failed to remove size.');
                    });
                } else {
                    event.target.parentNode.remove();
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
    // Add new color
    document.getElementById("add-color").addEventListener("click", function() {
        var colorContainer = document.getElementById("colors");
        var newColor = document.createElement("div");
        newColor.classList.add("color", "form-input");
        newColor.innerHTML = `
            <input type="text" name="color[]" placeholder="Color">
            <button type="button" class="btn btn-primary remove-color">Remove</button>
        `;
        colorContainer.appendChild(newColor);
    });

    // Add new size
    document.getElementById("add-size").addEventListener("click", function() {
        var sizeContainer = document.getElementById("sizes");
        var newSize = document.createElement("div");
        newSize.classList.add("size", "form-input");
        newSize.innerHTML = `
            <input type="text" name="size[]" placeholder="Size">
            <input type="text" name="price[]" placeholder="Price">
            <button type="button" class="btn btn-primary remove-size">Remove</button>
        `;
        sizeContainer.appendChild(newSize);
    });

    // Event delegation for remove buttons
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-color")) {
            var colorId = event.target.parentNode.getAttribute('data-color-id');
            if (colorId) {
                fetch('delete_color.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: colorId })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        event.target.parentNode.remove();
                    } else {
                        alert('Failed to remove color.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove color.');
                });
            } else {
                event.target.parentNode.remove();
            }
        } else if (event.target.classList.contains("remove-size")) {
            var sizeId = event.target.parentNode.getAttribute('data-size-id');
            if (sizeId) {
                fetch('delete_size.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: sizeId })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        event.target.parentNode.remove();
                    } else {
                        alert('Failed to remove size.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove size.');
                });
            } else {
                event.target.parentNode.remove();
            }
        }
    });
});


    </script>
    <script src="js/imgpreviewproducts.js"></script>
    <script src="js/deleteproduct.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybAIXeBDSQRdXpTWoE1lYapOdr9cGldeu/fla/hZ7Am4p6pDl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoA6Hk6t7nU+2D8ID2Faz+7Cl4jPYI4H2k6AEfOZlO4LBp3+NUDqqr0R3lRYAMSs" crossorigin="anonymous"></script>
</body>
</html>
