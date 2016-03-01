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
      $test_student = new Student($name, $id, $enroll_day);
      $test_student->save();
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
      $test_student = new Student($name, $id, $enroll_day);
      //Act
      $result = $test_student->getId();
      //Assert
      $this->assertEquals($id, $result);
    }
}


 ?>
