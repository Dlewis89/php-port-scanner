<?php

class PortScanner 
{
    public function __construct() {

        echo "Port scan is running..." . PHP_EOL;
        
    }
    
    public function __destruct() {

        echo "Port scan has finished." . PHP_EOL;

    }

    public function scan($host = '127.0.0.1', $starting_port = 1, $ending_port = 65535) {

        for ($port = $starting_port; $port <= $ending_port; $port++) {
            $connected = @fsockopen($host, $port, $errno, $errstr, 30);

            if (!empty($connected)) {
                echo "Port $port is open" . PHP_EOL;
                fclose($connected);
            }

            usleep(10000); // Add a delay so older cpus don't explode
        }

    }
}