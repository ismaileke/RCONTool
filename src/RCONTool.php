<?php

define('SERVER_AUTH', 3);
define('SERVER_SEND_COMMAND', 2);
define('NULL_BYTES', "\x00\x00");

namespace IsmailEke;

class RCONTool {
    
    /** @var \Socket */
    protected \Socket $client;
    
    /** @var bool|false */
    protected bool $connected = false;
    
    /**
     * @param string $ip
     * @param int $port
     * @param string $password
     * 
     * @return bool
     */
    public function connectToServer (string $ip, int $port = 19132, string $password = "") : bool {
        $this->client = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        
        if ($this->client === false) {
            echo "Socket could not be created.";
            return false;
        }
        
        if ((socket_connect($this->client, $ip, $port)) === false) {
            echo "The socket could not be connected to the server.";
            return false;
        }
        
        $data = pack("VV", mt_rand(1000, 9999), SERVER_AUTH) . $password . NULL_BYTES;
        socket_write($this->client, pack("V", strlen($data)) . $data);
        
        if (!$this->responseData()) {
            echo "Failed to Connect to Server. Wrong Password.";
            return false;
        }
        
        $this->connected = true;
        echo "Connection to Server Established.";
        return true;
    }
    
    /**
     * @param string $command
     * 
     * @return void
     */
    public function sendCommand (string $command) : void {
        if (!$this->connected) return;
        $data = pack("VV", mt_rand(1000, 9999), SERVER_SEND_COMMAND) . $command . NULL_BYTES;
        socket_write($this->client, pack("V", strlen($data)) . $data);
        $this->responseData();
    }
    
    /**
     * @return bool
     */
    protected function responseData () : bool {
        $size = socket_read($this->client, 4);
        $size = unpack("V1DataSize", $size);
        $responseData = socket_read($this->client, $size["DataSize"]);
        $responseData = unpack("V1ReqID/V1PacketType", $responseData);
        
        if ($responseData["ReqID"] !== -1) {
            return true;
        } else {
            socket_close($this->client);
            return false;
        }
    }
    
    /**
     * @return void
     */
    public function close () : void {
        socket_close($this->client);
    }
}
