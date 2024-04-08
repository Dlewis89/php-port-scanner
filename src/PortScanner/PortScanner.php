<?php

namespace Demetrius\PhpPortScanner\PortScanner;

use Demetrius\PhpPortScanner\ProcessManager\ProcessManager;

class PortScanner 
{
    public function scan($host, $starting_port, $ending_port, $num_processes = 4) {
        echo "Port scanner is running..." . PHP_EOL;

        $port_ranges = $this->splitPortRange($starting_port, $ending_port, $num_processes);

        ProcessManager::runConcurrently($num_processes, function () use ($host, $port_ranges) {
            foreach ($port_ranges as $range) {
                $this->scanPorts($host, $range['start'], $range['end']);
            }
        });

        echo "Port scanner has finished." . PHP_EOL;
    }

    private function splitPortRange($start_port, $end_port, $num_processes) {
        $port_ranges = [];
        $range_size = ceil(($end_port - $start_port + 1) / $num_processes);

        for ($i = 0; $i < $num_processes; $i++) {
            $range_start = $start_port + ($i * $range_size);
            $range_end = min($start_port + (($i + 1) * $range_size) - 1, $end_port);
            $port_ranges[] = ['start' => $range_start, 'end' => $range_end];
        }

        return $port_ranges;
    }

    private function scanPorts($host, $start_port, $end_port) {
        for ($port = $start_port; $port <= $end_port; $port++) {
            $connected = @fsockopen($host, $port, $errno, $errstr, 30);
            if ($connected !== false) {
                echo "Port $port is open" . PHP_EOL;
                fclose($connected);
            }
        }
    }
}