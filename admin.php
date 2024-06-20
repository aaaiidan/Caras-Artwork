<?php
session_start();

if (!isset($_SESSION['admin'])){
    $_SESSION['admin'] = false;
}


$uploaded_name = isset($_POST['upload_name'])  && $_POST['upload_name'] != "" ? strip_tags($_POST['upload_name']) : "error";
$uploaded_doc = isset($_POST['upload_doc']) && $_POST['upload_doc'] != "" ? strip_tags($_POST['upload_doc']) : "error";
$uploaded_width = isset($_POST['upload_width']) && $_POST['upload_width'] != "" ? strip_tags($_POST['upload_width']) : "error";
$uploaded_height = isset($_POST['upload_height']) && $_POST['upload_height'] != "" ? strip_tags($_POST['upload_height']) : "error";
$uploaded_price = isset($_POST['upload_price']) && $_POST['upload_price'] != "" ? strip_tags($_POST['upload_price']) : "error";
$uploaded_desc = isset($_POST['upload_desc']) && $_POST['upload_desc'] != "" ? strip_tags($_POST['upload_desc']) : "error";

$order_id = isset($_POST['order_id']) && $_POST['order_id'] != "" ? $_POST['order_id'] : "error";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="externalCSS.css">
    <meta charset="UTF-8">
    <title>Admin</title>
</head>
<body>
<?php
if ($_SESSION['admin']) {
    connect_database();
    add_art($uploaded_name, $uploaded_doc, $uploaded_width, $uploaded_height, $uploaded_price, $uploaded_desc);
    remove_order($order_id);
} else {
    echo "<h1>ACCESS DENIED</h1>";
}
?>
    </body>
</html>
<?php
function connect_database(){

$host = "devweb2022.cis.strath.ac.uk";
$user = "gkb20129";//your username
$pass = "Oophaj4chi8a";//your MySQL password
$dbname = $user;
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
die("Connection failed : ".$conn->connect_error);
}

$sql = "SELECT * FROM `artwork_system`";
$result1 = $conn->query($sql);

if ($conn->query($sql)) {
    echo
        "<h1>Artwork System</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>doc</th>
                <th>Width</th>
                <th>Height</th>
                <th>Price</th>
                <th>Description</th>
            </tr>";

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            echo '
            <tr>
                <td>' . $row["id"] . '</td>
                <td>' . $row["name"] . '</td>
                <td>' . $row["doc"] . '</td>
                <td>' . $row["width"] . '</td>
                <td>' . $row["height"] . '</td>
                <td>' . $row["price"] . '</td>
                <td>' . $row["description"] . '</td>
            </tr>';
        }
        echo '
        </table>
        <br>
        <h3>Input new Art</h3>
        <form enctype="multipart/form-data" action="admin.php" method ="post">
            <label for="upload_name">Name:</label>
            <input type="text" id="upload_name" name="upload_name" maxlength="20"/>
            <br><br>
            <label for="upload_doc">DOC:</label>
            <input type="date" id="upload_doc" name="upload_doc"/>
            <br><br>
            <label for="upload_width">Width:</label>
            <input type="number" id="upload_width" name="upload_width" maxlength="4"/>
            <br><br>
            <label for="upload_height">Height:</label>
            <input type="number" id="upload_height" name="upload_height" maxlength="4"/>
            <br><br>
            <label for="upload_price">Price:</label>
            <input type="number" id="upload_price" name="upload_price" step="0.01"/>
            <br><br>
            <label for="upload_desc">Description:</label>
            <input type="text" id="upload_desc" name="upload_desc" maxlength="500"/>
            <br><br>
            <label for="upload_image">Image:</label>
            <input type="file" id="upload_image" name="upload_image"/>
            
            <input type="submit"/>
        </form>
        <br><br>
        <h1>Artwork Orders</h1>
        ';
    }
}

    $sql = "SELECT * FROM `artwork_orders`";
    $result1 = $conn->query($sql);

    if ($conn->query($sql)) {
        echo
            "<table style='width:100%'>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Street</th>
                    <th>Postcode</th>
                    <th>City</th>
                    <th>Art_id</th>
                </tr>";

        echo '
        <br>
        <h3>Remove Order</h3>
        <form action="admin.php" method ="post">
            <label for="order_id">id:</label>
            <input type="number" id="order_id" name="order_id"/>
            <br><br>
            <input type="submit"/>
        </form>
        ';

        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["phone"] . '</td>
                        <td>' . $row["email"] . '</td>
                        <td>' . $row["street"] . '</td>
                        <td>' . $row["postcode"] . '</td>
                        <td>' . $row["city"] . '</td>
                        <td>' . $row["art_id"] . '</td>
                    </tr>';
            }
            echo "</table>";
        }
    }
//Disconnect
$conn->close();
}

function add_art($uploaded_name, $uploaded_doc, $uploaded_width, $uploaded_height, $uploaded_price, $uploaded_desc){

    $data = array($uploaded_name, $uploaded_doc, $uploaded_width, $uploaded_height, $uploaded_price, $uploaded_desc);


    for ($i=0; $i < count($data); $i++){
        echo $data[$i];
        if($data[$i] == "error"){
            return;
        }
    }

    if($_FILES["upload_image"]["error"] != 0){
        return;
    }

    $uploaded_image = addslashes(file_get_contents($_FILES['upload_image']['tmp_name']));

    $host = "devweb2022.cis.strath.ac.uk";
    $user = "gkb20129";
    $pass = "Oophaj4chi8a";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);


    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error);
    }

    $sql = "INSERT INTO `artwork_system` (`name`, `doc`, `width`, `height`, `price`, `description`, `image`)" .
        " VALUES ('$uploaded_name', '$uploaded_doc', '$uploaded_width', '$uploaded_height', '$uploaded_price', '$uploaded_desc', '$uploaded_image')";

    if (!($conn->query($sql))) {
        echo "<p> Error submitting data </p>";
    } else {
        echo "<p>Inserted into database!</p>";
    }

//Disconnect
    $conn->close();
    unset($_POST);
}

function remove_order($order_id){

    if($order_id == "error"){
        echo "returned";
        return;
    }

    $host = "devweb2022.cis.strath.ac.uk";
    $user = "gkb20129";
    $pass = "Oophaj4chi8a";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);


    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error);
    }

    $sql = "DELETE FROM `artwork_orders` WHERE id='$order_id'";

    if (!($conn->query($sql))) {
        echo "<p> Error deleting data </p>";
    } else {
        echo "<p>Deleted Order!</p>";
    }

//Disconnect
    $conn->close();
    unset($_POST);
}
unset($_POST);
?>