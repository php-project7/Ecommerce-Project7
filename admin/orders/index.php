
<?php
include('../../admin/config/server.php');


if (($_SESSION['Role']) != 1 || $_SESSION['Role'] != 2) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}
?>



<?php include '../layout/header.php'; ?>

<div class="container pt-5 mt-5">
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="overview-wrap">
                <h2 class="title-1">Orders</h2>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT * FROM orders";
    //pdo
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>

    <?php
    //if now orders
    if (count($result) == 0) {
        echo "<h3>No orders</h3>";
        ?>
          <?php } else { ?>
             <div class="table-responsive">
                                        <table
                                            class="table table-hover table-sm table-striped table-bordered table-orders">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Country</th>
                                                    <th>Street address</th>
                                                    <th>Post Code</th>
                                                    <th>Phone</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $order) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="order-details.php?id=<?= $order['id'] ?>">
                                                            <?= $order['id'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $order['first_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['last_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['email'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['country'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['street_address'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['post_code'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['phone'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $order['total'] ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


<?php include '../layout/footer.php' ?>



