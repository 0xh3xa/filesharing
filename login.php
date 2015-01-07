<!--m0awad-->
<?php

require_once './User.php';
?>
<?php
if (isset($_POST['submit'])) {

    $usrname = $_POST['usrname'];
    $passwd = $_POST['passwd'];
    $user = new User($usrname, $passwd);
    if (User::login($user) != NULL) {
     
        header("Location: home.php");
    }
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
