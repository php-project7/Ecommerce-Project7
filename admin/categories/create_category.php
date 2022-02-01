<?php
include('../../admin/config/server.php');

if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = "";
$create_category_errors = array();
if (!empty($_POST)) {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (empty($category_name)) {
        $create_category_errors['$category_name'] = "Category Name is required";
    }
    if (empty($category_description)) {
        $create_category_errors['$category_description'] = "Category Description is required";
    }

//    handle if product id already exists
    $sql = "SELECT * FROM categories WHERE name = '$category_name'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $create_category_errors['$category_name'] = "Category Name already exists";
    }

    // if no errors then insert into database using PDO
    if (empty($create_category_errors)) {
        $sql = "INSERT INTO categories (name, description) VALUES ('$category_name', '$category_description')";
        $stmt = $pdo->query($sql);
        $msg = "Category added successfully";
    }
    else {
        $msg = "Error adding Category";
    }
}

?>
<?php include '../layout/header.php' ?>

        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">CREATE NEW CATEGORY</div>
                        <div class="card-body card-block">
                            <form action="create_category.php" method= "post" class="">
                                <?php
                                foreach($create_category_errors as $error){
                                    echo "<p class='alert w-50 alert-danger'>$error</p>";
                                }
                                ?>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="text" id="category_name" name="category_name" placeholder="Add Category name" class="form-control">
                                    </div>
                                </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <input type="text" id="category_description" name="category_description" placeholder="Add Category Description" class="form-control">
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


