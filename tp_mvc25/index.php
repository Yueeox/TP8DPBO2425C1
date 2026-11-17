<?php

//memasukkan berkas konfigurasi database
require_once "config.php";

//memasukkan controller dosen dan mata kuliah
require_once "controllers/lecturersController.php";
require_once "controllers/coursesController.php";

//menentukan modul halaman yang diakses
$page = isset($_GET['page']) ? $_GET['page'] : 'lecturers';

//menentukan aksi yang akan dijalankan
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

//menangkap parameter id jika tersedia
$id = isset($_GET['id']) ? $_GET['id'] : null;

//melakukan routing berdasarkan modul halaman
if ($page === 'courses') {
    //membuat instance controller mata kuliah
    $controller = new CoursesController();

    //mengarahkan ke fungsi controller yang sesuai
    if ($action === 'add') {
        $controller->add();
    } elseif ($action === 'edit' && $id !== null) {
        $controller->edit($id);
    } elseif ($action === 'delete' && $id !== null) {
        $controller->delete($id);
    } else {
        $controller->index();
    }
} else {
    //membuat instance controller dosen sebagai default
    $controller = new LecturersController();

    //mengarahkan ke fungsi controller yang sesuai
    if ($action === 'add') {
        $controller->add();
    } elseif ($action === 'edit' && $id !== null) {
        $controller->edit($id);
    } elseif ($action === 'delete' && $id !== null) {
        $controller->delete($id);
    } else {
        $controller->index();
    }
}
