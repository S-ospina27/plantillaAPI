<?php

class Connection {

	private static $conn;
	private static $connection;
	private static $stmt;

	public function __construct() {

	}

	public static function init($db_host, $db_name, $db_user, $db_password) {
		self::$connection = new Connection();

		try {
			self::$conn = new PDO(
				"mysql:host={$db_host};port=3306;dbname={$db_name};charset=utf8", $db_user, $db_password, [
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
					PDO::ATTR_TIMEOUT => 5
				]
			);
		} catch (PDOException $e) {
			Response::finish(Response::error($e->getMessage()));
		}

		return self::$connection;
	}

	public static function prepare($sql) {
		self::$stmt = self::$conn->prepare(trim($sql));
		return self::$connection;
	}

	public static function bindValue($rows) {
		$type = function($row) {
			switch (gettype($row)) {
				case 'integer':
				return PDO::PARAM_INT;
				break;

				case 'boolean':
				return PDO::PARAM_BOOL;
				break;

				case 'NULL':
				return PDO::PARAM_NULL;
				break;

				default:
				return PDO::PARAM_STR;
				break;
			}
		};

		foreach ($rows as $key => $row) {
			self::$stmt->bindValue(($key + 1), $row, $type($row));
		}

		return self::$connection;
	}

	public static function execute() {
		try {
			self::$stmt->execute();
			return Response::success("Execution finished");
		} catch (PDOException $e) {
			return Response::error($e->getMessage());
		}
	}

	public static function fetch() {
		try {
			if (!self::$stmt->execute()) {
				Response::finish(Response::error("An unexpected error has occurred"));
			}

			$request = self::$stmt->fetch();

			if (!$request) {
				return Response::error("No data available");
			} else {
				return $request;
			}
		} catch (PDOException $e) {
			return Response::error($e->getMessage());
		}
	}

	public function fetchAll() {
		try {
			if (!self::$stmt->execute()) {
				Response::finish(Response::error("An unexpected error has occurred"));
			}

			$request = self::$stmt->fetchAll();

			if (!$request) {
				return Response::error("No data available");
			} else {
				return $request;
			}
		} catch (PDOException $e) {
			return Response::error($e->getMessage());
		}
	}

}