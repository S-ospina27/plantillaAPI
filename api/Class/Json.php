<?php

class Json {

	public function __construct() {

	}

	public static function encode($data) {
		return json_encode($data);
	}

	public static function decode($data) {
		return json_decode($data, true);
	}

}