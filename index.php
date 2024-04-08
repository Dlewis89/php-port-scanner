<?php

require_once './vendor/autoload.php';

use Demetrius\PhpPortScanner\PortScanner\PortScanner;

$port_scanner = new PortScanner();
$host = '127.0.0.1';
$starting_port = 1;
$ending_port = 1000;

$port_scanner->scan($host, $starting_port, $ending_port);