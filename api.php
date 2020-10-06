<?php
/* DTG173G - Moment 5
 * Johannes Nilsson, HT20
 */

// Set headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
   header('Access-Control-Allow-Headers: token, Content-Type');
   header('Access-Control-Max-Age: 1728000');
   header('Content-Length: 0');
   header('Content-Type: text/plain');
   die();
}

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// Required files
require_once('config/Database.php');
require_once('classes/Course.class.php');

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
      if(!isset($id)) {
         $result = $course->read();
      } else {
         $result = $course->readSingle($id);
      }
      break;
   case 'POST':
      $data = json_decode(file_get_contents('php://input'));

      $course->name = $data->name;
      $course->code = $data->code;
      $course->progression = $data->progression;
      $course->syllabus = $data->syllabus;

      if($course->create()) {
         $result = array('message' => 'Kurs skapad');
      } else {
         $result = array('message' => 'Kunde inte skapa kurs');
      }
      break;
   case 'PUT':
      if(!isset($id)) {
         $result = array('message' => 'Ett id krävs');
      } else {
         $data = json_decode(file_get_contents('php://input'));

         $course->name = $data->name;
         $course->code = $data->code;
         $course->progression = $data->progression;
         $course->syllabus = $data->syllabus;

         if($course->update($id)) {
            $result = array('message' => 'Kurs uppdaterad');
         } else {
            $result = array('message' => 'Kunde inte uppdatera kurs');
         }
      }
      break;
   case 'DELETE':
      if(!isset($id)) {
         $result = array('message' => 'Ett id krävs');
      } else {
         if($course->delete($id)) {
            $result = array('message' => 'Kurs raderad');
         } else {
            $result = array('message' => 'Kunde inte radera kurs');
         }
      }
      break;
   default:
      http_response_code(405);
}

// Echo the result as JSON
echo json_encode($result);

// Close DB connection
$db = $database->close();