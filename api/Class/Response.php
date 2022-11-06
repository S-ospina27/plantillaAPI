<?php

class Response {

	public function __construct() {

	}

	public static function finish($response) {
		die(Json::encode($response));
	}

	public static function response($status, $message = null, $data = []) {
		return (object) ['status' => $status, 'message' => $message, 'data' => $data];
	}

	public static function success($message = null, $data = []) {
		return self::response('success', $message, $data);
	}

	public static function error($message = null, $data = []) {
		return self::response('error', $message, $data);
	}

	public static function warning($message = null, $data = []) {
		return self::response('warning', $message, $data);
	}

	public static function info($message = null, $data = []) {
		return self::response('info', $message, $data);
	}

}