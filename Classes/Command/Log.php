<?php
namespace Command;
class Log {
    public static function Log($txt,$file,$line) {
        die($txt.'<br><b>File: '.$file.'; Line: '.$line);
    }
}