<?php
include('admin/config/server.php');


if ($_SERVER["REQUEST_METHOD"] == "GET") {



    // get the logged user id
    if (isset($_SESSION['id'])) {
        if ($_SESSION['id'] != 0) {
            $value = $_GET["id"];
            $sql1 = $pdo->prepare("SELECT * FROM products WHERE id='$value'");
            $sql1->execute();
            $data = $sql1->fetch(PDO::FETCH_ASSOC);
            $logged_user = $_SESSION['id'];

            // check if the product already exist in the the tempCart 
            // $product_check_query = "SELECT * FROM tempcart WHERE product_id='$value' LIMIT 1";
            $product_check_query = "SELECT * FROM tempcart WHERE product_id='$value' AND user_id='$logged_user' LIMIT 1";

            $stmt1 = $pdo->prepare($product_check_query);
            $stmt1->execute();
            $product = $stmt1->fetch(PDO::FETCH_ASSOC);

            // if the product exist in the tempcart update the quantity based on the quantity in the table
            // And if the product not exist then insert it in the tempcart 
            if ($product) {
                $count = $product['quantity'];
                $count++;

                $insert_product1 = $pdo->prepare("UPDATE tempcart SET quantity='$count' WHERE id='$product[id]' AND product_id='$data[id]' AND user_id='$logged_user'");
                $insert_product1->execute();
                header('location:index.php');
            } else {
                $insert_product = $pdo->prepare("INSERT INTO tempcart (product_id,user_id,img,name,price,quantity,discount, final_price)
        VALUES('$data[id]','$logged_user', '$data[img]','$data[name]','$data[price]','1','$data[discount]', '1')");
                $insert_product->execute();
                header('location:index.php');
            }
        } else {
            header('location:login.php');
        }
    } else {
        header('location:login.php');
        exit();
    }
}