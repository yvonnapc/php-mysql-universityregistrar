<?php

class Student
{
  private $name;
  private $id;
  private $enroll_day;

    function __construct ($id = null, $name,  $enroll_day)
    {
      $this->id = $id;
      $this->name = $name;
      $this->enroll_day = $enroll_day;

    }
    function setName($new_name)
    {
      $this->name = (string) $new_name;
    }
    function getName()
    {
      return $this->name;
    }
    function getId()
    {
      return $this->id;
    }
    function getEnrollDay()
    {
      return $this->enroll_day;
    }
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO students (name, enroll_day) VALUES ('{$this->getName()}', '{$this->getEnrollDay()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }
    static function getAll()
    {
      $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");

      $students = array();
      foreach($returned_students as $student){
        $id = $student['id'];
        $name = $student['name'];
        $enroll_day = $student['enroll_day'];
        $new_student = new Student ($id, $name,  $enroll_day);
        array_push($students, $new_student);
      }
      return $students;
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM students;");
    }

}

 ?>
