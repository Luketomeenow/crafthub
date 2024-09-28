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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/maddproduct.css">
    <link rel="stylesheet" href="css/mnavigation.css">
    <link rel="stylesheet" href="css/mfooter.css">
</head>
<body>
    <!--=============== ADD PRODUCT CONTAINER ==============-->
    <div class="container">
        <form id="product-form" action="edit_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="row">
                <div class="col-md-4 image-container">
                    <div class="image">
                    <img src="<?php echo '../uploads/' . $row['product_img']; ?>" alt="Product Image" class="prod-img" id="product_image">
                    </div>
                    <input type="file" id="image-upload" name="product_image" accept="image/*" style="display: none;">
                    <button type="button" class="btn image-btn btn-outline-success mt-2" id="image-btn">Upload Image</button>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" value = "<?php echo htmlspecialchars($row['product_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="text" name="stock" class="form-control" placeholder="Stock" value = "<?php echo htmlspecialchars($row['stock']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="product_category" class="form-label">Product Category</label>
                            <select name="product_category" id="product_category" class="form-select">
                                <option value="Rugs" <?php if ($row['category'] == 'Rugs') echo 'selected'; ?>>Rugs</option>
                                <option value="Tables" <?php if ($row['category'] == 'Tables') echo 'selected'; ?>>Tables</option>
                                <option value="Dining" <?php if ($row['category'] == 'Dining') echo 'selected'; ?>>Dining</option>
                                <option value="Lighting" <?php if ($row['category'] == 'Lighting') echo 'selected'; ?>>Lighting</option>
                                <option value="Storage" <?php if ($row['category'] == 'Storage') echo 'selected'; ?>>Storage</option>
                                <option value="Furniture" <?php if ($row['category'] == 'Furniture') echo 'selected'; ?>>Furniture</option>
                                <option value="Kitchen" <?php if ($row['category'] == 'Kitchen') echo 'selected'; ?>>Kitchen</option>
                                <option value="Decor" <?php if ($row['category'] == 'Decor') echo 'selected'; ?>>Decor</option>
                                <option value="Coasters" <?php if ($row['category'] == 'Coasters') echo 'selected'; ?>>Coasters</option>
                                <option value="Trays" <?php if ($row['category'] == 'Trays') echo 'selected'; ?>>Trays</option>
                                <option value="Accessories" <?php if ($row['category'] == 'Accessories') echo 'selected'; ?>>Accessories</option>
                                <option value="Others" <?php if ($row['category'] == 'Others') echo 'selected'; ?>>Others</option>

                            </select>
                    </div>
                </div>
            </div>
            <hr class="solid">
            <div class="row">
                <div class="col-md-12">
                    <label for="product_desc" class="form-label">Product Description</label>
                    <input type="text" name="product_desc" class="form-control" placeholder="Product Description" value="<?php echo htmlspecialchars($row['product_desc']); ?>">
                </div>
                <div class="col-md-12">
                    <label for="material" class="form-label">Product Material</label>
                    <input type="text" name="material" class="form-control" placeholder="Product Material" value="<?php echo htmlspecialchars($row['material']); ?>">
                </div>
            </div>
            <hr class="solid">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="color" class="form-label">Color</label>
                            <div id="color-container">
                                <div class="input-group">
                                    <input type="text" name="color[]" class="form-control" placeholder="Color">
                                    <button type="button" class="btn btn-success" id="add-color">Add</button>
                                </div>
                                 <?php 
                                while($colors = mysqli_fetch_assoc($color)){
                                ?>
                                
                                <input type="hidden" name="color_id[]" value="<?php echo $colors['color_id']; ?>">
                                <div class="input-group mt-2">
                                    <input type="text" name="color[]" class="form-control" value="<?php echo htmlspecialchars($colors['color']); ?>" placeholder="Color">
                                    <button type="button" class="btn btn-danger remove-color">Remove</button>
                                </div>
                                <?php 
                                }
                                ?> 
                                
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="size" class="form-label">Size</label>
                            <div id="size-container">
                                <div class="input-group">
                                    <input type="text" name="size[]" class="form-control" placeholder="Size">
                                </div>
                                <?php 
                                while($size = mysqli_fetch_assoc($sizes)){
                                ?>
                                <input type="hidden" name="size_id[]" value="<?php echo $size['size_id']; ?>">  
                                <div class="input-group mt-2" data-size-id="<?php echo $size['size_id']; ?>">
                                    <input type="text" name="size[]" class="form-control" value="<?php echo htmlspecialchars($size['sizes']); ?>" placeholder="Size">
                                     
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="price" class="form-label">Price</label>
                            <div id="price-container">
                                <div class="input-group">
                                    <input type="text" name="price[]" class="form-control" placeholder="Price">
                                    <button type="button" class="btn btn-success" id="add-size-price">Add</button>
                                </div>
                                <?php 
                                // Loop through prices separately 
                                mysqli_data_seek($sizes, 0);  // Reset pointer for the second loop if the same result set
                                while($size = mysqli_fetch_assoc($sizes)){
                                ?>
                                <input type="hidden" name="size_id[]" value="<?php echo $size['size_id']; ?>">                             
                                <div class="input-group mt-2" data-size-id="<?php echo $size['size_id']; ?>">                                  
                                    <input type="text" name="price[]" class="form-control" value="<?php echo htmlspecialchars($size['price']); ?>" placeholder="Price">
                                    <button type="button" class="btn btn-danger remove-size-price" id="remove-size-price">Remove</button>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <hr class="solid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success w-100 action-btn" id="add_product" name="edit_product">Save Changes</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger w-100 action-btn" id="delete" name="delete">Delete Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
         document.getElementById('image-upload').addEventListener('change', function(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var imgElement = document.getElementById('product_image');
                var previewElement = document.getElementById('image-preview');

                // Set the image source to the uploaded image
                imgElement.src = reader.result;

                // Show the image and hide the "No Image Uploaded" message
                imgElement.style.display = 'block';
                if (previewElement) {
                    previewElement.style.display = 'none';
                }
            };

            reader.readAsDataURL(event.target.files[0]);
        });

        // Trigger file upload when the button is clicked
        document.getElementById('image-btn').addEventListener('click', function() {
            document.getElementById('image-upload').click();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const colorContainer = document.getElementById('color-container');
            const sizeContainer = document.getElementById('size-container');
            const priceContainer = document.getElementById('price-container');
            const addColorButton = document.getElementById('add-color');
            const addSizePriceButton = document.getElementById('add-size-price');

            function addColor() {
                const newColorInput = document.createElement('div');
                newColorInput.classList.add('input-group', 'mt-2');
                newColorInput.innerHTML = `
                    <input type="text" name="color[]" class="form-control" placeholder="Color">
                    <button type="button" class="btn btn-danger remove-color">Remove</button>
                `;
                colorContainer.appendChild(newColorInput);
            }

            function addSizePrice() {
                const newSizeInput = document.createElement('div');
                newSizeInput.classList.add('input-group', 'mt-2');
                newSizeInput.innerHTML = `
                    <input type="text" name="size[]" class="form-control" placeholder="Size">
                `;
                sizeContainer.appendChild(newSizeInput);

                const newPriceInput = document.createElement('div');
                newPriceInput.classList.add('input-group', 'mt-2');
                newPriceInput.innerHTML = `
                    <input type="text" name="price[]" class="form-control" placeholder="Price">
                    <button type="button" class="btn btn-danger remove-size-price">Remove</button>
                `;
                priceContainer.appendChild(newPriceInput);
            }

            addColorButton.addEventListener('click', addColor);
            addSizePriceButton.addEventListener('click', addSizePrice);
            
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
                } else if (event.target.classList.contains("remove-size-price")) {
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
</body>
</html>
