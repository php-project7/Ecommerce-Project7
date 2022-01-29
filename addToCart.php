<?php
 include('admin/config/server.php');

 
 if($_SERVER["REQUEST_METHOD"]=="GET"){
     
 $value= $_GET["id"];
    $sql1=$pdo->prepare("SELECT * FROM products WHERE id='$value'");
    $sql1->execute();
    $data =$sql1->fetch(PDO::FETCH_ASSOC);


    // check if the product already exist in the the tempCart 
    $product_check_query = "SELECT * FROM tempcart WHERE product_id='$value' LIMIT 1";
    $stmt1 = $pdo->prepare($product_check_query);
    $stmt1->execute();
    $product = $stmt1->fetch(PDO::FETCH_ASSOC);

    if($product){

    }
    else{
        $insert_product="INSERT INTO tempcart (product_id,user_id,img,name,price,quantity,discount)
        ";
    }
    print_r($data);
// header('Location:http://localhost/Project1/project7/index.php');
}



?>