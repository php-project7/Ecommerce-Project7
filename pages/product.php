<?php
include('../admin/config/server.php');
if (!isset($_GET["id"])) {
    header("location:../index.php");
}
$productId = $_GET["id"];
if (isset($_POST["submitAddToCart"])) {
    $submittedQuantity = $_POST["submittedQuantity"];
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
            $count += $submittedQuantity;

            $insert_product1 = $pdo->prepare("UPDATE tempcart SET quantity='$count' WHERE id='$product[id]' AND product_id='$data[id]' AND user_id='$logged_user'");
            $insert_product1->execute();
        } else {
            $insert_product = $pdo->prepare("INSERT INTO tempcart (product_id,user_id,img,name,price,quantity,discount, final_price)
  VALUES('$data[id]','$logged_user', '$data[img]','$data[name]','$data[price]','1','$data[discount]', '1')");
            $insert_product->execute();
        }
    } else {
        header('location:login.php');
        exit();
    }
}






$query = "SELECT * FROM products WHERE id=$productId";
$statement = $pdo->query($query);
//fetch  the product
$product = $statement->fetch();
$catId = $product["category_id"];
$productId = $product["id"];
$productStock = $product["stock"];

// -----------------
$sql = "SELECT * FROM categories WHERE id=$catId";
$stmt = $pdo->query($sql);
$category = $stmt->fetch(PDO::FETCH_ASSOC);
$categoryName = ($category["name"]);
// -----------------

if (isset($_POST["submitNewReview"])) {

    $userId = $_SESSION['id'];
    $reviewContent = $_POST["reviewContent"];
    $sql = "INSERT INTO reviews (product_id ,user_id ,review)VALUES( '$productId','$userId','$reviewContent')";
    $stmt = $pdo->query($sql);
}
// -----------------
$sql = "SELECT * FROM reviews WHERE product_id=$productId";
$stmt = $pdo->query($sql);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);





?>
<?php include("../components/NavBar.php"); ?>

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Default</li>
            </ol>

        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="<?= $product["img"] ?>" data-zoom-image="assets/images/products/single/1-big.jpg" alt="product image">
                                </figure><!-- End .product-main-image -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title"><?= $product["name"] ?></h1><!-- End .product-title -->

                            <div class="ratings-container">

                                <a class="ratings-text" href="#product-review-link" id="review-link">(
                                    <?= count($reviews) ?> Reviews )</a>
                            </div><!-- End .rating-container -->

                            <div class="product-price">
                                $<?= $product["price"] ?>
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <p><?= $product["description"] ?></p>
                            </div><!-- End .product-content -->
                            <form method="post" action='product.php?id=<?= $product['id'] ?>'>
                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" name="submittedQuantity" value="1" min="1" max="<?php echo $productStock; ?>" step="1" data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">
                                    <?php //handle to check if number of product stock is 0
                                    if ($product['stock'] == 0) { ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" disabled>
                                            <span>Out of stock</span>
                                        </button>
                                    <?php } elseif ($_SESSION['id'] != 0) { ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" name="submitAddToCart" value="<?= $product['id'] ?>">
                                            <span>Add to cart</span>
                                        </button>
                                    <?php } else { ?>
                                        <a href="login.php" class="btn btn-outline-primary-2"><span>Login to
                                                purchase</span><i class="icon-long-arrow-right"></i></a>
                                    <?php } ?>

                                </div><!-- End .product-details-action -->
                            </form>



                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#"><?= $category["name"] ?></a>

                                </div><!-- End .product-cat -->


                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews
                            (<?= count($reviews) ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade " id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            <p><?= $product["description"] ?></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade show active" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                        <div class="reviews">
                            <h3>Reviews (<?= count($reviews) ?>)</h3>

                            <?php
                            for ($i = 0; $i <  count($reviews); $i++) {
                                $reviewUserId = $reviews[$i]["user_id"];
                                $sql = "SELECT * FROM users WHERE id=$reviewUserId";
                                $stmt = $pdo->query($sql);
                                $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);
                                $username = ($userRecord["name"]);
                            ?>
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#"><?= $username ?></a></h4>
                                        </div><!-- End .col -->
                                        <div class="col">
                                            <div class="review-content mt-3">
                                                <p><?= $reviews[$i]["review"] ?></p>
                                            </div><!-- End .review-content -->
                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div><!-- End .review -->
                            <?php
                            }
                            ?>



                        </div><!-- End .reviews -->
                        <?php
                        if (isset($_SESSION['id'])) {
                            if ($_SESSION['id'] != 0) {
                        ?>
                                <form action='product.php?id=<?= $product['id'] ?>' method="post">
                                    <br>
                                    <label>Add New Review</label>
                                    <input type="text" class="form-control" name="reviewContent" required>
                                    <button type="submit" class="btn btn-outline-primary-2" name="submitNewReview">
                                        <span>Add</span>
                                    </button>
                                </form>
                        <?php
                            }
                        }
                        ?>
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

<?php include("../components/Footer.php"); ?>

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Sticky Bar -->
<div class="sticky-bar">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <figure class="product-media">
                    <a href="product.php">
                        <img src="<?= $product["img"] ?>" alt="Product image">
                    </a>
                </figure><!-- End .product-media -->
                <h4 class="product-title"><a href="product.php"><?= $product["name"] ?></a></h4>
                <!-- End .product-title -->
            </div><!-- End .col-6 -->

            <div class="col-6 justify-content-end">
                <div class="product-price">
                    $<?= $product["price"] ?>
                </div><!-- End .product-price -->
                <div class="product-details-quantity">
                    <input type="number" id="sticky-cart-qty" class="form-control" value="1" min="1" max="<?php echo $productStock; ?>" step="1" data-decimals="0" required>
                </div><!-- End .product-details-quantity -->

                <div class="product-details-action">
                    <?php //handle to check if number of product stock is 0
                    if ($product['stock'] == 0) { ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger" disabled>
                            <span>Out of stock</span>
                        </button>
                    <?php } else { ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger" name="submitAddToCart" value="<?= $product['id'] ?>">
                            <span>Add to cart</span>
                        </button>
                    <?php } ?>
                </div><!-- End .product-details-action -->
            </div><!-- End .col-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div><!-- End .sticky-bar -->