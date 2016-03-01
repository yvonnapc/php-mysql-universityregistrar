<?php

class Student
{
  private $name;
  private $id;
  private $enroll_day;

    function __construct ($name, $id = null, $enroll_day)
    {
      $this->name = $name;
      $this->id = $id;
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
    function getAll()
    {
      $returned_students = $GLOBALS['DB']->query("SELECT * FROM students");

      $students = array();
      foreach($returned_students as $student){
        $name = $student['name'];
        $id = $student['id'];
        $enroll_day = $student['enroll_day'];
        $new_student = new Student ($name, $id, $enroll_day);
        array_push($students, $new_student);
      }
      return $students;
    }
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO students (name, id, enroll_day) VALUES ('{$this->getName()}', '{$this->getEnrollDay()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM students;");
    }

}

 ?>
