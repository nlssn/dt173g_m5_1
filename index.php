<?php
/* DTG173G - Moment 5
 * Johannes Nilsson, HT20
 */

// Required files
require_once('config/Database.php');

// Set CORS headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Save the request method for later use
$method = $_SERVER['REQUEST_METHOD'];

// If a param of ID is set, save that too
if(isset($_GET['id'])) {
   $id = $_GET['id'];
}

// Database instance
$database = new Database();
$db = $database->connect();

// Depending on which request method is used, return or manipulate data
switch($method) {
   case 'GET':
      if(isset($id)) {
         $result = array('message' => 'En enskild kurs');
      } else {
         $result = array('message' => 'Alla kurser');
      }
      break;
}

// Echo the result as JSON
echo json_encode($result);