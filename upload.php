<?php
require_once './User.php';


?>
<?php
echo "<a href='manager.php'>manager</a>";
$db = 'filesharing';
if (isset($_SESSION['user'])) {
    if (isset($_POST['upload'])) {
        $name = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        $size = $_FILES['file']['size'];
        $type = $_FILES['file']['type'];
        $perm = $_POST['perm'];

        move_uploaded_file($tmp, $name);

        $myfile = fopen("/var/www/html/filesharing/".$name, "r") or die("fuck file");
        $content = fread($myfile, filesize($name));
        fclose($myfile);

        
        $user = unserialize($_SESSION['user']);
        
        $user->set_file($name);
        
        $user->set_content($content);
        $user->set_perm($perm);
        $user->set_type($type);
         User::set_upload($user);
    }
} else {
    include_once 'index.php';
}
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"  /><br/>
    Public<input type="radio" name="perm" value="public"/>
    Private<input type="radio"name="perm" value="private"/><br />

    <input type="submit" name="upload" value="upload"/>

</form>