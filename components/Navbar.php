<?php
 include('../admin/config/server.php');
 $_SESSION['superTotal'] = 0;
 try {
#newcode
    $_command = "SELECT * FROM tempcart";
    $statement = $pdo->prepare($_command);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $results = $statement->fetchAll();
    $superTotal = 0;
    if ($statement->rowCount()) {
        // echo "<pre>";
        // var_dump($results);
        // echo "</pre>";
    } else {
        echo "fail";
    }
} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

// function mahdiReload()
// {
//     echo "<script> window.location.reload();</script>";
//     // echo `<meta http-equiv="Location" content="./cart.php">`;
//     // echo header("Refresh:0");
// }
// function mahdiStopReload()
// {
//     echo "<script> window.stop();</script>";
// }

?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/category-list.html  22 Nov 2019 10:02:52 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/icons/site.html">
    <link rel="mask-icon" href="../assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="../assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="../assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/plugins/nouislider/nouislider.css">
</head>

<body>





<header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <div class="header-dropdown">
                            <a href="#">JD</a>
                           <!-- End .header-menu -->
                        </div><!-- End .header-dropdown -->

                        <div class="header-dropdown">
                            <a href="#">Eng</a>
                           <!-- End .header-menu -->
                        </div><!-- End .header-dropdown -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>
                                    <li><a href="tel:#"><i class="icon-phone"></i>Call Us: +962770245060</a></li>
                                    <li><a href="../pages/wishlist.html"><i class="icon-heart-o"></i>Wishlist <span>(3)</span></a></li>
                                    <li><a href="../pages/about.html">About Us</a></li>
                                    <li><a href="../pages/contact.html">Contact Us</a></li>
                                    <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Sign In / Sign Up</a></li>
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="../index.php" class="logo">
                            <img src="../assets/images/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container active">
                                    <a href="../index.php" class="">Home</a>

                                    
                                </li>
                                <li>
                                    <a href="../pages/category-list.php" class="sf-with-ul">Shop</a>

                                    
                                </li>
                                <li>
                                    <a href="../pages/cart.php" class="  ">Cart</a>

                                    
                                <li>
                                    <a href="../pages/checkout.php" class="  ">Checkout</a>

                                    
                                </li>
                                <li>
                                    <a href="../pages/dashboard.php" class="  ">My Account</a>

                                    
                                </li>
                                
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        
                            <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <!-- <span class="cart-count">2</span> -->
                                <span class="cart-count"><?php echo $statement->rowCount(); ?></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    <?php for ($i = 0; $i < count($results); $i++) { ?>
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a><?php echo $results[$i]['name']; ?></a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span
                                                    class="cart-product-qty"><?php echo $results[$i]['quantity']; ?></span>
                                                x <?php echo $results[$i]['price']; ?><span>JD</span>
                                            </span>
                                        </div>

                                        <figure class="product-image-container">
                                            <a class="product-image">
                                                <img src="<?php echo $results[$i]['img']; ?>" alt="product">
                                            </a>
                                        </figure>
                                    </div><!-- End .product -->
                                    <?php
                                    }
                                    ?>
                                </div><!-- End .cart-product -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
 <!-- Mobile Menu -->
 <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="../index.php">Home</a>

                    </li>
                    <li>
                        <a href="../pages/category-list.php">Shop</a>
                       
                    </li>
                    <li>
                        <a href="../pages/cart.php" class="">Cart</a>
                       
                    </li>
                    <li>
                    <a href="../pages/checkout.php" class="  ">Checkout</a>
                        
                    </li>
                    <li>
                    <a href="../pages/dashboard.php" class="  ">My Account</a>

                        
                    </li>
                    
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="https://web.facebook.com/" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="https://twitter.com/" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="https://www.instagram.com/" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="https://www.youtube.com/" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->



<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2" aria-selected="true">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                        <?php include('../admin/config/errors.php'); ?>
                                        <div class="form-group">
                                            <label for="singin-email-2">Username or email address *</label>
                                            <input type="text" class="form-control" id="singin-email-2" name="login-email" >
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password-2">Password *</label>
                                            <input type="password" class="form-control" id="singin-password-2" name="login-password" >
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" name="login_user">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember-2">
                                                <label class="custom-control-label" for="signin-remember-2">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                        <?php include('../admin/config/errors.php'); ?>
                                        <div class="form-group">
                                            <label for="register-email-2">Your Name *</label>
                                            <input type="text" class="form-control" id="register-email-2" name="name" value="<?php echo $name; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="register-email-2">Your email address *</label>
                                            <input type="email" class="form-control" id="register-email-2" name="email" value="<?php echo $email; ?>" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password-2">Password *</label>
                                            <input type="password" class="form-control" id="register-password-2" name="password_1" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-password-2">Confirm Password *</label>
                                            <input type="password" class="form-control" id="register-password-2" name="password_2" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" name="reg_user">>
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                                <label class="custom-control-label" for="register-policy-2">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery.hoverIntent.min.js"></script>
    <script src="../assets/js/jquery.waypoints.min.js"></script>
    <script src="../assets/js/superfish.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>
