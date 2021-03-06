<?php
include('../admin/config/server.php');

//show all products in products table in database
$query = "SELECT * FROM products";
//pdo statement
$statement = $pdo->query($query);
//execute the query
//fetch all the products
$products = $statement->fetchAll();

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


/**************************************************** */
if (isset($_POST["submitAddToCart"])) {
    $productId = $_POST["submitAddToCart"];
    if (isset($_SESSION['id'])) {
        $value = $productId;
        $sql1 = $pdo->prepare("SELECT * FROM products WHERE id='$value'");
        $sql1->execute();
        $data = $sql1->fetch(PDO::FETCH_ASSOC);
        $logged_user = $_SESSION['id'];

        $product_check_query = "SELECT * FROM tempcart WHERE product_id='$value' AND user_id='$logged_user' LIMIT 1";
        $stmt1 = $pdo->prepare($product_check_query);
        $stmt1->execute();
        $product = $stmt1->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            $count = $product['quantity'];
            $count++;

            $insert_product1 = $pdo->prepare("UPDATE tempcart SET quantity='$count' WHERE id='$product[id]' AND product_id='$data[id]' AND user_id='$logged_user'");
            $insert_product1->execute();
        } else {
            $insert_product = $pdo->prepare("INSERT INTO tempcart (product_id,user_id,img,name,price,quantity,discount,final_price)
  VALUES('$data[id]','$logged_user', '$data[img]','$data[name]','$data[price]','1','$data[discount]', '1')");
            $insert_product->execute();
        }
    } else {
        header('location:login.php');
        exit();
    }
}

if (isset($_GET['filter'])) {
    $filter = $_GET['sort'];
    //sort by price from low to high or high to low
    if ($filter == 'price-asc') {
        $sql = "SELECT * FROM products ORDER BY price ASC";
    } elseif ($filter == 'price-desc') {
        $sql = "SELECT * FROM products ORDER BY price DESC";
    }
    //sort by default
    else {
        $sql = "SELECT * FROM products";
    }
    //pdo
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
}

$errors = array();

//handle search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
}
?>


<?php include('../components/NavBar.php'); ?>
<div class="page-wrapper">
    <main class="main">
        <div class="page-header text-center" style="background-image: url('../assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">List<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="toolbox">
                            <div class="toolbox-left">
                            </div><!-- End .toolbox-left -->

                            <form class="toolbox-right" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="toolbox-sort">
                                    <label for="sort">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sort" id="sort" class="form-control">
                                            <option value="">Default</option>
                                            <option value="price-asc">Price: Low to High</option>
                                            <option value="price-desc">Price: High to Low</option>
                                        </select>
                                    </div>
                                </div><!-- End .toolbox-sort -->
                                <button type="submit" class="btn ml-2 btn-sm btn-outline-danger" name="filter">
                                    <span>Sort</span>
                                </button>
                            </form><!-- End .toolbox-right -->
                        </div><!-- End .toolbox -->

                        <?php if (empty($products)) { ?>
                        <div class="ml-3">
                            <h3>No products found</h3>
                        </div>
                        <?php } else { ?>
                        <?php foreach ($products as $product) {
                                $review_sql = "SELECT * FROM reviews WHERE product_id=$product[id]";
                                $review_stmt = $pdo->query($review_sql);
                                $review_review = $review_stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                        <div class="products mb-3">
                            <div class="product product-list">
                                <div class="row mb-3">
                                    <div class="col-6 col-lg-3">
                                        <figure class="product-media">
                                            <span class="product-label label-new">New</span>
                                            <a href="product.php?id=<?= $product['id'] ?>">
                                                <img src="<?= $product['img'] ?>" alt="Product image"
                                                    class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->
                                    </div><!-- End .col-sm-6 col-lg-3 -->

                                    <div class="col-6 col-lg-3 order-lg-last">
                                        <div class="product-list-action">
                                            <div class="product-price">
                                                $<?= $product['price'] ?>
                                            </div><!-- End .product-price -->
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 20%;"></div>
                                                    <!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                                <span class="ratings-text">( <?= count($review_review) ?> Reviews
                                                    )</span>

                                            </div><!-- End .rating-container -->
                                            <span>
                                                <?php
                                                //get how many in stock of this product
                                                $sql = "SELECT * FROM products WHERE id = :product_id";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute(['product_id' => $product['id']]);
                                                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $in_stock = $product['stock'];
                                                ?>
                                                <span class=" badge badge-success">
                                        <?php echo $in_stock?> in stock
                                            </span>



                                            <form class="mt-2" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                                                <div class="product-details-action">
                                                    <?php //handle to check if number of product stock is 0
                                                            if ($product['stock'] == 0) { ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        disabled>
                                                        <span>Out of stock</span>
                                                    </button>
                                                    <?php } elseif ($_SESSION['id'] != 0) { ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        name="submitAddToCart" value="<?= $product['id'] ?>">
                                                        <span>Add to cart</span>
                                                    </button>
                                                    <?php } else { ?>
                                                    <a href="../login.php" class="btn btn-outline-primary-2"><span>Login
                                                            to
                                                            purchase</span><i class="icon-long-arrow-right"></i></a>
                                                    <?php } ?>
                                                </div><!-- End .product-details-action -->
                                            </form>

                                        </div><!-- End .product-list-action -->
                                    </div><!-- End .col-sm-6 col-lg-3 -->

                                    <div class="col-lg-6">
                                        <div class="product-body product-action-inner">
                                            <a href="#" class="btn-product btn-wishlist"
                                                title="Add to wishlist"><span>add to wishlist</span></a>
                                            <div class="product-cat">
                                                <?php
                                                        foreach ($categories as $category) {
                                                            if ($category['id'] === $product['category_id']) {
                                                                echo '<a href="#">' . $category['name'] . '</a>';
                                                            }
                                                        }
                                                        ?>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="product.php?id=<?= $product['id'] ?>">
                                                    <?= $product['name'] ?></a></h3><!-- End .product-title -->

                                            <div class="product-content">
                                                <p> <?= $product['description'] ?></p>
                                            </div><!-- End .product-content -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                                <?php } ?>
                                <?php } ?>
                            </div><!-- End .row -->
                        </div><!-- End .container -->
                    </div><!-- End .page-content -->
    </main><!-- End .main -->

    <?php include('../components/Footer.php'); ?>
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="#" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..."
                required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active">
                    <a href="index.html">Home</a>

                    <ul>
                        <li><a href="index-1.html">01 - furniture store</a></li>
                        <li><a href="index-2.html">02 - furniture store</a></li>
                        <li><a href="index-3.html">03 - electronic store</a></li>
                        <li><a href="../index-4.html">04 - electronic store</a></li>
                        <li><a href="index-5.html">05 - fashion store</a></li>
                        <li><a href="index-6.html">06 - fashion store</a></li>
                        <li><a href="index-7.html">07 - fashion store</a></li>
                        <li><a href="index-8.html">08 - fashion store</a></li>
                        <li><a href="index-9.html">09 - fashion store</a></li>
                        <li><a href="index-10.html">10 - shoes store</a></li>
                        <li><a href="index-11.html">11 - furniture simple store</a></li>
                        <li><a href="index-12.html">12 - fashion simple store</a></li>
                        <li><a href="index-13.html">13 - market</a></li>
                        <li><a href="index-14.html">14 - market fullwidth</a></li>
                        <li><a href="index-15.html">15 - lookbook 1</a></li>
                        <li><a href="index-16.html">16 - lookbook 2</a></li>
                        <li><a href="index-17.html">17 - fashion store</a></li>
                        <li><a href="index-18.html">18 - fashion store (with sidebar)</a></li>
                        <li><a href="index-19.html">19 - games store</a></li>
                        <li><a href="index-20.html">20 - book store</a></li>
                        <li><a href="index-21.html">21 - sport store</a></li>
                        <li><a href="index-22.html">22 - tools store</a></li>
                        <li><a href="index-23.html">23 - fashion left navigation store</a></li>
                        <li><a href="index-24.html">24 - extreme sport store</a></li>
                    </ul>
                </li>
                <li>
                    <a href="category.html">Shop</a>
                    <ul>
                        <li><a href="category-list.html">Shop List</a></li>
                        <li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
                        <li><a href="category.html">Shop Grid 3 Columns</a></li>
                        <li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
                        <li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span
                                        class="tip tip-hot">Hot</span></span></a></li>
                        <li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
                        <li><a href="product-category-boxed.html">Product Category Boxed</a></li>
                        <li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span
                                        class="tip tip-new">New</span></span></a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="wishlist.html">Wishlist</a></li>
                        <li><a href="#">Lookbook</a></li>
                    </ul>
                </li>
                <li>
                    <a href="product.html" class="sf-with-ul">Product</a>
                    <ul>
                        <li><a href="product.html">Default</a></li>
                        <li><a href="product-centered.html">Centered</a></li>
                        <li><a href="product-extended.html"><span>Extended Info<span
                                        class="tip tip-new">New</span></span></a></li>
                        <li><a href="product-gallery.html">Gallery</a></li>
                        <li><a href="product-sticky.html">Sticky Info</a></li>
                        <li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
                        <li><a href="product-fullwidth.html">Full Width</a></li>
                        <li><a href="product-masonry.html">Masonry Sticky Info</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Pages</a>
                    <ul>
                        <li>
                            <a href="about.html">About</a>

                            <ul>
                                <li><a href="about.html">About 01</a></li>
                                <li><a href="about-2.html">About 02</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="contact.html">Contact</a>

                            <ul>
                                <li><a href="contact.html">Contact 01</a></li>
                                <li><a href="contact-2.html">Contact 02</a></li>
                            </ul>
                        </li>
                        <li><a href="../login.html">Login</a></li>
                        <li><a href="faq.html">FAQs</a></li>
                        <li><a href="404.html">Error 404</a></li>
                        <li><a href="coming-soon.html">Coming Soon</a></li>
                    </ul>
                </li>
                <li>
                    <a href="blog.html">Blog</a>

                    <ul>
                        <li><a href="blog.html">Classic</a></li>
                        <li><a href="blog-listing.html">Listing</a></li>
                        <li>
                            <a href="#">Grid</a>
                            <ul>
                                <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Masonry</a>
                            <ul>
                                <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Mask</a>
                            <ul>
                                <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Single Post</a>
                            <ul>
                                <li><a href="single.html">Default with sidebar</a></li>
                                <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="elements-list.html">Elements</a>
                    <ul>
                        <li><a href="elements-products.html">Products</a></li>
                        <li><a href="elements-typography.html">Typography</a></li>
                        <li><a href="elements-titles.html">Titles</a></li>
                        <li><a href="elements-banners.html">Banners</a></li>
                        <li><a href="elements-product-category.html">Product Category</a></li>
                        <li><a href="elements-video-banners.html">Video Banners</a></li>
                        <li><a href="elements-buttons.html">Buttons</a></li>
                        <li><a href="elements-accordions.html">Accordions</a></li>
                        <li><a href="elements-tabs.html">Tabs</a></li>
                        <li><a href="elements-testimonials.html">Testimonials</a></li>
                        <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                        <li><a href="elements-portfolio.html">Portfolio</a></li>
                        <li><a href="elements-cta.html">Call to Action</a></li>
                        <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                    </ul>
                </li>
            </ul>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->

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
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                                    aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                                    aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                aria-labelledby="signin-tab">
                                <form action="#">
                                    <div class="form-group">
                                        <label for="singin-email">Username or email address *</label>
                                        <input type="text" class="form-control" id="singin-email" name="singin-email"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="singin-password">Password *</label>
                                        <input type="password" class="form-control" id="singin-password"
                                            name="singin-password" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Remember
                                                Me</label>
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
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form action="#">
                                    <div class="form-group">
                                        <label for="register-email">Your email address *</label>
                                        <input type="email" class="form-control" id="register-email"
                                            name="register-email" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-password">Password *</label>
                                        <input type="password" class="form-control" id="register-password"
                                            name="register-password" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="register-policy"
                                                required>
                                            <label class="custom-control-label" for="register-policy">I agree to the <a
                                                    href="#">privacy policy</a> *</label>
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

<!-- Plugins JS File -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/jquery.hoverIntent.min.js"></script>
<script src="../assets/js/jquery.waypoints.min.js"></script>
<script src="../assets/js/superfish.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/wNumb.js"></script>
<script src="../assets/js/bootstrap-input-spinner.js"></script>
<script src="../assets/js/jquery.magnific-popup.min.js"></script>
<script src="../assets/js/nouislider.min.js"></script>
<!-- Main JS File -->
<script src="../assets/js/main.js"></script>


<!-- molla/category-list.html  22 Nov 2019 10:02:52 GMT -->

</html>