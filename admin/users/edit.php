<?php
require('../config/connection.php');

if (($_SESSION['Role']) != 1 || $_SESSION['Role'] != 2) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../../login.php');
}

$msg = '';
$users_edit_errors = array();

    if (isset($_GET['id'])){
        if (!empty($_POST)){
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $Role = isset($_POST['Role']) ? $_POST['Role'] : 0;
            if (empty($name)){
                $users_edit_errors['username'] = 'Name is required';
            }
            if (empty($email)){
                $users_edit_errors['email'] = 'Email is required';
            }
            if (empty($password)){
                $users_edit_errors['password'] = 'Password is required';
            }
            if (empty($confirm_password)){
                $users_edit_errors['confirm_password'] = 'Confirm Password is required';
            }
            if ($password !== $confirm_password){
                $users_edit_errors['confirm_password'] = 'Password and Confirm Password must be same';
            }
//            if email already exist
            $sql = "SELECT * FROM users WHERE email = '$email'";
            //pdo
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll();
            if (count($result) > 0){
                $users_edit_errors['email'] = 'Email already exist';
            }
            //if username already exist
            $sql = "SELECT * FROM users WHERE name = '$name'";
            //pdo
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll();
            if (count($result) > 0){
                $users_edit_errors['username'] = 'Username already exist';
            }
            if(empty($users_edit_errors)){
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
                            Update User : <?=$user['name']?>
                        </div>
                        <div class="card-body card-block">
                            <form action="edit.php?id=<?=$user['id']?>" method= "post" class="">
                                <?php
                                foreach($users_edit_errors as $error){
                                    echo "<p class='alert w-50 alert-danger'>$error</p>";
                                }
                                ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="ml-2" type="text" name="id" placeholder="26" value="<?=$user['id']?>" hidden>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <label for="name" class="ml-2">Name</label>
                                        </div>
                                        <input type="text" id="username" name="name" value="<?=$user['name']?>" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">

                                            <label for="email" class="ml-2">Email</label>
                                        </div>
                                        <input type="text" id="email" name="email" value="<?=$user['email']?>" placeholder="Email" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">

                                            <label for="password" class="ml-2">Password</label>
                                        </div>

                                        <input type="text" id="password" name="password" placeholder="Password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <label for="confirm_password" class="ml-2">Confirm password</label>
                                        </div>
                                        <input type="text" id="confirm_password" name="confirm_password" placeholder="Confirm password" class="form-control">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">

                                            <label for="Role" class="ml-2">User Role</label>
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