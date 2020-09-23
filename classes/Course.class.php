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
         $data = array();
         $data['data'] = array();
         $data['itemCount'] = $num;

         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row); // extract data from row as variables

            $course = array(
               'id' => $id,
               'name' => $name,
               'code' => $code,
               'progression' => $progression,
               'syllabus' => $syllabus
            );

            array_push($data['data'], $course);
         }

         return $data;
      } else {
         return array('message' => 'Hittade inga kurser');
      }
   }

   // READ SINGLE
   public function readSingle($id) {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ' . $id . ' LIMIT 1';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if($data) {
         return $data;
      } else {
         return array('message' => 'Hittade ingen kurs med angivet ID');
      }
   }

   // CREATE
   public function create() {
      $query = 'INSERT INTO 
                  ' . $this->table . '
                  SET
                     name = :name,
                     code = :code,
                     progression = :progression,
                     syllabus = :syllabus';
      $stmt = $this->conn->prepare($query);
      
      // Sanitize input
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->code = htmlspecialchars(strip_tags($this->code));
      $this->progression = htmlspecialchars(strip_tags($this->progression));
      $this->syllabus = htmlspecialchars(strip_tags($this->syllabus));

      // Bind data to params
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':code', $this->code);
      $stmt->bindParam(':progression', $this->progression);
      $stmt->bindParam(':syllabus', $this->syllabus);

      if($stmt->execute()) {
         return true;
      }

      return false;
   }

   
}


