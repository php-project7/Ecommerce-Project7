<?php
if(isset($_GET['logout'])){
    unset($_SESSION['email'], $_SESSION['name'], $_SESSION['Role']);
    session_destroy();
    header("Location: ../../login.php");
}

//handle search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
}
$errors = array();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="../css/font-face.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- ../Vendor CSS-->
    <link href="../vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="../vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="../users/index.php">
                        <img src="../images/icon/logo-icon.png" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="has-sub">
                        <a class="js-arrow" href="../index.php">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="../../index.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="../index.php">Users</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="../products/index.php">
                                    <i class="fas fa-cart-arrow-down"></i>Products</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="../categories/index.php">
                                    <i class="fas fa-cart-arrow-down"></i>Categories</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="../orders/index.php">
                                    <i class="fas fa-cart-arrow-down"></i>Orders</a>
                            </li>

                            <li>
                                <a href="../users/index.php">
                                    <i class="fas fa-chart-bar"></i>Users</a>
                            </li
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="../images/icon/logo-icon.png" alt="Cool Admin" />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li class="has-sub">
                        <a class="js-arrow" href="../index.php">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="../products/index.php">
                            <i class="fas fa-cart-arrow-down"></i>Products</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="../categories/index.php">
                            <i class="fas fa-cart-arrow-down"></i>Categories</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="../orders/index.php">
                            <i class="fas fa-cart-arrow-down"></i>Orders</a>
                    </li>

                    <li>
                        <a href="../users/index.php">
                            <i class="fas fa-chart-bar"></i>Users</a>
                    </li
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <div class="header-search">

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                                <input type="text" name="search" class="form-control" placeholder="Search">
                                <button hidden type="submit" class="search-btn"><i class="icon-search"></i></button>
                            </form>
                        </div><!-- End .header-search -->
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="content">
                                        <a class="js-acc-btn" href="#"><?php echo $_SESSION['name'] ?></a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#"><?php echo $_SESSION['name'] ?></a>
                                                </h5>
                                                <span class="email"><?php echo $_SESSION['email'] ?></span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">


                                            <a href="?logout=1">
                                                <i class="zmdi zmdi-power"></i>Logout</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

