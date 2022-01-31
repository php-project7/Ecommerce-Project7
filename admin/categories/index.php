<?php

include('../../admin/config/server.php');


if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$sql = $pdo->prepare('SELECT * FROM categories ORDER BY id');
$sql->execute();
$categories = $sql->fetchAll(PDO::FETCH_ASSOC);
?>



<?php include '../layout/header.php' ?>

        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">

                    <h2 class="title-1 m-b-25">All Categories</h2>
                    <div class="overview-wrap mb-4">
                        <a href="../categories/create_category.php" class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-plus"></i>Add Category</a>
                    </div>
                    <div class="table-responsive table--no-card m-b-40">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Edit/Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($categories as $category): ?>
                                <tr>
                                    <td><?=$category['id']?></td>
                                    <td><?=$category['name']?></td>
                                    <td><?=$category['description']?></td>

                                    <td class="actions">
                                        <a href="../categories/edit_category.php?id=<?=$category['id']?>" class="edit"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="../categories/delete_category.php?id=<?=$category['id']?>" class="trash text-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../layout/footer.php' ?>



