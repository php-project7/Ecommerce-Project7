<?php
require("../admin/config/connection.php");

$errors = array();

//check if the user is logged in
if(!isset($_SESSION['id'])){
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



if(isset($_POST['submit_save'])){
    //get the data from the form
    $name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    //validate the data
    if(empty($name)){
        $errors['name'] = "Name is required";
    }
    if(empty($email)){
        $errors['email'] = "Email is required";
    }
    if(empty($password)){
        $errors['password'] = "Password is required";
    }

    if(!empty($new_password) && !empty($confirm_password)){
        if($new_password !== $confirm_password){
            $errors[] = "Passwords do not match";
        }
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
    if (count($result) > 0){
        $errors['email'] = 'Email already exist';
    }



    // check if his current password is correct then update the data
    if(empty($errors)){
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        //check if the password is correct and if the user needs to change the password
        if($row['password'] === $password){
            if(!empty($new_password)){
                $new_password = md5($new_password);
                $sql = "UPDATE users SET name = '$name', email = '$email', password = '$new_password' WHERE id = $user_id";
            }else{
                $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $user_id";
            }
            $stmt = $pdo->query($sql);
        }else{
            $errors[] = "Current password is incorrect";
        }
    }
}
?>

<?php include("../components/Navbar.php"); ?>

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
								        <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="#">Sign Out</a>
								    </li>
								</ul>
	                		</aside><!-- End .col-lg-3 -->

	                		<div class="col-md-8 col-lg-9">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								    	<p>Hello <span class="font-weight-normal text-dark"><?= $user_name  ?></span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>)
								    	<br>
								    	From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
								    	<p>No order has been made yet.</p>
								    	<a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
								    	<p>No downloads available yet.</p>
								    	<a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
								    	<p>The following addresses will be used on the checkout page by default.</p>

								    	<div class="row">
								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Billing Address</h3><!-- End .card-title -->

														<p><?= $user_name?> <br>
														User Company<br>
														John str<br>
														New York, NY 10001<br>
														1-234-987-6543<br>
														yourmail@mail.com<br>
														<a href="#">Edit <i class="icon-edit"></i></a></p>
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->

								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

														<p>You have not set up this type of address yet.<br>
														<a href="#">Edit <i class="icon-edit"></i></a></p>
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
								    	</div><!-- End .row -->
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
								    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                            <?php foreach ($errors as $error) : ?>
                                                <p class="alert alert-danger"><?php echo $error ?></p>
                                            <?php endforeach ?>
		            						<label>Display Name *</label>
		            						<input type="text" class="form-control" value="<?= $user_name ?>" name="user_name" >
		            						<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>
		                					<label>Email address *</label>
		        							<input type="email" class="form-control" value="<?= $user_email ?>"  name="user_email" placeholderrequired>

		            						<label>Current password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control" name="user_password">

		            						<label>New password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control" name="new_password">

		            						<label>Confirm new password</label>
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