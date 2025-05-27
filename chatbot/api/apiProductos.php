<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $host = "localhost";
    $dbname = "gelohimg_elohim";
    $username = "root";
    $password = "";

    $conn = new mysqli($host, $username, $password, $dbname);

    if($conn -> connect_error){
        die(json_encode(["error" => "Failed Connection: " .$conn->connect_error]));
    }

    $sql= "SELECT id, nameProd, precio, description_Prod FROM products WHERE estado = 1";
    $result = $conn->query($sql);

    $products = [];

    if ($result->num_rows >0 ){
        while($row = $result->fetch_assoc()){
            $products[] = $row;
        }
    }

    echo json_encode($products);
    $conn->close();
?>