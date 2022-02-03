<?php
include('../../admin/config/server.php');


if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = '';
$edit_products_errors = array();

if (isset($_GET['id'])){
    if (!empty($_POST)){
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : NULL;
        $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
        $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
        $product_desc = isset($_POST['product_desc']) ? $_POST['product_desc'] : '';

        $product_img = isset($_POST['product_img']) ? $_POST['product_img'] : '';
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
        $product_discount = isset($_POST['product_discount']) ? $_POST['product_discount'] : 0;

        $product_in_stock = isset($_POST['product_in_stock']) ? $_POST['product_in_stock'] : 0;

        if (empty($product_id)) {
            $edit_products_errors['product_id'] = "Product ID is required";
        }
        if (empty($product_name)) {
            $edit_products_errors['product_name'] = "Product Name is required";
        }
        if (empty($product_price)) {
            $edit_products_errors['product_price'] = "Product Price is required";
        }
        if (empty($product_discount)) {
            $edit_products_errors['product_discount'] = "Product Discount is required";
        }
        if (empty($product_in_stock)) {
            $edit_products_errors['product_in_stock'] = "Product In Stock is required";
        }
        if (empty($category_id)) {
            $edit_products_errors['category_id'] = "Category ID is required";
        }


        // if no errors
        if (empty($edit_products_errors)) {

            // update product using pdo prepared statement
            $sql = "UPDATE products SET name = :product_name, price = :product_price, description = :product_desc, img = :product_img, category_id = :category_id, discount = :product_discount, stock = :product_in_stock WHERE id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':product_price', $product_price);
            $stmt->bindParam(':product_desc', $product_desc);
            $stmt->bindParam(':product_img', $product_img);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':product_discount', $product_discount);
            $stmt->bindParam(':product_in_stock', $product_in_stock);
            $stmt->execute();

            $msg = "Product updated successfully";

            // redirect to products page
            header('location: ../../admin/products/');
        }
        else {
            $msg = "Error updating product";
        }
    }
      $sql = "SELECT * FROM products WHERE id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $_GET['id']);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($product)) {
        $msg = "Product not found";
    }

    // get categories from database
    $sql = "SELECT * FROM categories";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

else {
    header('location: ../../admin/products/');
}
?>
<?php include '../layout/header.php' ?>

        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            Update Product #<?=$product['id']?>
                        </div>
                        <div class="card-body card-block">
                            <form action="edit_product.php?id=<?=$product['id']?>" method= "post" class="">
                                <?php
                                foreach($edit_products_errors as $error){
                                    echo "<p class='alert w-50 alert-danger'>$error</p>";
                                }
                                ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input hidden class="ml-2" type="text" name="product_id" placeholder="26" value="<?=$product['id']?>" readonly>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" id="product_name" name="product_name" value="<?=$product['name']?>" placeholder="Enter product name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="number" id="product_price" name="product_price" value="<?=$product['price']?>" placeholder="Enter Product Price" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                        <input type="text" id="product_discount" name="product_discount" <?=$product['discount']?> placeholder="Add Discount For Product" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-asterisk"></i>
                                        </div>
                                        <input type="text" id="product_desc" name="product_desc" placeholder="Enter product description" value="<?=$product['description']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <input type="text" id="product_in_stock" name="product_in_stock" placeholder="How many products in stock? " value="<?=$product['stock']?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-image"></i>
                                        </div>
                                        <input type="text" id="product_img" name="product_img" placeholder="Enter IMG URL" class="form-control" value="<?= $product['img']?>">
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
                                            foreach($categories as $category){
                                                if($category['id'] == $product['category_id']){
                                                    echo "<option value='{$category['id']}' selected>{$category['name']}</option>";
                                                }else{
                                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </div>
                            </form>
                            <?php if (empty($edit_products_errors)): ?>
                                <p class="alert alert-success"><?=$msg?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php' ?>
