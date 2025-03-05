<?php 

interface LogStorage {
    public function write($content, $logLevel);
}