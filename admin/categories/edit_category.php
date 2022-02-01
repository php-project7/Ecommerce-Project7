<?php
include('../../admin/config/server.php');


if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = '';
$edit_category_errors = array();

if (isset($_GET['id'])){
    if (!empty($_POST)){
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : NULL;
        $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : NULL;
        $category_description = isset($_POST['category_description']) ? $_POST['category_description'] : NULL;

        if (empty($category_name)) {
            $edit_category_errors['$category_name'] = "Category Name is required";
        }
        if (empty($category_description)) {
            $edit_category_errors['$category_description'] = "Category Description is required";
        }

        // if no errors
        if (empty($edit_category_errors)) {

            // update product using pdo prepared statement
            $sql = "UPDATE categories SET name = :category_name, description = :category_description WHERE id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category_name', $category_name);
            $stmt->bindParam(':category_description', $category_description);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();

            $msg = "Category updated successfully";

            // redirect to products page
            header('location: ../categories/');
        }
        else {
            $msg = "Error updating product";
        }
    }
    $sql = "SELECT * FROM categories WHERE id = :category_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category_id', $_GET['id']);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($category)) {
        $msg = "Product not found";
    }

    // get categories from database
    $sql = "SELECT * FROM categories";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

else {
    header('location: ../admin/products/');
}
?>
<?php include '../layout/header.php' ?>

<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    Update Product #<?=$category['id']?>
                </div>
                <div class="card-body card-block">
                    <form action="edit_category.php?id=<?=$category['id']?>" method= "post" class="">
                        <?php
                        foreach($edit_category_errors as $error){
                            echo "<p class='alert w-50 alert-danger'>$error</p>";
                        }
                        ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-sort-numeric-asc"></i>
                                </div>
                                <input class="ml-2" type="text" name="category_id" placeholder="26" value="<?=$category['id']?>" readonly>
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" id="product_name" name="category_name" value="<?=$category['name']?>" placeholder="Enter Category name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-asterisk"></i>
                                </div>
                                <input type="text" id="product_desc" name="category_description" placeholder="Enter Category description" value="<?=$category['description']?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-actions form-group">
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                    <?php if (empty($edit_category_errors)): ?>
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
