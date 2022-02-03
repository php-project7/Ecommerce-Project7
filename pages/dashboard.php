<?php
require("../admin/config/connection.php");

$dashboard_errors = array();

//check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['email'], $_SESSION['name'], $_SESSION['Role'], $_SESSION['id']);
    session_destroy();
    header("Location: ../login.php");
}

if ($_SESSION['id'] == 0) {
    header("Location: ../index.php");
}

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
//pdo
$result = $pdo->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$user_name = $row['name'];
$user_email = $row['email'];
$user_password = $row['password'];



if (isset($_POST['submit_save'])) {
    //get the data from the form
    $name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    //validate the data
    if (empty($name)) {
        $dashboard_errors['name'] = "Name is required";
    }
    if (empty($email)) {
        $dashboard_errors['email'] = "Email is required";
    }
    if (empty($password)) {
        $dashboard_errors['password'] = "Password is required";
    }

    if (!empty($new_password) && !empty($confirm_password)) {
        if ($new_password !== $confirm_password) {
            $dashboard_errors[] = "Passwords do not match";
        }
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
    if (count($result) > 0) {
        $dashboard_errors['email'] = 'Email already exist';
    }

    echo '<pre>';
    print_r($dashboard_errors);
    echo '</pre>';



    // check if his current password is correct then update the data
    if (empty($dashboard_errors)) {
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        //check if the password is correct and if the user needs to change the password
        if ($row['password'] === $password) {
            if (!empty($new_password)) {
                $new_password = md5($new_password);
                $sql = "UPDATE users SET name = '$name', email = '$email', password = '$new_password' WHERE id = $user_id";
            } else {
                $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $user_id";
            }
            //pdo
            $result = $pdo->query($sql);
            if ($result) {
                header("Location: dashboard.php");
            }
        } else {
            $dashboard_errors[] = "Current password is incorrect";
        }
    }
}

//get checkout data from table items_checkout and join it with orders table depending on logged in user



?>

<?php include("../components/NavBar.php"); ?>

    <main class="main">
        <div class="page-header text-center" style="background-image: url('../assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">My Account<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="./category-list.php">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        <aside class="col-md-4 col-lg-3">
                            <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab"
                                       href="#tab-dashboard" role="tab" aria-controls="tab-dashboard"
                                       aria-selected="true">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab"
                                       aria-controls="tab-orders" aria-selected="false">Orders</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account"
                                       role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="?logout=1">
                                        <i class="zmdi zmdi-power"></i>Sign Out
                                    </a>


                                </li>
                            </ul>
                        </aside><!-- End .col-lg-3 -->

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel"
                                     aria-labelledby="tab-dashboard-link">
                                    <p>Hello <span class="font-weight-normal text-dark"><?= $user_name  ?></span> (not <span
                                                class="font-weight-normal text-dark">User</span>? <a href="?logout=1">
                                            <i class="zmdi zmdi-power"></i>Logout</a>

                                        )
                                        <br>
                                        From your account dashboard you can view your <a href="#tab-orders"
                                                                                         class="tab-trigger-link link-underline">recent orders</a>, manage your <a
                                                href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>,
                                        and <a href="#tab-account" class="tab-trigger-link">edit your password and account
                                            details</a>.
                                    </p>
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-orders" role="tabpanel"
                                     aria-labelledby="tab-orders-link">
                                    <?php
                                    $sql = "SELECT * FROM items_checkout JOIN orders ON items_checkout.orders_id = orders.id WHERE orders.user_id = $user_id";
                                    $stmt = $pdo->query($sql);
                                    $result = $stmt->fetchAll();
                                    ?>
                                    <div class="table-responsive">
                                        <?php if (empty($result)) { ?>
                                            <div class="alert alert-info" role="alert">
                                                <strong>No orders found!</strong>
                                            </div>
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
                                </div><!-- .End .tab-pane -->




                                <div class="tab-pane fade" id="tab-address" role="tabpanel"
                                     aria-labelledby="tab-address-link">
                                    <p>The following addresses will be used on the checkout page by default.</p>

                                    <div class="row">

                                    </div><!-- End .row -->
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-account" role="tabpanel"
                                     aria-labelledby="tab-account-link">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <?php
                                        //show error message
                                        foreach ($dashboard_errors as $error) {
                                            echo '<div class="alert alert-danger" role="alert">
                                            <strong>Oh snap!</strong> ' . $error . '
                                            </div>';
                                        }
                                        ?>
                                        <label>Display Name *</label>
                                        <input type="text" class="form-control" value="<?= $user_name ?>" name="user_name">
                                        <small class="form-text">This will be how your name will be displayed in the account
                                            section and in reviews</small>
                                        <label>Email address *</label>
                                        <input type="email" class="form-control" value="<?= $user_email ?>"
                                               name="user_email" placeholderrequired>

                                        <label>Current password</label>
                                        <input type="password" class="form-control" name="user_password">

                                        <label>New password (leave blank to leave unchanged)</label>
                                        <input type="password" class="form-control" name="new_password">

                                        <label>Confirm new password (leave blank to leave unchanged)</label>
                                        <input type="password" class="form-control mb-2" name="confirm_password">

                                        <button type="submit" class="btn btn-outline-primary-2" name="submit_save">
                                            <span>SAVE CHANGES</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

<?php include("../components/Footer.php"); ?>