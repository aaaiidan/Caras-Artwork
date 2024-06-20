<?php
session_start();
if (!isset($_SESSION['counter'])){
    $_SESSION['counter'] = 0;
}

$host = "devweb2022.cis.strath.ac.uk";
$user = "gkb20129";
$pass = "Oophaj4chi8a";
$dbname = $user;
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
    die("Connection failed : ".$conn->connect_error);
}

$sql = "SELECT * FROM `artwork_system`";
$result = $conn->query($sql);

$ids = array();
$name = array();
$doc = array();
$width = array();
$height = array();
$price = array();
$desc = array();
$image = array();


while ($data = $result->fetch_assoc()) {
    $ids[] = $data["id"];
    $name[] = $data["name"];
    $doc[] = $data["doc"];
    $width[] = $data["width"];
    $height[] = $data["height"];
    $price[] = $data["price"];
    $desc[] = $data["description"];
    $image[] = $data["image"];
}
//Disconnect
$conn->close();

$_SESSION['real_id'] = $ids;
$_SESSION['real_name'] = $name;


if(isset($_GET['next'])){
    $_SESSION['counter']++;
    if( (count($image)/12 <= $_SESSION['counter'])){
         $_SESSION['counter']--;
    }
} elseif (isset($_GET['prev'])){
    $_SESSION['counter']--;
}


load($name, $doc, $width, $height, $price, $desc, $image);
function load($name, $doc, $width, $height, $price, $desc, $image){
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

    <h1 id="sub_header">Available Artwork</h1>

    <div class="images_displayed">
        <?php
        if ($_SESSION['counter'] >0){
            $index = $_SESSION['counter'] * 12;
            $limit = $index + 12;

            if((count($image)%12) != 0){
                $limit = ($limit-12) + (count($image)%12);
            }

            for($index;$index < $limit; $index++){
                echo '<div class="individual_image"><img src="data:image/jpeg;base64,'.base64_encode($image[$index]).'" alt="'.$name[$index].'"></div>';
            }
        } else {
            $_SESSION['counter'] = 0;
            for($i=0;$i < 12; $i++){
                echo '<div class="individual_image"><img src="data:image/jpeg;base64,'.base64_encode($image[$i]).'" alt="'.$name[$i].'"></div>';
            }
        }
        ?>
    </div>

    <form action ="index.php" method="get">
        <button name="prev" type="submit" id="prev_images">&#8249;</button>
        <button name="next" type="submit" id="next_images">&#8250;</button>
    </form>

    <div class="chosen_image">
        <span onclick="close_image()">&times;</span>
        <img src="" alt="">
        <div class ="image_info">
            <h1></h1>
            <br>
            <div id="headers">
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
            <div id="content">
                <p id="doc"></p>
                <br>
                <p id="width"></p>
                <br>
                <p id="height"></p>
                <br>
                <p id="price"></p>
                <br>
                <p id="desc"></p>
            </div>
            <form action ="orderForm.php" method="post">
                <input type="hidden" name="image">
                <input type="hidden" name="image_name">
                <input type="hidden" name="doc">
                <input type="hidden" name="width">
                <input type="hidden" name="height">
                <input type="hidden" name="price">
                <input type="hidden" name="desc">

                <button name="buy" type="submit" id="buy" onclick="window.location.href='orderForm.php'">Buy Now</button>
            </form>

        </div>
    </div>
</div>


<script>
    let name = <?php echo(json_encode($name)); ?>;
    let doc = <?php echo(json_encode($doc)); ?>;
    let width = <?php echo(json_encode($width)); ?>;
    let height = <?php echo(json_encode($height)); ?>;
    let price = <?php echo(json_encode($price)); ?>;
    let desc = <?php echo(json_encode($desc)); ?>;
    let index = <?php echo(json_encode($_SESSION['counter']*12)); ?>;
</script>
<script src="indexScripts.js"></script>

</body>
</html>

<?php
}
?>