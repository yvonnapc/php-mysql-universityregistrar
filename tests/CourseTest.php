<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_getDescription()
        {
            //Arrange
            $id = NULL;
            $description = "History 1";
            $course_number = "HIST100";
            $test_course = new Course($id, $description, $course_number);

            //Act
            $result = $test_course->getDescription($description);

            //Assert
            $this->assertEquals("History 1", $result);
        }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $description = "History 1";
            $course_number = "HIST100";
            $test_course = new Course($id, $description, $course_number);

            //Act
            $result = $test_course->getId($id);

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_getNumber()
        {
            //Arrange
            $id = 1;
            $description = "History 1";
            $course_number = "HIST100";
            $test_course = new Course($id, $description, $course_number);

            //Act
            $result = $test_course->getCourseNumber($course_number);

            //Assert
            $this->assertEquals("HIST100", $result);
        }

        function test_save()
        {
            //Arrange
            $id = NULL;
            $description = "History 1";
            $course_number = "HIST100";
            $test_course = new Course($id, $description, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $id = NULL;
            $description = "History 1";
            $course_number = "HIST100";
            $test_course = new Course($id, $description, $course_number);
            $test_course->save();
            $description2 = "Art 1";
            $course_number2 = "ART100";
            $test_course2 = new Course($id, $description2, $course_number2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }
        function test_deleteAll()
        {
          //Arrange
          $id = null;
          $description = "History";
          $course_number = "200";
          $test_course = new Course($id, $description, $course_number);
          $test_course->save();

          $description2 = "Biology";
          $course_number2 = "300";
          $test_course2 = new Course($id, $description, $course_number);
          $test_course2->save();
          //Act
          Course::deleteAll();
          $result = Course::getAll();
          //Assert
          $this->assertEquals([], $result);
        }
        function test_addStudent()
        {
          //Arrange
          $id = null;
          $description = "History";
          $course_number = "200";
          $test_course = new Course($id, $description, $course_number);
          $test_course->save();

          $name = "Yvonna";
          $id = null;
          $enroll_day = "2016-04-03";
          $test_student = new Student($name, $id, $enroll_day);
          $test_student->save();
          //Act
          $test_course->addStudent($test_student);
          //Assert
          $this->assertEquals([$test_student], $test_course->students());
        }
        function testUpdate()
        {
          //Arrange
          $id = null;
          $description = "History";
          $course_number = "300";
          $test_course = new Course($id, $description, $course_number);
          $test_course->save();

          $new_description = "Womens History";
          //Act
          $test_course->update($new_description);
          //Assert
          $this->assertEquals("Womens History", $test_course->getDescription());
        }

    }

?>
