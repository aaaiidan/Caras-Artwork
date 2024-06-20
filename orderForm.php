<?php
session_start();
$name = isset($_POST["name"]) && ($_POST["name"] != "") ? $_POST["name"] : "";
$phone = isset($_POST["phone"]) && ($_POST["phone"] != "")  ? $_POST["phone"] : "";
$mail = isset($_POST["mail"]) && (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) ? $_POST["mail"] : "";
$street = isset($_POST["street"]) && ($_POST["street"] != "") ? $_POST["street"] : "";
$postcode = isset($_POST["postcode"]) && ($_POST["postcode"] != "") ? $_POST["postcode"] : "";
$city = isset($_POST["city"]) && ($_POST["city"] != "") ? $_POST["city"] : "";

    if (isset($_SESSION['image'])) {
        $_SESSION['image'] = isset($_POST["image"]) ? $_POST["image"] : $_SESSION['image'];;
    } else {
        $_SESSION['image'] = "";
    }

    if (isset($_SESSION['image_name'])) {
        $_SESSION['image_name'] = isset($_POST["image_name"]) ? $_POST["image_name"] : $_SESSION['image_name'];
    } else {
        $_SESSION['image_name'] = "";
    }

    if (isset($_SESSION['doc'])) {
        $_SESSION['doc'] = isset($_POST["doc"]) ? $_POST["doc"] : $_SESSION['doc'];
    } else {
        $_SESSION['doc'] = "";
    }

    if (isset($_SESSION['width'])) {
        $_SESSION['width'] = isset($_POST["width"]) ? $_POST["width"] : $_SESSION['width'];
    } else {
        $_SESSION['width'] = "";
    }

    if (isset($_SESSION['height'])) {
        $_SESSION['height'] = isset($_POST["height"]) ? $_POST["height"] : $_SESSION['height'];
    } else {
        $_SESSION['height'] = "";
    }

    if (isset($_SESSION['price'])) {
        $_SESSION['price'] = isset($_POST["price"]) ? $_POST["price"] : $_SESSION['price'];
    } else {
        $_SESSION['price'] = "";
    }

    if (isset($_SESSION['desc'])) {
        $_SESSION['desc'] = isset($_POST["desc"]) ? $_POST["desc"] : $_SESSION['desc'];
    } else {
        $_SESSION['desc'] = "";
    }

for($i = 0; $i < count($_SESSION['real_id']); $i++){
    if($_SESSION['real_name'][$i] == $_SESSION['image_name']){
        $_SESSION['image_id'] = $_SESSION['real_id'][$i];
        $i = count($_SESSION['real_id']);
    } else {
        $_SESSION['image_id'] = "";
    }
}


if($_SESSION['image'] == ""){
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="externalCSS.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <meta charset="UTF-8">
    <title>Cara's Art Shop</title>
</head>
<body>
<div id="main_body">
    <div id="Nav">
        <a class="home" href="index.php">CARA's</a>
        <a class="CO" href="orderForm.php">CURRENT ORDER</a>
        <a class="Login" href="logIn.php">LOGIN</a>
        <a class="Admin" href="admin.php">Admin</a>
    </div>

    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <h1 id='sub_header'>Error, No Art Has Been Chosen!</h1>
</div>
<script src="order.js"></script>
</body>
</html>
    <?php
} else {
    validation($name, $phone, $mail, $street, $postcode, $city);
}

function load_form($name, $phone, $mail, $street, $postcode, $city){
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="externalCSS.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <meta charset="UTF-8">
    <title>Cara's Art Shop</title>
</head>
<body>
<div id="main_body">

    <div id="Nav">
        <a class="home" href="index.php">CARA's</a>
        <a class="CO" href="orderForm.php">CURRENT ORDER</a>
        <a class="Login" href="logIn.php">LOGIN</a>
        <a class="Admin" href="admin.php">Admin</a>
    </div>

    <h1 id="sub_header2">Order</h1>

    <?php
    echo
    '<div id="all_order">
        <h1>'. $_SESSION['image_name'].'</h1>
        <img id="ordered_image" src="'.$_SESSION['image'].'" alt="'.$_SESSION['image_name'].'">
        <br><br>
        <div id="order">
            <p id="doc_header">Date Of Completion:</p>
            <br>
            <p id="width_header">Width:</p>
            <br>
            <p id="height_header">Height:</p>
            <br>
            <p id="price_header">Price:</p>
            <br>
            <p id="desc_header">Description:</p>
        </div>
        <div id="info">
            <p id="doc">'. $_SESSION['doc'].'</p>
            <br>
            <p id="width">'. $_SESSION['width'].'</p>
            <br>
            <p id="height">'. $_SESSION['height'].'</p>
            <br>
            <p id="price">'. $_SESSION['price'].'</p>
            <br>
            <p id="desc">'. $_SESSION['desc'].'</p>
        </div>
    </div>'
    ?>
    <div id ="form">
    <form action="orderForm.php" method ="post">
        <label id="label_name" for="name">Name: </label>
        <input type="text" id="name" name="name" <?php if ($name != "") { echo "value=\"$name\""; }?>/>
        <br><br>

        <label id="label_phone" for="phone_number"> Phone-Number: </label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{11}" <?php if ($phone != "") { echo "value=\"$phone\""; }?>/>
        <br><br>

        <label id="label_mail" for="mail"> Email address: </label>
        <input type="text" id="mail" name="mail" <?php if ($mail != "") { echo "value=\"$mail\""; }?>/>
        <br><br>

        <label id="label_street" for="street"> Street: </label>
        <input type="text" id="Street" name="street" <?php if ($street != "") { echo "value=\"$street\""; }?>/>
        <br><br>
        <label id="label_postcode" for="postcode"> Postcode: </label>
        <input type="text" id="Postcode" name="postcode" <?php if ($postcode != "") { echo "value=\"$postcode\""; }?>/>
        <br><br>
        <label id="label_city" for="city"> City: </label>
        <input type="text" id="City" name="city" <?php if ($city != "") { echo "value=\"$city\""; }?>/>

        <input type="submit"/>
    </form>
    </div>
</div>
<script src="order.js"></script>
</body>
</html>

<?php
}


function validation ($name, $phone, $mail, $street, $postcode, $city){

    $data = array($name, $phone, $mail, $street, $postcode, $city);
    $count = 0;

    if (empty($_SESSION['image_id'])) {
        load_form($name, $phone, $mail, $street, $postcode, $city);
    } else {
        for ($i = 0; $i < count($data); $i++){
            if ($data[$i] == ""){
                $count++;
            }
        }
        if ($count==6){
            load_form($name, $phone, $mail, $street, $postcode, $city);
        } elseif ($count == 0) {
            add_to_database($name, $phone, $mail, $street, $postcode, $city);
        } else {
            echo "error";
            load_form($name, $phone, $mail, $street, $postcode, $city);
        }
    }
}

function add_to_database($name, $phone, $mail, $street, $postcode, $city){

    $host = "devweb2022.cis.strath.ac.uk";
    $user = "gkb20129";//your username
    $pass = "Oophaj4chi8a";//your MySQL password
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    $image_id = $_SESSION['image_id'];

    if ($conn->connect_error){
        die("Connection failed : ".$conn->connect_error);
    }

    $sql = "INSERT INTO `artwork_orders` (`name`, `phone`, `email`, `street`, `postcode`, `city`, `art_id`)".
        " VALUES ('$name', '$phone', '$mail', '$street', '$postcode', '$city', '$image_id')";

    if (!($conn->query($sql))) {
        echo "<p> Error submitting data </p>";
    } else {
        session_unset();
        readfile("ty_page.html");
    }

    //Disconnect
    $conn->close();

}
?>