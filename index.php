<?php

require_once 'src/PortScanner/PortScanner.php';

$port_scanner = new PortScanner();
$host = '127.0.0.1';
$starting_port = 1;
$ending_port = 65535;

$port_scanner->scan($host, $starting_port, $ending_port);