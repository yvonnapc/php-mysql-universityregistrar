<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Student.php";

$server = 'mysql:host=localhost;dbname=university_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StudentTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Student::deleteAll();
    }
    function test_getName()
    {
      //Arrange
      $name = "Yvonna Contreras";
      $id = null;
      $enroll_day = "2016-03-01";
      $test_student = new Student($id, $name, $enroll_day);

      //Act
      $result = $test_student->getName($name);
      //Assert
      $this->assertEquals($name, $result);
    }
    function test_getId()
    {
      $name = "Michael";
      $id = null;
      $enroll_day = "2016-03-03";
      $test_student = new Student($id, $name, $enroll_day);
      //Act
      $result = $test_student->getId();
      //Assert
      $this->assertEquals($id, $result);
    }
    function test_getEnrollDay()
    {
      $name = "Michael";
      $id = null;
      $enroll_day = "2016-03-03";
      $test_student = new Student($id, $name,  $enroll_day);

      //Act
      $result = $test_student->getEnrollDay($enroll_day);
      //Assert
      $this->assertEquals("2016-03-03", $result);
    }
    function test_save()
    {
      //Arrange
      $id = null;
      $name = "Michael";
      $enroll_day = "2016-03-03";
      $test_student = new Student($id, $name, $enroll_day);
      $test_student->save();
      //Act
      $result = Student::getAll();
      //Assert
      $this->assertEquals($test_student, $result[0]);
    }
    function test_getAll()
    {
      $name = "Michael";
      $id = null;
      $enroll_day = "2016-03-03";
      $test_student = new Student($id, $name, $enroll_day);
      $test_student->save();
      
      $name2 = "Yvonna";
      $enroll_day2 = "2016-03-03";
      $test_student2 = new Student($id, $name2, $enroll_day2);
      $test_student2->save();

      //Act
      $result = Student::getAll();

      //Assert
      $this->assertEquals([$test_student, $test_student2], $result);
    }
}


 ?>
