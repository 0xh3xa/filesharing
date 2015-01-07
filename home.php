<!--m0awad-->
<?php
require_once './User.php';

if (session_id() == '') {
    session_start();
}
?>
<?php
if (isset($_SESSION['user'])) {

    $user = unserialize($_SESSION['user']);
    echo "<h1>" . $user->get_usrname() . "</h1>";
    echo "<a href='manager.php'>Manage</a><br/>";
    echo "<a href='upload.php'>upload</a>";
}else{
    
    echo "fuck";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
