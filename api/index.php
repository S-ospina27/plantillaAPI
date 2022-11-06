<?php
// -------------------------------------------------------------------------------------------------
include_once("./imports.php");
// -------------------------------------------------------------------------------------------------
Request::header("Access-Control-Allow-Origin", "*");
Request::header("Content-Type", "application/json; charset=UTF-8");
Connection::init(
	// "localhost", "u804519145_e_box", "u804519145_e_box", "IyQCuB~5"
	"127.0.0.1", "u804519145_e_box", "root", ""
);

$request = (new Request())->capture();
$response = new Response();
// -------------------------------------------------------------------------------------------------
Validate::init($request, $response);
Validate::exists("type", "La ruta no existe [1]");

switch ($request->type) {
	case 'example':
	$response->finish("TEST");
	break;

	default:
	$response->finish($response->error("La ruta no existe [2]"));
	break;
}