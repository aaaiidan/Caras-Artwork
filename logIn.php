<?php
session_start();

$password = "d56963fbad09a2b894c7cf6ed6fe3cd5";
if (!isset($_SESSION['admin'])){
    $_SESSION['admin'] = false;
}
if($_SESSION['admin']){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Log-In</title>
    </head>
    <body>
    <h1>Already Logged In</h1>

    </body>
    </html>
    <?php
} else {

    if (isset($_POST["pw"]) && $password == md5($_POST["pw"])) {
        $_SESSION['admin'] = true;
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Log-In</title>
        </head>
        <body>
        <script>
            let pass = <?php echo json_encode(md5(($_POST["pw"])));?>;
        </script>
        <script src="logInScript.js"> </script>

        </body>
        </html>
        <?php
    } else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Log-In</title>
        </head>
        <body>
        <div>
            <form action="logIn.php" method ="post">
                <input type="password" id="pw" name="pw">
                <input type="submit">
            </form>
        </div>

        <script>
            let pass = <?php echo json_encode("");?>;
        </script>
        <script src="logInScript.js"> </script>

        </body>
        </html>
    <?php
    }
}
?>