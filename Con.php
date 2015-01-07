<?php

require_once './roots.php';
?>
<?php

class Con {

    private static $link;

    public static function get_con() {

        if (!isset(self::$link)) {

            self::$link = mysqli_connect(HOST, ROOT, PASS, DB) or die("error con");
        }
        return self::$link;
    }

    public function __destruct() {
        unset(self::$link);
    }

}
