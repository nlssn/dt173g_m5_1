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
      $query = 'SELECT id, name, code, progression, syllabus FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
   }

}