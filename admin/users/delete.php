<?php
require('../config/connection.php');

//if (($_SESSION['isAdmin']) != 1) {
//    $_SESSION['msg'] = "You must log in first";
//    echo "<script>alert('You must log in first');</script>";
//
//    header('location: ../login.php');
//}
$msg = '';
$errors = array();

if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch();
    if (!$user) {
        exit('Contact doesn\'t exist with that ID!');
    }
    if ($user['role'] == 1) {
        $errors[] = 'You can not delete an admin';
    }
    if (isset($_GET['confirm']) && empty($errors)) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
            header('Location: ./index.php');

        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: ./index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?php include '../layout/header.php' ?>
        <div class="container pt-5 mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h2>Delete Contact #<?=$user['id']?></h2>
                        </div>
                        <?php if ($msg)  : ?>
                           <div class='alert alert-danger  d-flex align-items-center justify-content-center'><?=$msg?></div>
                       <?php else: ?>

                        <div class="confirm-delete">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <label class="p-5 font-weight-bold font-size-10">Are you sure want to delete this user <?=$user['id']?>?</label>

                                                <a class="btn btn-danger mr-2" href="delete.php?id=<?=$user['id']?>&confirm=yes">Yes</a>
                                                <a class="btn btn-primary " href="delete.php?id=<?=$user['id']?>&confirm=no">No</a>
                                            </div>

                                        </div>
                                    </div>
                        </div>
                        <?php endif; ?>
                            <?php
                            //errors printing
                            if (isset($errors) && !empty($errors)) {

                                foreach ($errors as $error) {
                                    echo '<p class="alert alert-danger  d-flex align-items-center justify-content-center">' . $error . '</p>';
                                }

                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php' ?>