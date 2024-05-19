<?php
session_start();
include ("includes/sqlconnection.php");

if (isset($_POST['add_product'])) {

    $photo = $_FILES['txtphoto']['name'];
    $prodName = $_POST['txtprodName'];
    $price = $_POST['txtprice'];
    $caption = $_POST['txtcaption'];
    $categ = strtolower($_POST['txtcategory']);

    $sql = "INSERT INTO products(photo, prodName, price, caption, category) VALUES ('$photo','$prodName','$price','$caption','$categ')";

    if ($conn->query($sql) === TRUE) {
        move_uploaded_file($_FILES["txtphoto"]["tmp_name"], "../images/products/$categ/" . $_FILES['txtphoto']['name']);
        $_SESSION['status'] = "Product Added Successfully";
        header('location:admin.php');
    } else {
        $_SESSION['status'] = "Error: Insert failed...";
        header('location:admin.php');
    }

    $conn->close();

}

//Function to fetch product by category
function fetchProductbyCateg()
{
    global $conn;
    $id = $_POST['id'];
    $categ = $_POST['category'];

    $query = "SELECT * FROM products WHERE id = '$id' AND category = '$categ' ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='col-md-5'>
                <div class='img-thumbnail'>
                    <img src='../images/products/electronics devices/.$row[photo].' style='width: 50%; height: 250px; object-fit: cover;'>
                    <img src='../images/products/homeliving/.$row[photo].' style='width: 200%; height: 250px; object-fit: cover;'>
                    <img src='../images/products/fashion/.$row[photo].' style='width: 200%; height: 250px; object-fit: cover;'>
                    <img src='../images/products/sports/.$row[photo].' style='width: 200%; height: 250px; object-fit: cover;'>
                    <img src='../images/products/grocery/.$row[photo].' style='width: 200%; height: 250px; object-fit: cover;'>
                </div>
            </div>
            ";
        }
    } else {
        return "No Record Found";
    }
}

if (isset($_POST['delete_product'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM products WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "Deleted Successfully.";
        header('location: admin.php');
    } else {
        $_SESSION['status'] = "Insertion Failed.";
        header('location: admin.php');
    }
    $conn->close();

}
?>