<?php
class Course {
   // Connection
   private $conn;

   // DB table
   private $table = 'courses';

   // DB columns
   public $id;
   public $name;
   public $code;
   public $progression;
   public $syllabus;

   // Constructor (takes in the DB connection as a parameter)
   public function __construct($dbConn) {
      $this->conn = $dbConn;
   }

   // READ
   public function read() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $num = $stmt->rowCount();

      if ($num > 0) {
         $courses = array();
         $courses['data'] = array();
         $courses['itemCount'] = $num;

         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row); // extract data from row as variables

            $c = array(
               'id' => $id,
               'name' => $name,
               'code' => $code,
               'progression' => $progression,
               'syllabus' => $syllabus
            );

            array_push($courses['data'], $c);
         }

         return $courses;
      } else {
         return array('message' => 'Inga kurser hittades');
      }
   }
}