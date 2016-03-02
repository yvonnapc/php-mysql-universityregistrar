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
    function courses()
    {
        $matching_courses = $GLOBALS['DB']->query("SELECT courses.* FROM students
                        JOIN semester ON (students.id = semester.student_id)
                        JOIN courses ON (semester.course_id = course.id)
                        WHERE students.id = {$this->getId()}");
        $courses = array();
        foreach($matching_courses as $course){
          $id = $course['id'];
          $description = $course['description'];
          $course_number = $course['course_number'];
          $new_course = new Course($id, $description, $course_number);
          array_push($courses, $new_course);
        }
        return $courses;
    }
    static function find($search_id)
    {
      $found_student = null;
      $students = Student::getAll();
      foreach($students as $student)
      {
        $student_id = $student->getId();
        if ($student_id == $search_id) {
          $found_student = $student;
        }
      }
      return $found_student;
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
