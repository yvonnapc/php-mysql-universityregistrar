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
    static function find($search_id)
    {
      $found_course = null;
      $courses = Course::getAll();
      foreach($courses as $course)
      {
        $course_id = $course->getId();
        if ($course_id == $search_id) {
          $found_course = $course;
        }
      }
      return $found_course;
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM courses");
    }
    function addStudent($student)
    {
      $GLOBALS['DB']->exec("INSERT INTO semester (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
    }
    function students()
    {
      $matching_students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                      JOIN semester ON (courses.id = semester.course_id)
                      JOIN students ON (semester.student_id = students.id)
                      WHERE courses.id = {$this->getId()}");
      $students = array();
      foreach($matching_students as $student){
        $id = $student['id'];
        $name = $student['name'];
        $enroll_day = $student['enroll_day'];
        $new_student = new Student($id, $name, $enroll_day);
        array_push($students, $new_student);
      }
      return $students;
    }
    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM semester WHERE course_id = {$this->getId()};");
    }
    function update($new_description)
    {
      $GLOBALS['DB']->exec("UPDATE courses SET description = '{$new_description}' WHERE id = {$this->getId()};");
      $this->setDescription($new_description);
    }
}

?>
