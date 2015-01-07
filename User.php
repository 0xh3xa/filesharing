<!--m0awad-->
<?php

function __autoload($class) {
    require_once ($class . ".php");
}

if (session_id() == '') {
    session_start();
}
?>
<?php

class User {

    private $id;
    private $usrname;
    private $passwd;
    private $file;
    private $show;
    private $content;
    private $type;
    private $perm;

    public function __construct($usrname, $passwd) {

        $this->usrname = $usrname;
        $this->passwd = $passwd;
    }

    public static function login(User $user) {
        $link = Con::get_con();
        if (isset($link)) {
            $result = mysqli_query($link, "SELECT * FROM Users WHERE user_name='" . $user->usrname . "' AND pass_key='" . $user->passwd . "' LIMIT 1") or die("error in select");

            $row = mysqli_fetch_array($result);
            if ($row) {
                $user->id = $row['user_id'];
                $_SESSION['user'] = serialize($user);
                if ($user->new) {
                    User::send_server($user->id . ",new,end");
                }
                return $user;
            }
        }

        return null;
    }

    private static function send_server($message) {


        $server = new Server();
        $server->set_message($message);

        return Server::send($server);
    }

    public static function set_new(User $user) {
        $link = Con::get_con();
        if (isset($link)) {
            $result = mysqli_query($link, "INSERT INTO Users (user_name,pass_key) VALUES('" . $user->usrname . "','" . $user->passwd . "')") or die("error in select");
            $user->new = true;

            return self::login($user);
        }
    }

    public static function set_delete(User $user) {
        $state = User::send_server($user->id . ",del," . $user->file . ",end");

        $link = Con::get_con();
        if (isset($link)) {
            mysqli_query($link, "DELETE FROM file WHERE user_id=" . $user->id . " AND file_name='" . $user->file . "'") or die("error in select");
        }
    }

    public static function set_edit(User $user) {
        $user->update_session();
        return User::send_server($user->id . ",get," . $user->file . ",end");
    }

    public static function set_update_public($id, $file, $content) {

        User::send_server($id . ",set," . $file . "," . $content . ",end");
    }

    public static function set_update(User $user) {
        if ($user->show) {
            $link = Con::get_con();
            if (isset($link)) {
                mysqli_query($link, "UPDATE  file SET permission='" . $user->show . "' WHERE user_id=" . $user->id . " AND file_name='" . $user->file . "'") or die(mysqli_error($link));
            }
        }
        $user->update_session();
        User::send_server($user->id . ",set," . $user->file . "," . $user->content . ",end");
    }

    public static function get_state_file(User $user) {
        $link = Con::get_con();

        if (isset($link)) {
            $result = mysqli_query($link, "SELECT permission FROM file WHERE user_id=" . $user->id . " AND file_name='" . $user->file . "' LIMIT 1") or die("error in select");
            $row = mysqli_fetch_array($result);
            return $row['permission'];
        }
    }

    public static function get_share($msg) {
        $link = Con::get_con();
        $arr = split(",", $msg);
        if (isset($link)) {
            $result = mysqli_query($link, "SELECT permission FROM file WHERE user_id=" . $arr[0] . " AND file_name='" . $arr[2] . "' LIMIT 1") or die("error in select");
            $row = mysqli_fetch_array($result);
            if ($row['permission'] == "private") {

                exit;
            }
        }

        return User::send_server($msg);
    }

    public static function set_share(User $user) {

        return $user->id . ",get," . $user->file . ",end";
    }

    public static function set_upload(User $user) {

        $link = Con::get_con();
        if ($link) {
            mysqli_query($link, "INSERT INTO file (user_id,file_name,permission) VALUES('" . $user->id . "','" . $user->file . "','" . $user->perm . "')") or die("fuck");
        }
        $user->set_update($user);
        unlink("/var/www/html/filesharing/" . $user->file);
    }

    private function update_session() {

        $_SESSION['user'] = serialize($this);
    }

    public function get_id() {

        return $this->id;
    }

    public function get_show() {
        return $this->show;
    }

    public function set_show($show) {
        return $this->show = $show;
    }

    public function get_file() {
        return $this->file;
    }

    public function set_file($file) {
        return $this->file = $file;
    }

    public function set_perm($perm) {
        return $this->perm = $perm;
    }

    public function get_perm() {
        return $this->perm;
    }

    public function get_content() {
        return $this->content;
    }

    public function set_type($type) {
        return $this->type = $type;
    }

    public function get_type() {
        return $this->type;
    }

    public function set_content($content) {
        return $this->content = $content;
    }

    public function get_usrname() {

        return $this->usrname;
    }

    public function get_passwd() {

        return $this->passwd;
    }

}
