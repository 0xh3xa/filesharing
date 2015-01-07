<!--m0awad-->
<?php
require_once './User.php';
?>

<?php
if (isset($_GET['view']) && !isset($_SESSION['public'])) {

    $_SESSION['public'] = $_GET['view'];
}
if (isset($_GET['submit'])) {
    $info = $_SESSION['public'];
    $arr = split(",", $info);
    User::set_update_public($arr[0], $arr[2], $_GET['area']);
    header("Location: share.php");
}


$content = User::get_share($_SESSION['public']);
echo "<form action='share.php' method='get'><textarea name='area' cols='100' rows='20'>" . $content . "</textarea><br/><input type='submit' name='submit' value='update'/></form>";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>


    </body>
</html>
