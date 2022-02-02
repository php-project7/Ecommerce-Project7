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
<main class="main"
    style="background: white; width: 80vw; display:flex; justify-content:center; align-items:center; margin:0 auto; height:70vh; ">
    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="<?= $product["img"] ?>"
                                        data-zoom-image="assets/images/products/single/1-big.jpg" alt="product image">
                                </figure><!-- End .product-main-image -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6" style="padding:9em 0 0 0;">
                        <div class="product-details">
                            <h1 class="product-title"><?= $product["name"] ?></h1><!-- End .product-title -->

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
                                        <input type="number" id="qty" class="form-control" name="submittedQuantity"
                                            value="1" min="1" max="<?php echo $productStock; ?>" step="1"
                                            data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">
                                    <?php //handle to check if number of product stock is 0
                                    if ($product['stock'] == 0) { ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" disabled>
                                        <span>Out of stock</span>
                                    </button>
                                    <?php } elseif ($_SESSION['id'] != 0) { ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" name="submitAddToCart"
                                        value="<?= $product['id'] ?>">
                                        <span>Add to cart</span>
                                    </button>
                                    <?php } else { ?>
                                    <a href="../pages/login.php" class="btn btn-outline-primary-2"><span>Login to
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

        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Sticky Bar -->