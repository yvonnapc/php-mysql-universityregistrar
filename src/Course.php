<?php

class Course {
    private $id;
    private $description;
    private $course_number;


    function __construct($id = null, $description, $course_number)
    {
        $this->id = $id;
        $this->description = $description;
        $this->course_number = $course_number;
    }
    function getId()
    {
        return $this->id;
    }
    function setDescription($description)
    {
        $this->description = $description;
    }
    function getDescription()
    {
        return $this->description;
    }
    function setCourseNumber($course_number)
    {
        $this->course_number = $course_number;
    }
    function getCourseNumber()
    {
        return $this->course_number;
    }
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO courses (description, course_number) VALUES ('{$this->getDescription()}', '{$this->getCourseNumber()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }
    static function getAll()
    {
      $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses");
      $courses = array();
      foreach ($returned_courses as $course){
        $id = $course['id'];
        $description = $course['description'];
        $course_number = $course['course_number'];
        $new_course = new Course($id, $description, $course_number);
        array_push($courses, $new_course);
      }
      return $courses;
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM courses");
    }
    function addStudent($student)
    {
      $GLOBALS['DB']->exec("INSERT INTO semester (student_id, course_id) VALUES ({$this->getId()}, {$student->getId()});");
    }
    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM semester WHERE course_id = {$this->getId()};");
    }
}

?>
