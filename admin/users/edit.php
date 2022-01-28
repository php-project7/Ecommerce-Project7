<?php
require('../config/connection.php');

if (($_SESSION['Role']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = '';
$errors = array();

    if (isset($_GET['id'])){
        if (!empty($_POST)){
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $Role = isset($_POST['Role']) ? $_POST['Role'] : 0;
            if (empty($name)){
                $errors['username'] = 'Name is required';
            }
            if (empty($email)){
                $errors['email'] = 'Email is required';
            }
            if (empty($password)){
                $errors['password'] = 'Password is required';
            }
            if (empty($confirm_password)){
                $errors['confirm_password'] = 'Confirm Password is required';
            }
            if ($password !== $confirm_password){
                $errors['confirm_password'] = 'Password and Confirm Password must be same';
            }
//            if email already exist
            $sql = "SELECT * FROM users WHERE email = '$email'";
            //pdo
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll();
            if (count($result) > 0){
                $errors['email'] = 'Email already exist';
            }
            //if username already exist
            $sql = "SELECT * FROM users WHERE name = '$name'";
            //pdo
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll();
            if (count($result) > 0){
                $errors['username'] = 'Username already exist';
            }
            if(empty($errors)){
                $password = md5($password);
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?,  password = ?, Role= ? WHERE id = ?");
                    $stmt->execute([$name, $email, $password, $Role,$id]);
                    $msg = 'User Updated Successfully';
            }else
            {
                $msg = 'User Not Updated';
            }
        }
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $user = $stmt->fetch();
        if (empty($user)){
            header('Location: index.php');
            exit();
        }

    }else{
        header('Location: index.php');
        exit();
    }
?>
<?php include '../layout/header.php' ?>
        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            Update User #<?=$user['id']?>
                        </div>
                        <div class="card-body card-block">
                            <form action="edit.php?id=<?=$user['id']?>" method= "post" class="">
                                <?php
                                foreach($errors as $error){
                                    echo "<p class='alert w-50 alert-danger'>$error</p>";
                                }
                                ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-sort-numeric-asc"></i>
                                        </div>
                                        <input class="ml-2" type="text" name="id" placeholder="26" value="<?=$user['id']?>" readonly>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" id="username" name="name" value="<?=$user['name']?>" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="text" id="email" name="email" value="<?=$user['email']?>" placeholder="Email" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-asterisk"></i>
                                        </div>
                                        <input type="text" id="password" name="password" placeholder="Password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-asterisk"></i>
                                        </div>
                                        <input type="text" id="confirm_password" name="confirm_password" placeholder="Confirm password" class="form-control">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-empire"></i>
                                        </div>
                                        <input type="number" id="text" min="0" max="2" name="Role" placeholder="User Status" value="<?=$user['role']?>"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </div>
                            </form>
                            <?php if (empty($errors)): ?>
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