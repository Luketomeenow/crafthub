<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraftHub: An Online Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/morders.css">
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
                    <li class="mx-4 d-inline-block"><a href="morders.php">Orders</a></li>
                    <li class="mx-4 d-inline-block"><a href="mchatroom.php">Messages</a></li>
                    <li class="mx-4 d-inline-block"><a href="maccount.php">Settings</a></li>
                    <li class="mx-4 d-inline-block"><a href="index.php">Logout</a></li>
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

    <!--=============== NAVTAB CONTENT ===============-->
    <div class="container-fluid">
        <div class="row">
        </div>
         <!--=============== NAVTAB HEADERS ===============-->
         <ul class="nav nav-tabs nav-justified" id="responsive-tabs">
            <li class="nav-item col-md-1">
                <a class="nav-link active" data-bs-toggle="tab" href="#all">All</a>
            </li>
            <li class="nav-item col-md-4">
                <a class="nav-link" data-bs-toggle="tab" href="#new-orders">New Orders</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="nav-link" data-bs-toggle="tab" href="#to-ship">To Ship</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="nav-link" data-bs-toggle="tab" href="#cancelled">Cancelled</a>
            </li>
            <li class="nav-item col-md-1">
                <a class="nav-link" data-bs-toggle="tab" href="#return">Return</a>
            </li>
        </ul>

        <div id="common-content" class="tab-content active">
            <!--=============== TAB PANES ===============-->
            <div class="tab-pane fade show active" id="all">
                <div id="common-content" class="tab-content active">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="#">
                                <div class="search-input">
                                    <input type="search" placeholder="Search...">
                                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                </div>
                            </form>
                        </div>
                        <hr class="solid1">
                    </div>     
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center">
                                <div class="order-details">Customer Name</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="order-id-container">
                                <div class="order-id">Order ID: 12345</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <img src="images/craftsbg.png" id="product-image" alt="user image">
                        </div>
                        <div class="col-md-2">
                            <div class="product-name">Product Name</div>
                            <div class="order-date">Order Date: </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-variation">Variation</div>
                        </div>
                        <div class="col-md-3">
                            <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-status">To Ship</div>
                        </div>
                        <div class="col-md-1">
                            <div class="product-price">Total Price</div>
                            <div class="product-detail">
                                <a href="#" class="edit-btn">Edit</a>
                            </div>
                            <div class="product-detail">
                                <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                            </div>
                        </div>
                        <hr class="solid4">
                    </div>
                </div>
            </div>
                <div class="tab-pane fade" id="new-orders">
                    <!--=============== NEW ORDERS TAB ===============-->
                    <div id="common-content" class="tab-content active">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="#">
                                    <div class="search-input">
                                        <input type="search" placeholder="Search...">
                                        <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                    </div>
                                </form>
                            </div>
                            <hr class="solid1">
                        </div>     
                        <div class="row">
                            <div class="col-md-10">
                                <div class="d-flex align-items-center">
                                    <div class="order-details">Customer Name</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-id-container">
                                    <div class="order-id">Order ID: 12345</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-1">
                            <img src="images/craftsbg.png" id="product-image" alt="user image">
                        </div>
                        <div class="col-md-2">
                            <div class="product-name">Product Name</div>
                            <div class="order-date">Order Date: </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-variation">Variation</div>
                        </div>
                        <div class="col-md-3">
                            <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-status">To Ship</div>
                        </div>
                        <div class="col-md-1">
                            <div class="product-price">Total Price</div>
                            <div class="product-detail">
                                <a href="#" class="edit-btn">Edit</a>
                            </div>
                            <div class="product-detail">
                                <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                            </div>
                        </div>
                        <hr class="solid4">
                        </div>
                    </div>
                </div>
                    <div class="tab-pane fade" id="to-ship">
                        <!--=============== TO SHIP TAB ===============-->
                        <div id="common-content" class="tab-content active">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="#">
                                        <div class="search-input">
                                            <input type="search" placeholder="Search...">
                                            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                        </div>
                                    </form>
                                </div>
                                <hr class="solid1">
                            </div>     
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="d-flex align-items-center">
                                        <div class="order-details">Customer Name</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="order-id-container">
                                        <div class="order-id">Order ID: 12345</div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                        <div class="col-md-1">
                            <img src="images/craftsbg.png" id="product-image" alt="user image">
                        </div>
                        <div class="col-md-2">
                            <div class="product-name">Product Name</div>
                            <div class="order-date">Order Date: </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-variation">Variation</div>
                        </div>
                        <div class="col-md-3">
                            <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-status">To Ship</div>
                        </div>
                        <div class="col-md-1">
                            <div class="product-price">Total Price</div>
                            <div class="product-detail">
                                <a href="#" class="edit-btn">Edit</a>
                            </div>
                            <div class="product-detail">
                                <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                            </div>
                        </div>
                        <hr class="solid4">
                            </div>
                        </div>
                    </div>
                        <div class="tab-pane fade" id="completed">
                            <!--=============== COMPLETED TAB ===============-->
                            <div id="common-content" class="tab-content active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="search-input">
                                                <input type="search" placeholder="Search...">
                                                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="solid1">
                                </div>     
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-flex align-items-center">
                                            <div class="order-details">Customer Name</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="order-id-container">
                                            <div class="order-id">Order ID: 12345</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="images/craftsbg.png" id="product-image" alt="user image">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="product-name">Product Name</div>
                                        <div class="order-date">Order Date: </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="product-variation">Variation</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="product-status">To Ship</div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="product-price">Total Price</div>
                                        <div class="product-detail">
                                            <a href="#" class="edit-btn">Edit</a>
                                        </div>
                                        <div class="product-detail">
                                            <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                                        </div>
                                    </div>
                                    <hr class="solid4">
                                </div>
                            </div>
                        </div>
                            <div class="tab-pane fade" id="cancelled">
                                <!--=============== CANCELLED TAB ===============-->
                                <div id="common-content" class="tab-content active">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="#">
                                                <div class="search-input">
                                                    <input type="search" placeholder="Search...">
                                                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <hr class="solid1">
                                    </div>     
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="d-flex align-items-center">
                                                <div class="order-details">Customer Name</div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="order-id-container">
                                                <div class="order-id">Order ID: 12345</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="images/craftsbg.png" id="product-image" alt="user image">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="product-name">Product Name</div>
                                            <div class="order-date">Order Date: </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="product-variation">Variation</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="product-status">To Ship</div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="product-price">Total Price</div>
                                            <div class="product-detail">
                                                <a href="#" class="edit-btn">Edit</a>
                                            </div>
                                            <div class="product-detail">
                                                <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                                            </div>
                                        </div>
                                        <hr class="solid4">
                                    </div>
                                </div>
                            </div>
                                <div class="tab-pane fade" id="return">
                                    <!--=============== RETURNED TAB ===============-->
                                    <div id="common-content" class="tab-content active">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form action="#">
                                                    <div class="search-input">
                                                        <input type="search" placeholder="Search...">
                                                        <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <hr class="solid1">
                                        </div>     
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="d-flex align-items-center">
                                                    <div class="order-details">Customer Name</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="order-id-container">
                                                    <div class="order-id">Order ID: 12345</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img src="images/craftsbg.png" id="product-image" alt="user image">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="product-name">Product Name</div>
                                                <div class="order-date">Order Date: </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="product-variation">Variation</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="order-note">Note: <input type="text" placeholder="Note to Customer" readonly></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="product-status">To Ship</div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="product-price">Total Price</div>
                                                <div class="product-detail">
                                                    <a href="#" class="edit-btn">Edit</a>
                                                </div>
                                                <div class="product-detail">
                                                    <button type="button" class="btn btn-danger delete-btn">Cancel</button>
                                                </div>
                                            </div>
                                            <hr class="solid4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--=============== END OF NAVTAB CONTENT ===============-->

    <!--=============== EDIT ORDER MODAL ===============-->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm">
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Product Price</label>
                            <input type="text" class="form-control" id="editProductPrice" placeholder="₱">
                        </div>
                        <div class="mb-3">
                            <label for="editProductColor" class="form-label">Color</label>
                            <select class="form-select" id="editProductColor">
                                <option value="Brown">Brown</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductSize" class="form-label">Size</label>
                            <select class="form-select" id="editProductSize">
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStatus" class="form-label">Product Status</label>
                            <select class="form-select" id="editProductStatus">
                                <option value="To Ship">To Ship</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Returned">Returned</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--=============== END OF EDIT ORDER MODAL ===============-->
    
 <!--=============== FOOTER ===============-->
 <footer>
            <div class="row">
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
<script src="js/mtabs.js"> </script>
<script src="js/mtrackmodal.js"> </script>
</body>
</html>