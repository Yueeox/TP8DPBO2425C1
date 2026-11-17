<?php

//memasukkan berkas konfigurasi, model, dan view yang diperlukan
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../models/Courses.php";
require_once __DIR__ . "/../models/Lecturers.php";
require_once __DIR__ . "/../views/CoursesView.php";

//kelas kontroler untuk mengelola logika data mata kuliah
class CoursesController {
    private $course;
    private $lecturer;
    private $view;

    //konstruktor untuk inisialisasi model dan view mata kuliah
    public function __construct() {
        $this->course = new Courses(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->lecturer = new Lecturers(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->view = new CoursesView();
    }

    //menampilkan daftar seluruh mata kuliah
    public function index() {
        $this->course->open();
        $this->course->getCourses();
        $data = [];
        while ($row = $this->course->getResult()) {
            $data[] = $row;
        }
        $this->course->close();

        $this->view->render($data);
    }

    //menangani proses penambahan data mata kuliah baru
    public function add() {
        if (isset($_POST['submit'])) {
            $this->course->open();
            $this->course->addCourse($_POST);
            $this->course->close();
            header("Location: index.php?page=courses");
            exit();
        } else {
            $this->lecturer->open();
            $this->lecturer->getLecturers();
            $lecturers = [];
            while ($row = $this->lecturer->getResult()) {
                $lecturers[] = $row;
            }
            $this->lecturer->close();

            $this->view->renderForm(null, $lecturers);
        }
    }

    //menangani proses pengubahan data mata kuliah
    public function edit($id) {
        if (isset($_POST['submit'])) {
            $this->course->open();
            $this->course->updateCourse($id, $_POST);
            $this->course->close();
            header("Location: index.php?page=courses");
            exit();
        } else {
            $this->course->open();
            $this->course->getCourseById($id);
            $courseData = $this->course->getResult();
            $this->course->close();

            $this->lecturer->open();
            $this->lecturer->getLecturers();
            $lecturers = [];
            while ($row = $this->lecturer->getResult()) {
                $lecturers[] = $row;
            }
            $this->lecturer->close();

            $this->view->renderForm($courseData, $lecturers);
        }
    }

    //menangani proses penghapusan data mata kuliah
    public function delete($id) {
        $this->course->open();
        $this->course->deleteCourse($id);
        $this->course->close();
        header("Location: index.php?page=courses");
        exit();
    }
}
