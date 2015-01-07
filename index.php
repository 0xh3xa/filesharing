<?php
if (isset($_GET['view'])) {
    header("Location: share.php?view=".$_GET['view']);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form action="login.php" method="post">
            <input type="text" name="usrname" required="" maxlength="20"/>
            <input type="password" name="passwd" required="" maxlength="13"/>
            <input type="submit" name="submit" value="login"/>
            or <a href="register.php">register</a>
            or <a href="share.php">view</a>

        </form>
    <center><h1> File-Sharing</h1></center>


</body>
</html>
