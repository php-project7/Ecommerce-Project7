<?php
 include('admin/config/server.php');
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

$sql = $pdo->query("SELECT * FROM products WHERE discount >'0'");
$result = $sql->fetchAll();

$stmt = $pdo->query("SELECT * FROM products ");
$result1 = $stmt->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">
  <!-- molla/index-4.html  22 Nov 2019 09:53:08 GMT -->
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Molla - Bootstrap eCommerce Template" />
    <meta name="author" content="p-themes" />
    <!-- Favicon -->
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="assets/images/icons/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="assets/images/icons/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/images/icons/favicon-16x16.png"
    />
    <link rel="manifest" href="assets/images/icons/site.html" />
    <link
      rel="mask-icon"
      href="assets/images/icons/safari-pinned-tab.svg"
      color="#666666"
    />
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico" />
    <meta name="apple-mobile-web-app-title" content="Molla" />
    <meta name="application-name" content="Molla" />
    <meta name="msapplication-TileColor" content="#cc9966" />
    <meta
      name="msapplication-config"
      content="assets/images/icons/browserconfig.xml"
    />
    <meta name="theme-color" content="#ffffff" />
    <link
      rel="stylesheet"
      href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css"
    />
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="assets/css/plugins/owl-carousel/owl.carousel.css"
    />
    <link
      rel="stylesheet"
      href="assets/css/plugins/magnific-popup/magnific-popup.css"
    />
    <link rel="stylesheet" href="assets/css/plugins/jquery.countdown.css" />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/skins/skin-demo-4.css" />
    <link rel="stylesheet" href="assets/css/demos/demo-4.css" />
  </head>

  <body>
    <?php
  // print_r($_SESSION['id']);
  // $dt=print_r($_SESSION['id'],TRUE);
  // print_r($dt);
  ?>
    <div class="page-wrapper">
      <header class="header header-intro-clearance header-4">
        <div class="header-top">
          <div class="container">
            <div class="header-left">
              <a href="tel:#"
                ><i class="icon-phone"></i>Call Us: +962770245060</a
              >
            </div>
            <!-- End .header-left -->

            <div class="header-right">
              <ul class="top-menu">
                <li>
                  <a href="#">Links</a>
                  <ul>
                    <li>
                      <div class="header-dropdown">
                        <a href="#">JD</a>
                        
                        <!-- End .header-menu -->
                      </div>
                    </li>
                    <li>
                      <div class="header-dropdown">
                        <a href="#">English</a>
                        
                        <!-- End .header-menu -->
                      </div>
                    </li>
                    <li>
                      <a href="#signin-modal" data-toggle="modal"
                        >Sign in / Sign up</a
                      >
                    </li>
                  </ul>
                </li>
              </ul>
              <!-- End .top-menu -->
            </div>
            <!-- End .header-right -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .header-top -->

        <div class="header-middle">
          <div class="container">
            <div class="header-left">
              <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
              </button>

              <a href="index.html" class="logo">
                <img
                  src="assets/images/demos/demo-4/logo.png"
                  alt="Molla Logo"
                  width="105"
                  height="25"
                />
              </a>
            </div>
            <!-- End .header-left -->

            <div class="header-center">
              <div
                class="header-search header-search-extended header-search-visible d-none d-lg-block"
              >
                <a href="#" class="search-toggle" role="button"
                  ><i class="icon-search"></i
                ></a>
                <form action="#" method="get">
                  <div class="header-search-wrapper search-wrapper-wide">
                    <label for="q" class="sr-only">Search</label>
                    <button class="btn btn-primary" type="submit">
                      <i class="icon-search"></i>
                    </button>
                    <input
                      type="search"
                      class="form-control"
                      name="q"
                      id="q"
                      placeholder="Search product ..."
                      required
                    />
                  </div>
                  <!-- End .header-search-wrapper -->
                </form>
              </div>
              <!-- End .header-search -->
            </div>

            <div class="header-right">
              <div class="dropdown compare-dropdown">
                <a
                  href="#"
                  class="dropdown-toggle"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  data-display="static"
                  title="Compare Products"
                  aria-label="Compare Products"
                >
                  <!-- <div class="icon">
                    <i class="icon-random"></i>
                  </div> -->
                  <!-- <p>Compare</p> -->
                </a>

                
                <!-- End .dropdown-menu -->
              </div>
              <!-- End .compare-dropdown -->

              <!-- <div class="wishlist">
                <a href="pages/wishlist.html" title="Wishlist">
                  <div class="icon">
                    <i class="icon-heart-o"></i>
                    <span class="wishlist-count badge">3</span>
                  </div>
                  <p>Wishlist</p>
                </a>
              </div> -->
              <!-- End .compare-dropdown -->

              <div class="dropdown cart-dropdown">
                <a
                  href="#"
                  class="dropdown-toggle"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  data-display="static"
                >
                  <div class="icon">
                    <i class="icon-shopping-cart"></i>
                    <span class="cart-count"><?php echo $statement->rowCount(); ?></span>
                  </div>
                  <p>Cart</p>
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
              </div>
              <!-- End .cart-dropdown -->
            </div>
            <!-- End .header-right -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .header-middle -->

        <div class="header-bottom sticky-header">
          <div class="container">
           

            <div class="header-center">
              <nav class="main-nav">
                <ul class="menu sf-arrows">
                  <li class="megamenu-container active">
                    <a href="index.php">HOME</a>
                  </li>
                  <li>
                    <a href="pages/category-list.php" class="sf-with-ul">SHOP</a>

                   
                    <!-- End .megamenu megamenu-md -->
                  </li>
                  <li>
                    <a href="pages/cart.php" class="sf-with-ul">CART</a>

                    
                    <!-- End .megamenu megamenu-sm -->
                  </li>
                  <li>
                  <a href="pages/checkout.html" class="  ">CHECKOUT</a>

                  </li>
                  <li>
                  <a href="pages/dashboard.php" class="  ">MY ACCOUNT</a>
                    
                  </li>
                  
                </ul>
                <!-- End .menu -->
              </nav>
              <!-- End .main-nav -->
            </div>
            <!-- End .header-center -->

            <!-- <div class="header-right">
              <i class="la la-lightbulb-o"></i>
              <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div> -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .header-bottom -->
      </header>
      <!-- End .header -->

      <main class="main">
        <div class="intro-slider-container mb-5">
          <div
            class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light"
            data-toggle="owl"
            data-owl-options='{
                        "dots": true,
                        "nav": false, 
                        "responsive": {
                            "1200": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'
          >
            <div
              class="intro-slide"
              style="
                background-image: url(assets/images/demos/demo-4/slider/slide-1.png);
              "
            >
              <div class="container intro-content">
                <div class="row justify-content-end">
                  <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                    <h3 class="intro-subtitle text-third">
                      Deals and Promotions
                    </h3>
                    <!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">Beats by</h1>
                    <h1 class="intro-title">Dre Studio 3</h1>
                    <!-- End .intro-title -->

                    <div class="intro-price">
                      <sup class="intro-old-price">$349,95</sup>
                      <span class="text-third"> $279<sup>.99</sup> </span>
                    </div>
                    <!-- End .intro-price -->

                    <a href="category.html" class="btn btn-primary btn-round">
                      <span>Shop More</span>
                      <i class="icon-long-arrow-right"></i>
                    </a>
                  </div>
                  <!-- End .col-lg-11 offset-lg-1 -->
                </div>
                <!-- End .row -->
              </div>
              <!-- End .intro-content -->
            </div>
            <!-- End .intro-slide -->

            <div
              class="intro-slide"
              style="
                background-image: url(assets/images/demos/demo-4/slider/slide-2.png);
              "
            >
              <div class="container intro-content">
                <div class="row justify-content-end">
                  <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                    <h3 class="intro-subtitle text-primary">New Arrival</h3>
                    <!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">
                      Apple iPad Pro <br />12.9 Inch, 64GB
                    </h1>
                    <!-- End .intro-title -->

                    <div class="intro-price">
                      <sup>Today:</sup>
                      <span class="text-primary"> $999<sup>.99</sup> </span>
                    </div>
                    <!-- End .intro-price -->

                    <a href="category.html" class="btn btn-primary btn-round">
                      <span>Shop More</span>
                      <i class="icon-long-arrow-right"></i>
                    </a>
                  </div>
                  <!-- End .col-md-6 offset-md-6 -->
                </div>
                <!-- End .row -->
              </div>
              <!-- End .intro-content -->
            </div>
            <!-- End .intro-slide -->
          </div>
          <!-- End .intro-slider owl-carousel owl-simple -->

          <span class="slider-loader"></span
          ><!-- End .slider-loader -->
        </div>
        <!-- End .intro-slider-container -->

        <div class="container">
          <h2 class="title text-center mb-4">Explore Popular Categories</h2>
          <!-- End .title text-center -->

          <div class="cat-blocks-container">
            <div class="row">
              <div class="col-6 col-sm-4 col-lg-2">
                <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/1.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Computer & Laptop</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->

              <div class="col-6 col-sm-4 col-lg-2">
              <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/2.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Digital Cameras</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->

              <div class="col-6 col-sm-4 col-lg-2">
              <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/3.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Smart Phones</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->

              <div class="col-6 col-sm-4 col-lg-2">
              <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/4.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Televisions</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->

              <div class="col-6 col-sm-4 col-lg-2">
              <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/5.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Audio</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->

              <div class="col-6 col-sm-4 col-lg-2">
              <a href="pages/category-list.php" class="cat-block">
                  <figure>
                    <span>
                      <img
                        src="assets/images/demos/demo-4/cats/6.png"
                        alt="Category image"
                      />
                    </span>
                  </figure>

                  <h3 class="cat-block-title">Smart Watches</h3>
                  <!-- End .cat-block-title -->
                </a>
              </div>
              <!-- End .col-sm-4 col-lg-2 -->
            </div>
            <!-- End .row -->
          </div>
          <!-- End .cat-blocks-container -->
        </div>
        <!-- End .container -->

        <div class="mb-4"></div>
        <!-- End .mb-4 -->

        

        <!-- <div class="mb-3"></div> -->
        <!-- End .mb-5 -->

        <div class="container new-arrivals">
          <div class="heading heading-flex mb-3">
            <div class="heading-left">
              <h2 class="title">Sale Products</h2>
              <!-- End .title -->
            </div>
            <!-- End .heading-left -->

            <div class="heading-right">
              <ul
                class="nav nav-pills nav-border-anim justify-content-center"
                role="tablist"
              >
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="new-all-link"
                    data-toggle="tab"
                    href="#new-all-tab"
                    role="tab"
                    aria-controls="new-all-tab"
                    aria-selected="true"
                    >All</a
                  >
                </li>
              
               
              </ul>
            </div>
            <!-- End .heading-right -->
          </div>
          <!-- End .heading -->

          <div class="tab-content tab-content-carousel just-action-icons-sm">
            <div
              class="tab-pane p-0 fade show active"
              id="new-all-tab"
              role="tabpanel"
              aria-labelledby="new-all-link"
            >
              <div
                class="owl-carousel owl-full carousel-equal-height carousel-with-shadow"
                data-toggle="owl"
                data-owl-options='{
                                "nav": true, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":5
                                    }
                                }
                            }'
              >

                <?php foreach($result as $row) { ?>
                    <div class='product product-2'>
                        <figure class='product-media'>
                            <span class='product-label label-circle label-top'>Sale</span>
                            <a href='pages/product.php'><img src="<?= $row['img'] ?>" alt='Product image' class='product-image'/></a>
                            <div class='product-action-vertical'><a href='#' class='btn-product-icon btn-wishlist' title='Add to wishlist'></a></div>
                            <div class='product-action'><a href="addToCart.php?id=<?=$row['id'] ?>" class='btn-product btn-cart' title='Add to cart'><span>add to cart</span></a>
                                <a href='popup/quickView.html' class='btn-product btn-quickview' title='Quick view'><span>quick view</span></a></div>
                        </figure>
                        <div class='product-body'>
                            <div class='product-cat'><a href='#'>Laptops</a></div>
                            <h3 class='product-title'><a href='pages/product.php'><?= $row['name']?></a></h3>
                            <div class='product-price'><?= $row['price']?> . J.D</div>
                        </div>
                    </div>
                <?php } ?>


                <!-- End .product -->
              </div>
              <!-- End .owl-carousel -->
            </div>
            <!-- .End .tab-pane -->
        <!-- End .mb-6 -->

        
        <div class="container">
          <hr class="mb-0" />
          <div
            class="owl-carousel mt-5 mb-5 owl-simple"
            data-toggle="owl"
            data-owl-options='{
                        "nav": false, 
                        "dots": false,
                        "margin": 30,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "420": {
                                "items":3
                            },
                            "600": {
                                "items":4
                            },
                            "900": {
                                "items":5
                            },
                            "1024": {
                                "items":6
                            }
                        }
                    }'
          >
            <a href="#" class="brand">
              <img src="assets/images/brands/1.png" alt="Brand Name" />
            </a>

            <a href="#" class="brand">
              <img src="assets/images/brands/2.png" alt="Brand Name" />
            </a>

            <a href="#" class="brand">
              <img src="assets/images/brands/3.png" alt="Brand Name" />
            </a>

            <a href="#" class="brand">
              <img src="assets/images/brands/4.png" alt="Brand Name" />
            </a>

            <a href="#" class="brand">
              <img src="assets/images/brands/5.png" alt="Brand Name" />
            </a>

            <a href="#" class="brand">
              <img src="assets/images/brands/6.png" alt="Brand Name" />
            </a>
          </div>
          <!-- End .owl-carousel -->
        </div>
        <!-- End .container -->

        <div class="container new-arrivals">
          <div class="heading heading-flex mb-3">
            <div class="heading-left">
              <h2 class="title">All Products</h2>
              <!-- End .title -->
            </div>
            <!-- End .heading-left -->

            <div class="heading-right">
              <ul
                class="nav nav-pills nav-border-anim justify-content-center"
                role="tablist"
              >
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="new-all-link"
                    data-toggle="tab"
                    href="#new-all-tab"
                    role="tab"
                    aria-controls="new-all-tab"
                    aria-selected="true"
                    >All</a
                  >
                </li>
               
               
              </ul>
            </div>
            <!-- End .heading-right -->
          </div>
          <!-- End .heading -->

          <div class="tab-content tab-content-carousel just-action-icons-sm">
            <div
              class="tab-pane p-0 fade show active"
              id="new-all-tab"
              role="tabpanel"
              aria-labelledby="new-all-link"
            >
              <div
                class="owl-carousel owl-full carousel-equal-height carousel-with-shadow"
                data-toggle="owl"
                data-owl-options='{
                                "nav": true, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":5
                                    }
                                }
                            }'
              >

                  <?php foreach($result1 as $row) { ?>
                      <div class='product product-2'>
                     <figure class='product-media'>
                     <span class='product-label label-circle label-top'></span>
                    <a href='pages/product.php'><img src="<?= $row['img'] ?>" alt='Product image' class='product-image'/></a>
                     <div class='product-action-vertical'><a href='#' class='btn-product-icon btn-wishlist' title='Add to wishlist'></a></div>
                     <div class='product-action'><a href="addToCart.php?id=<?=$row['id'] ?>" class='btn-product btn-cart' title='Add to cart'><span>add to cart</span></a>
                      <a href='popup/quickView.html' class='btn-product btn-quickview' title='Quick view'><span>quick view</span></a></div>
                     </figure>
                       <div class='product-body'>
                      <div class='product-cat'><a href='#'>Laptops</a></div>
                      <h3 class='product-title'><a href='pages/product.php'><?= $row['name'] ?></a></h3>
                      <div class='product-price'><?= $row['price'] ?> . J.D</div>
                      </div>
                      </div>

                  <?php } ?>


                <!-- End .product -->
              </div>
              <!-- End .owl-carousel -->
            </div>
        <!-- End .bg-light pt-5 pb-6 -->

        <div class="mb-5"></div>
        <!-- End .mb-5 -->

        <div class="mb-4"></div>
        <!-- End .mb-4 -->

        <div class="container">
          <hr class="mb-0" />
        </div>
        <!-- End .container -->

        <div class="icon-boxes-container bg-transparent">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-lg-3">
                <div class="icon-box icon-box-side">
                  <span class="icon-box-icon text-dark">
                    <i class="icon-rocket"></i>
                  </span>
                  <div class="icon-box-content">
                    <h3 class="icon-box-title">Free Shipping</h3>
                    <!-- End .icon-box-title -->
                    <p>Orders 50 JD or more</p>
                  </div>
                  <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                <div class="icon-box icon-box-side">
                  <span class="icon-box-icon text-dark">
                    <i class="icon-rotate-left"></i>
                  </span>

                  <div class="icon-box-content">
                    <h3 class="icon-box-title">Free Returns</h3>
                    <!-- End .icon-box-title -->
                    <p>Within 30 days</p>
                  </div>
                  <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                <div class="icon-box icon-box-side">
                  <span class="icon-box-icon text-dark">
                    <i class="icon-info-circle"></i>
                  </span>

                  <div class="icon-box-content">
                    <h3 class="icon-box-title">Get 20% Off 1 Item</h3>
                    <!-- End .icon-box-title -->
                    <p>when you sign up</p>
                  </div>
                  <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                <div class="icon-box icon-box-side">
                  <span class="icon-box-icon text-dark">
                    <i class="icon-life-ring"></i>
                  </span>

                  <div class="icon-box-content">
                    <h3 class="icon-box-title">We Support</h3>
                    <!-- End .icon-box-title -->
                    <p>24/7 amazing services</p>
                  </div>
                  <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->
            </div>
            <!-- End .row -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .icon-boxes-container -->
      </main>
      <!-- End .main -->

      <footer class="footer">
        <div
          class="cta bg-image bg-dark pt-4 pb-5 mb-0"
          style="background-image: url(assets/images/demos/demo-4/bg-5.jpg)"
        >
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="cta-heading text-center">
                  <h3 class="cta-title text-white">Get The Latest Deals</h3>
                  <!-- End .cta-title -->
                  <p class="cta-desc text-white">
                    and receive
                    <span class="font-weight-normal">20 JD coupon</span> for first
                    shopping
                  </p>
                  <!-- End .cta-desc -->
                </div>
                <!-- End .text-center -->

                <form action="#">
                  <div class="input-group input-group-round">
                    <input
                      type="email"
                      class="form-control form-control-white"
                      placeholder="Enter your Email Address"
                      aria-label="Email Adress"
                      required
                    />
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <span>Subscribe</span
                        ><i class="icon-long-arrow-right"></i>
                      </button>
                    </div>
                    <!-- .End .input-group-append -->
                  </div>
                  <!-- .End .input-group -->
                </form>
              </div>
              <!-- End .col-sm-10 col-md-8 col-lg-6 -->
            </div>
            <!-- End .row -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .cta -->
        <div class="footer-middle">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-lg-3">
                <div class="widget widget-about">
                  <img
                    src="assets/images/demos/demo-4/logo-footer.png"
                    class="footer-logo"
                    alt="Footer Logo"
                    width="105"
                    height="25"
                  />
                  <p>
                    Praesent dapibus, neque id cursus ucibus, tortor neque
                    egestas augue, eu vulputate magna eros eu erat.
                  </p>

                  <div class="widget-call">
                    <i class="icon-phone"></i>
                    Got Question? Call us 24/7
                    <a href="tel:#">+962770245060</a>
                  </div>
                  <!-- End .widget-call -->
                </div>
                <!-- End .widget about-widget -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                <div class="widget">
                  <h4 class="widget-title">Useful Links</h4>
                  <!-- End .widget-title -->

                  <ul class="widget-list">
                    <li><a href="pages/about.html">About Us</a></li>
                    <li><a href="pages/faq.html">FAQ</a></li>
                    <li><a href="pages/contact.html">Contact Us</a></li>
                    <li><a href="#signin-modal" data-toggle="modal">Sign Up</a></li>
                  </ul>
                  <!-- End .widget-list -->
                </div>
                <!-- End .widget -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->

             

              <div class="col-sm-6 col-lg-3">
                <div class="widget">
                  <h4 class="widget-title">My Account</h4>
                  <!-- End .widget-title -->

                  <ul class="widget-list">
                    <li><a href="#signin-modal" data-toggle="modal">Sign In</a></li>
                    <li><a href="pages/cart.php">Cart</a></li>
                    <li><a href="pages/wishlist.html">My Wishlist</a></li>
                  </ul>
                  <!-- End .widget-list -->
                </div>
                <!-- End .widget -->
              </div>
              <!-- End .col-sm-6 col-lg-3 -->
            </div>
            <!-- End .row -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .footer-middle -->

        <div class="footer-bottom">
          <div class="container">
            <p class="footer-copyright">
            Copyright © 2022 Molla Store. All Rights Reserved.
            </p>
            <!-- End .footer-copyright -->
            <figure class="footer-payments">
              <img
                src="assets/images/payments.png"
                alt="Payment methods"
                width="272"
                height="20"
              />
            </figure>
            <!-- End .footer-payments -->
          </div>
          <!-- End .container -->
        </div>
        <!-- End .footer-bottom -->
      </footer>
      <!-- End .footer -->
    </div>
    <!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top">
      <i class="icon-arrow-up"></i>
    </button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container mobile-menu-light">
      <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="#" method="get" class="mobile-search">
          <label for="mobile-search" class="sr-only">Search</label>
          <input
            type="search"
            class="form-control"
            name="mobile-search"
            id="mobile-search"
            placeholder="Search in..."
            required
          />
          <button class="btn btn-primary" type="submit">
            <i class="icon-search"></i>
          </button>
        </form>

        <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="mobile-menu-link"
              data-toggle="tab"
              href="#mobile-menu-tab"
              role="tab"
              aria-controls="mobile-menu-tab"
              aria-selected="true"
              >Menu</a
            >
          </li>
         
        </ul>

        <div class="tab-content">
          <div
            class="tab-pane fade show active"
            id="mobile-menu-tab"
            role="tabpanel"
            aria-labelledby="mobile-menu-link"
          >
            <nav class="mobile-nav">
              <ul class="mobile-menu">
                <li class="active">
                  <a href="index.php">Home</a>

                  
                </li>
                <li>
                  <a href="pages/category-list.php">Shop</a>
                  
                </li>
                <li>
                  <a href="pages/cart.php">Cart</a>
                  
                </li>
                <li>
                  <a href="pages/checkout.php">Checkout</a>
                  
                </li>
                <li>
                  <a href="pages/dashboard.php">My Account</a>

                  
                </li>
                
              </ul>
            </nav>
            <!-- End .mobile-nav -->
          </div>
          <!-- .End .tab-pane -->
          <div
            class="tab-pane fade"
            id="mobile-cats-tab"
            role="tabpanel"
            aria-labelledby="mobile-cats-link"
          >
            
            <!-- End .mobile-cats-nav -->
          </div>
          <!-- .End .tab-pane -->
        </div>
        <!-- End .tab-content -->

        <div class="social-icons">
        <a href="https://web.facebook.com/" class="social-icon" target="_blank" title="Facebook"
            ><i class="icon-facebook-f"></i
          ></a>
          <a href="https://twitter.com/" class="social-icon" target="_blank" title="Twitter"
            ><i class="icon-twitter"></i
          ></a>
          <a href="https://www.instagram.com/" class="social-icon" target="_blank" title="Instagram"
            ><i class="icon-instagram"></i
          ></a>
          <a href="https://www.youtube.com/" class="social-icon" target="_blank" title="Youtube"
            ><i class="icon-youtube"></i
          ></a>
        </div>
        <!-- End .social-icons -->
      </div>
      <!-- End .mobile-menu-wrapper -->
    </div>
    <!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
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
                                        <?php include('./admin/config/errors.php'); ?>
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
                                        <?php include('admin/config/errors.php'); ?>
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
    </div><!-- End .modal -->

    
    </div>
    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-4.js"></script>
  </body>

  <!-- molla/index-4.html  22 Nov 2019 09:54:18 GMT -->
</html>
