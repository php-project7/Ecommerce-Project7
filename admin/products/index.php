<?php
include('../../admin/config/server.php');

if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$sql = "SELECT * FROM products";
//pdo
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../layout/header.php' ?>

        <div class="container pt-5 mt-5">
            <div class="row mb-4">
                <div class="col-md-12 mb-4">
                    <div class="overview-wrap">
                        <h2 class="title-1">Products</h2>
                        <a href="create_product.php" class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-plus"></i>Add new product</a>
                    </div>
                </div>
            </div>
            <?php if (count($products) == 0) : ?>
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 text-center py-5">
                        <div class="alert alert-danger py-5 text-uppercase">
                            <h4>No products found</h4>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($products as $product){?>
                        <div class="col-md-3">
                            <div class="card">
                                <img class="card-img-top" style="height: 350px"  src="<?php echo $product['img']?>" alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title mb-3"><?php echo $product['name']?>
                                        <p>
                                            <a href="edit_product.php?id=<?=$product['id']?>" class="edit"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="delete_product.php?id=<?=$product['id']?>" class="delete"><i class="fas fa-trash-alt"></i></a>
                                        </p>
                                    </h4>
                                    <p class="card-text">
                                    <h3 class="text-danger"><?php echo $product['price']?></h3>
                                    </p>
                                    <p class="card-text"><?php echo $product['description']?></p>
                                    <?php
                                    foreach($categories as $category){
                                        if($category['id'] === $product['category_id']){
                                            echo '<span class="badge badge-secondary">'.$category['name'].'</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../layout/footer.php' ?>
