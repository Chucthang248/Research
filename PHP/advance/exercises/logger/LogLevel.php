<?php 

interface LogLevel {
     public function debug($content);
     public function info($content);
     public function warn($content);
     public function error($content);
}