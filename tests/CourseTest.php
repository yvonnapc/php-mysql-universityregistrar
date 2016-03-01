<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
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

    }

?>
