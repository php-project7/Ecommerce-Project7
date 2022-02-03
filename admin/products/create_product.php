<?php
include('../../admin/config/server.php');


if (($_SESSION['Role']) != 1 || $_SESSION['Role'] != 2) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}


$msg = "";
$create_product_errors = array();
if (!empty($_POST)) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_img = $_POST['product_img'];
    $product_discount = $_POST['product_discount'];
    $category_id = $_POST['category_id'];
    $product_in_stock = $_POST['product_in_stock'];

    if (empty($product_name)) {
        $create_product_errors['product_name'] = "Product name is required";
    }
    if (empty($product_price)) {
        $create_product_errors['product_price'] = "Product price is required";
    }
    if (empty($product_desc)) {
        $create_product_errors['product_desc'] = "Product description is required";
    }
    if (empty($product_img)) {
        $create_product_errors['product_img'] = "Product image is required";
    }
    if (empty($category_id)) {
        $create_product_errors['category_id'] = "Category is required";
    }
    if (empty($product_in_stock)) {
        $create_product_errors['product_in_stock'] = "Product in stock is required";
    }

    // if no errors then insert into database using PDO
    if (empty($create_product_errors)) {
        $sql = "INSERT INTO products (name, price, stock,discount, description, category_id, img) 
        VALUES (:product_name, :product_price, :product_in_stock, :product_discount, :product_desc, :category_id, :product_img)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_in_stock', $product_in_stock);
        $stmt->bindParam(':product_discount', $product_discount);
        $stmt->bindParam(':product_desc', $product_desc);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':product_img', $product_img);
        $stmt->execute();
        $msg = "Product added successfully";
    }
    else {
        $msg = "Error adding product";
    }
}

?>
<?php include '../layout/header.php' ?>

        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">CREATE NEW PRODUCT</div>
                        <div class="card-body card-block">
                            <form action="create_product.php" method= "post" class="">
                                <?php
                                foreach($create_product_errors as $error){
                                    echo "<p class='alert w-50 alert-danger'>$error</p>";
                                }
                                ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" id="product" name="product_name" placeholder="Add Product Name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="text" id="product_price" name="product_price" placeholder="Add Product Price" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="far fa-file-alt"></i>
                                        </div>
                                        <input type="text" id="product_desc" name="product_desc" placeholder="Add Product Description" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-image"></i>
                                        </div>
                                        <input type="text" id="product_image" name="product_img" placeholder="Add Product Image" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                        <input type="text" id="product_discount" name="product_discount" placeholder="Add Discount For Product" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <input type="text" id="product_in_stock" name="product_in_stock" placeholder="How many products in stock? " class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-sort-numeric-down"></i>
                                        </div>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php
                                            $query = "SELECT * FROM categories";
                                            $result = $pdo->query($query);
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $category_id = $row['id'];
                                                $category_name = $row['name'];
                                            ?>
                                            <option value="<?=$category_id?>"><?=$category_name?></option>;
                                           <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                </div>
                            </form>
                            <?php if ($msg): ?>
                                <p><?=$msg?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php' ?>
