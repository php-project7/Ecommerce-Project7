<?php

include('../../admin/config/server.php');

if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = "";
$create_user_errors = array();
if (!empty($_POST)) {

    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $Role=$_POST['isAdmin'];

    if (empty($name)) {
        $create_user_errors[] = "Name is required";
    }
    if (empty($email)) {
        $create_user_errors[] = "Email is required";
    }
    if (empty($password)) {
        $create_user_errors[] = "Password is required";
    }
    if (empty($confirm_password)) {
        $create_user_errors[] = "Confirm Password is required";
    }
    if ($password != $confirm_password) {
        $create_user_errors[] = "Password and Confirm Password must be same";
    }

    //check if email already exist
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $query = $pdo->query($sql);
    $user = $query->fetch();
    if ($user) {
        $create_user_errors[] = "Email already exist";
    }
    //check if user name already exist
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $query = $pdo->query($sql);
    $user = $query->fetch();
    if ($user) {
        $create_user_errors[] = "User name already exist";
    }

    if (empty($create_user_errors)) {
        $password= md5($password);

            $sql = "INSERT INTO users (name, email, password,role) VALUES ('$name', '$email', '$password','$Role')";
            $query = $pdo->prepare($sql);
            $query->execute();
            $msg = "User created successfully";
        }
    else {
        $msg = "User not created";
    }
}
?>

<?php include '../layout/header.php' ?>
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">CREATE NEW USER</div>
                    <div class="card-body card-block">
                        <form action="create_user.php" method= "post" class="">
                            <?php
                           foreach($create_user_errors as $error){
                               echo "<p class='alert w-50 alert-danger'>$error</p>";
                           }
                            ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" id="username" name="username" placeholder="Username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div>
                                    <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div>
                                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" class="form-control">

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-empire"></i>
                                    </div>
                                    <input type="number" id="number" name="isAdmin" placeholder="User Status"  class="form-control">
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