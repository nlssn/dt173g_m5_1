<?php
/* DTG173G - Moment 5
 * Johannes Nilsson, HT20
 */

// Required files
require_once('config/Database.php');
require_once('classes/Course.class.php');

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
$dbConn = $database->connect();

// Course instance
$course = new Course($dbConn);

// Depending on which request method is used, return or manipulate data
switch($method) {
   case 'GET':
      if(isset($id)) {
         $result = $course->readSingle($id);
      } else {
         $result = $course->read();
      }
      break;
}

// Echo the result as JSON
echo json_encode($result);

// Close DB connection
$db = $database->close();