<?php

//memasukkan berkas konfigurasi, model, dan view yang diperlukan
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../models/Lecturers.php";
require_once __DIR__ . "/../views/LecturerView.php";

//kelas kontroler untuk mengelola logika data dosen
class LecturersController {
    private $lecturer;
    private $view;

    //konstruktor untuk inisialisasi model dan view dosen
    public function __construct() {
        $this->lecturer = new Lecturers(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->view = new LecturerView();
    }

    //menampilkan daftar seluruh dosen
    public function index() {
        $this->lecturer->open();
        $this->lecturer->getLecturers();
        $data = [];
        while ($row = $this->lecturer->getResult()) {
            $data[] = $row;
        }
        $this->lecturer->close();

        $this->view->render($data);
    }

    //menangani proses penambahan data dosen baru
    public function add() {
        if (isset($_POST['submit'])) {
            $this->lecturer->open();
            $this->lecturer->addLecturer($_POST);
            $this->lecturer->close();
            header("Location: index.php?page=lecturers");
            exit();
        } else {
            $this->view->renderForm();
        }
    }

    //menangani proses pengubahan data dosen
    public function edit($id) {
        if (isset($_POST['submit'])) {
            $this->lecturer->open();
            $this->lecturer->updateLecturer($id, $_POST);
            $this->lecturer->close();
            header("Location: index.php?page=lecturers");
            exit();
        } else {
            $this->lecturer->open();
            $this->lecturer->getLecturerById($id);
            $data = $this->lecturer->getResult();
            $this->lecturer->close();

            $this->view->renderForm($data);
        }
    }

    //menangani proses penghapusan data dosen
    public function delete($id) {
        $this->lecturer->open();
        $this->lecturer->deleteLecturer($id);
        $this->lecturer->close();
        header("Location: index.php?page=lecturers");
        exit();
    }
}
