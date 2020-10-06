<?php
/* DTG173G - Moment 5
 * Johannes Nilsson, HT20
 */

// Required files
require_once('config/Database.php');
require_once('classes/Course.class.php');

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
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