<?php

require_once './roots.php';
?>
<?php

class Server {

    private $socket;
    private $message;
    private $content;

    public function Server() {

        $this->socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        socket_connect($this->socket, SRV, PORT);
    }

    public static function send(Server $server) {

        $status = socket_sendto($server->socket, $server->message, strlen($server->message), MSG_EOF, SRV, PORT) or die('can not connect to server');

        if ($status !== FALSE) {
            $server->content = '';
            $next = '';
            
            while ($next = socket_read($server->socket, 10)) {
                $server->content .= $next;
            }

            
            return $server->content;
        } else {
            return $server->content;
        }
    }

    public function set_message($message) {
        $this->message = $message;
    }

    public function get_message() {
        return $this->message;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_socket() {
        return $this->socket;
    }

    public function __destruct() {
        socket_close($this->socket);
    }

}
