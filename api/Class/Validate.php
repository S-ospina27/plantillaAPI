<?php

class Validate {

	private static $request;
	private static $response;

	public function __construct() {

	}

	public static function init($request, $response) {
		self::$request = $request;
		self::$response = $response;
	}

	public static function exists($row, $message) {
		if (!isset(self::$request->$row)) {
			self::$response->finish(self::$response->error($message));
		}

		if (empty(self::$request->$row)) {
			self::$response->finish(self::$response->error($message));
		}
	}

	public static function optional($row, $message) {
		if (isset(self::$request->$row)) {
			if (empty(self::$request->$row)) {
				self::$response->finish(self::$response->error($message));
			}
		}
	}

	public static function isEmpty($row, $message) {
		if (empty($row)) {
			self::$response->finish(self::$response->error($message));
		}
	}

}