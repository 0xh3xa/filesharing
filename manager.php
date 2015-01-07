<!--m0awad-->
<?php
session_start();
require_once './User.php';
?>
<?php
$link = Con::get_con();
$user = unserialize($_SESSION['user']);
$query = "select * from file where user_id='" . $user->get_id() . "'";
$qq = mysqli_query($link, $query);
echo "<a href='upload.php'>upload</a>";
echo"<table border='1'   ><tr><th>File</th><th colspan='3'>Operation</th></tr>";
echo "<caption>" . $user->get_usrname() . "</caption>";
while ($q = mysqli_fetch_array($qq)) {

    echo "<tr><td>" . $q['file_name'] . "</td>"
    . "<td><a href='edit.php?f=" . $q['file_name'] . "'>edit</a></td>"
    . "<td><a href='delete.php?f=" . $q['file_name'] . "'>delete</a></td>";
    if ($q['permission'] == "public") {

        echo "<td><a href='manager.php?f=" . $q['file_name'] . "'>share</a></td><td>";
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table, th, td {

                border: 1px solid black;
                padding: 5px;

            }
            table {
                border-spacing: 15px;
            }
        </style>
    </head>
    <body>
        <br/>
        link to share:
        <div style="background-color: gray; width: 400px; height: 200px; color: yellow;">
            <?php
            if (isset($_GET['f'])) {
                $user = unserialize($_SESSION['user']);
                $user->set_file($_GET['f']);
                echo "127.0.0.1/filesharing?view=" . User::set_share($user);
            }
            ?>
        </div>
    </body>
</html>
