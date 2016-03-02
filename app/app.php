<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=university';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use($app){
      return $app['twig']->render('index.html.twig', array('courses' => Course::getAll(), 'students' => Student::getAll()));
    });

    $app->get("/students", function() use($app){
      return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/students", function() use($app){
      $student = new Student($id = null, $_POST['name'], $_POST['enroll_day']);
      $student->save();
      return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/students/{id}", function($id) use($app){
      $student = Student::findId();
      return $app['twig']->render('students.html.twig', array('student' => $student, 'courses' => $student->courses(), 'all_courses' => Course::getAll()));
    });

    $app->post("/add_courses", function() use($app){
      $course = Course::find($_POST['course_id']);
      $student = Student::find($_POST['student_id']);
      $student->addCourse($course);
      return $app['twig']->render('stnts.html.twig', array('student' => $student, 'students' => Student::getAll(), 'courses' => $student->courses(), 'all_courses' => Course::getAll()));
    });

    $app->post("/delete_students", function() use($app){
      Student::deleteAll();
      return $app['twig']->render('courses.html.twig');
    });

    $app->post("/delete_courses", function() use($app){
      Course::deleteAll();
      return $app['twig']->render('index.html.twig');
    });


    $app->get("/courses", function() use($app){
      return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/courses", function() use($app){
      $course = new Course($id = null, $_POST['description'], $_POST['course_number']);
      $course->save();
      return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("courses/{id}", function($id) use($app){
      $course = Course::find($id);
      return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->students(), 'all_students' => Student::getAll()));
    });

    $app->get("courses/{id}/edit", function($id) use($app){
      $course = Course::find($id);
      return $app['twig']->render('course_edit.html.twig', array('course' => $course));
    });

    $app->patch("courses/{id}", function($id) use($app){
      $description = $_POST['description'];
      $course = Course::find($id);
      $course->update($description);
      return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->students()));
    });

    $app->delete("/courses/{id}", function($id) use($app){
      $course = Course::findId();
      $course->delete();
      return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/add_students", function() use($app){
      $course = Course::find($_POST['course_id']);
      $student = Student::find($_POST['student_id']);
      $course->addStudent($student);
      return $app['twig']->render('courses.html.twig', array('course' => $course, 'courses' => Course::getAll(), 'student' => $course->students(), 'all_students' => Student::getAll()));
    });

    return $app;
 ?>
