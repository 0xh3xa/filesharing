<!--m0awad-->
<?php

require_once './User.php';
?>
<?php
// put your code here
if (isset($_POST['sub'])) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $pass1 = $_POST['pass1'];
    if ($name == null || $pass == null || $pass1 == null || $pass != $pass1) {
        echo"<h1>Error:Please Check Your Data</h1>";
    } else {
        $user = new User($name, $pass);
        if (User::set_new($user)) {
            header("Location: home.php");
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <pre>
        <form action="register.php" method="post">
      Name:   <input type="text" name="name" /><br />
      Pass:   <input  type="password" name="pass" /><br />
      Re-Pass <input type="password" name="pass1" /><br />
      <input type="submit" name="sub" value="Register" />
      </form>
        </pre>
    </body>
</html>
