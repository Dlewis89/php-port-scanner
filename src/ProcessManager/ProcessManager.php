<?php

namespace Demetrius\PhpPortScanner\ProcessManager;

class ProcessManager 
{
    public static function runConcurrently($num_processes, callable $callback) {
        $pids = [];

        for ($i = 0; $i < $num_processes; $i++) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                die("Failed to fork process.");
            } elseif ($pid) {
                // Parent process
                $pids[] = $pid;
            } else {
                // Child process
                $callback();
                exit(); // Child process exits after completing its task
            }
        }

        // Wait for all child processes to finish
        foreach ($pids as $pid) {
            pcntl_waitpid($pid, $status);
        }
    }
}