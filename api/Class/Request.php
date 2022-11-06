<?php

class Request {

    public function __construct() {

    }

    public static function capture() {
        $content = json_decode(file_get_contents("php://input"), true);

        if ($content === null) {
            return (object) ($_POST + $_FILES + $_GET);
        }

        return (object) $content;
    }

    public static function header($type, $value) {
        header("{$type}: {$value}");
    }

}