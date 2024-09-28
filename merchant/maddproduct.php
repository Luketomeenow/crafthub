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
                <a href="mchatroom.php">Messages</a>
                <a href="morders.php">Orders</a>
                <a href="maccount.php">Settings</a>
                <a href="index.php">Log out</a>
            </div>
        </nav>
    </div>
<!--=============== END NAVIGATION ==============-->

             <!--=============== PRODUCT DESCRIPTION CONTAINER ===============-->
             <div class="container">
                    <form id="product-form" action="add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 image-container">
                                <div class="image">
                                    <div id="image-preview">
                                        <span>No Image Uploaded</span>
                                    </div>
                                    <img src="" alt="Product Image" class="prod-img" id="product_image" style="display: none;" >
                                </div>
                                <input type="file" id="image-upload" name="product_image" accept="image/*" style="display: none;"required>
                                <button type="button" class="btn image-btn btn-outline-success mt-2" id="image-btn">Upload Image</button>
                            </div>
                                <div class="col-md-8"> <!--=============== PRODUCT NAME, STOCK, CATEGORY ==============-->
                                    <div class="form-group">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="text" name="stock" class="form-control" placeholder="Stock" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category" class="form-label">Product Category</label>
                                        <select name="product_category" id="product_category" class="form-select" required>
                                            <option value="Rugs">Rugs</option>
                                            <option value="Tables">Tables</option>
                                            <option value="Dining">Dining </option>
                                            <option value="Lighting">Lighting</option>
                                            <option value="Storage">Storage</option>
                                            <option value="Furniture">Furniture</option>
                                            <option value="Kitchen">Kitchen</option>
                                            <option value="Decor">Decor</option>
                                            <option value="Coasters">Coasters</option>
                                            <option value="Trays">Trays</option>
                                            <option value="Accessories">Accessories</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <hr class="solid"> <!--=============== PRODUCT DESCRIPTION ==============-->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="product_desc" class="form-label">Product Description</label>
                                <textarea name="product_desc" class="form-control" placeholder="Product Description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="material" class="form-label">Product Material</label>
                                <textarea name="material" class="form-control" placeholder="Product Material" rows="1"></textarea>
                            </div>
                        </div>
                        <hr class="solid">
                        <div class="row"> <!--=============== COLOR, SIZE AND PRICE ==============-->
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="color" class="form-label">Color</label>
                                        <div class="input-group">
                                            <input type="text" name="color[]" class="form-control" placeholder="Color">
                                            <button type="button" class="btn btn-success" id="add-color">Add</button>
                                        </div>
                                        <div id="color-container"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="size" class="form-label">Size</label>
                                        <div class="input-group">
                                            <input type="text" name="size[]" class="form-control" placeholder="Size">
                                        </div>
                                        <div id="size-container"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="price" class="form-label">Price</label>
                                        <div class="input-group">
                                            <input type="number" name="price[]" class="form-control" placeholder="Price">
                                            <button type="button" class="btn btn-success" id="add-size-price">Add</button>
                                        </div>
                                        <div id="price-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="solid"> <!--=============== ADD PRODUCT BUTTON ==============-->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success w-100" id="add_product" name="add_product">Add Product</button>
                            </div>
                        </div>
            </div>


        
    <!--=============== FOOTER ===============-->
    <footer>
            <div class ="row">
                <div class="col-md-4 column1">
                    <h1>Information</h1>
                    <hr class="solid">
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div> 
            <div class="col-md-4 column2">
                <h1>Contact Us</h1>
                <hr class="solid">
                <ul>
                    <li>Mobile Phone: +63 000 0000 000</li>
                    <li>Landline/Hotline: 633 - 000</li>
                    <li>Email: crafthub@gmail.com</li>
                    <li>Address: 1234 Balanga City, Bataan</li>
                </ul>
            </div>
            <div class="col-md-2 column3">
                <h1>Location</h1>
                <hr class="solid">
                <ul>
                    <li><a href="#">Store Map</a></li>
                </ul>
            </div>
            <div class="col-md-2 column4">
                <h1>Follow Us</h1>
                <hr class="solid">
                <ul class="icon-list">
                <li><i class="ri-facebook-circle-fill icon"></i> <a href="https://www.facebook.com/profile.php?id=61560260376052&mibextid=kFxxJD">Facebook</a></li>
                <li><i class="ri-instagram-fill icon"></i> <a href="https://www.instagram.com/crafthub_marketplace/?igsh=MThrc2RqanRkNm5jbw%3D%3D&utm_source=qr&fbclid=IwZXh0bgNhZW0CMTAAAR2d71GTGslbYpn1DiIlFm8dSO4DatwpoCl0NKwcqpj-fqbK8FqwBzezx9Q_aem_AbKH8tCd3bTBEbj_Yy0KWtse2K8bi0en7nrgSLcIk_k-9gdX9UC6BHIyZgztNpuEY_gY96NzVO0XqTMhpAnhBsbb">Instagram</a></li>
                <li><i class="ri-google-fill icon"></i> <a href="mailto:crafthubmarketplace@gmail.com">Gmail</a></li>
                </ul>
            </div>    
            </div>
    </footer>
    <!--=============== END FOOTER ===============-->
    <!--=============== SCRIPTS ===============-->
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
                        previewElement.style.display = 'none';
                    };

                    reader.readAsDataURL(event.target.files[0]);
                });

                // Trigger file upload when the button is clicked
                document.getElementById('image-btn').addEventListener('click', function() {
                    document.getElementById('image-upload').click();
                });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const colorContainer = document.getElementById('color-container');
            const sizeContainer = document.getElementById('size-container');
            const priceContainer = document.getElementById('price-container');
            const addColorButton = document.getElementById('add-color');
            const addSizePriceButton = document.getElementById('add-size-price');
            const colorInput = document.querySelector('input[name="color[]"]');
            const sizeInput = document.querySelector('input[name="size[]"]');
            const priceInput = document.querySelector('input[name="price[]"]');

            function addColor() {
                const newColorInput = document.createElement('div');
                newColorInput.classList.add('input-group', 'mt-2');
                newColorInput.innerHTML = `
                    <input type="text" name="color[]" class="form-control" placeholder="Color">
                    <button type="button" class="btn btn-danger remove-color">Remove</button>
                `;
                colorContainer.appendChild(newColorInput);

                // Add event listener to the remove button
                newColorInput.querySelector('.remove-color').addEventListener('click', function() {
                    colorContainer.removeChild(newColorInput);
                });
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

                // Add event listener to the remove button
                newPriceInput.querySelector('.remove-size-price').addEventListener('click', function() {
                    sizeContainer.removeChild(newSizeInput);
                    priceContainer.removeChild(newPriceInput);
                });
            }

            // Add a new empty input field when the "Add Color" button is clicked
            addColorButton.addEventListener('click', function() {
                addColor();
            });

            // Add new empty input fields for size and price when the "Add" button is clicked
            addSizePriceButton.addEventListener('click', function() {
                addSizePrice();
            });
        });
    </script>



</body>
</html>