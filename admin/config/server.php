<?php
require_once('connection.php');

// initializing variables
$name = "";
$email = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($name)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password_1)) {
        $errors[] = "Password is required";
    }
    if ($password_1 !== $password_2) {
        $errors[] = "The two passwords do not match";
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE name='$name' OR email='$email' LIMIT 1";
    $stmt = $pdo->prepare($user_check_query);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) { // if user exists
        if ($user['name'] === $name) {
            $errors[] = "Username already exists";
        }

        if ($user['email'] === $email) {
            $errors[] = "email already exists";
        }
    }


    // Finally, register user if there are no errors in the form
    if (empty($errors)) {
        $password = md5($password_1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (name, email, password)   
  			  VALUES('$name', '$email', '$password')";
            $stmt = $pdo->query($query);
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
}


    if (isset($_POST['login_user'])) {
        $email = $_POST['email'];



        $password = md5($_POST['password']);

        if (empty($name)) {
            $errors[] = "Email is required";
        }
        if (empty($password)) {
            $errors[] = "Password is required";
        }

        if (empty($errors)) {
            $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
            $stmt = $pdo->query($query);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            //handling the result
            if ($data) {
//                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
//                $_SESSION['last_login'] = $data['last_login'];
                $_SESSION['success'] = "You are now logged in";

                if ($data['Role'] === 1) {
                    $_SESSION['Role'] = true;
//                    $query = "UPDATE users SET last_login = NOW() WHERE username = '$username'";
//                    $stmt = $pdo->query($query);
                    header('location: admin/index.php');
                } else {
//                    $query = "UPDATE users SET last_login = NOW() WHERE username = '$username'";
//                    $stmt = $pdo->query($query);
                    $_SESSION['Role'] = false;
                    header('location: google.php');
                }
            } else {
                $errors[] = "Wrong Email/password combination";
            }
        }
    }
