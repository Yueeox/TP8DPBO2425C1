<?php

//memasukkan definisi kelas db
require_once __DIR__ . "/DB.php";

//kelas model untuk mengelola data mata kuliah
class Courses extends DB {

    //konstruktor memanggil konstruktor induk db
    public function __construct($hostname, $username, $password, $dbname) {
        parent::__construct($hostname, $username, $password, $dbname);
    }

    //mengambil semua data mata kuliah beserta nama dosen pengampu
    public function getCourses() {
        $query = "SELECT courses.*, lecturers.name AS lecturer_name FROM courses LEFT JOIN lecturers ON courses.lecturer_id = lecturers.id ORDER BY courses.id ASC";
        return $this->execute($query);
    }

    //mengambil data satu mata kuliah berdasarkan id
    public function getCourseById($id) {
        $query = "SELECT * FROM courses WHERE id = '$id'";
        return $this->execute($query);
    }

    //menambahkan data mata kuliah baru ke database
    public function addCourse($data) {
        $course_code = $data['course_code'];
        $course_name = $data['course_name'];
        $credits = $data['credits'];
        $semester = $data['semester'];
        $lecturer_id = !empty($data['lecturer_id']) ? "'{$data['lecturer_id']}'" : "NULL";

        $query = "INSERT INTO courses (course_code, course_name, credits, semester, lecturer_id) VALUES ('$course_code', '$course_name', '$credits', '$semester', $lecturer_id)";
        return $this->execute($query);
    }

    //memperbarui data mata kuliah berdasarkan id
    public function updateCourse($id, $data) {
        $course_code = $data['course_code'];
        $course_name = $data['course_name'];
        $credits = $data['credits'];
        $semester = $data['semester'];
        $lecturer_id = !empty($data['lecturer_id']) ? "'{$data['lecturer_id']}'" : "NULL";

        $query = "UPDATE courses SET course_code = '$course_code', course_name = '$course_name', credits = '$credits', semester = '$semester', lecturer_id = $lecturer_id WHERE id = '$id'";
        return $this->execute($query);
    }

    //menghapus data mata kuliah dari database berdasarkan id
    public function deleteCourse($id) {
        $query = "DELETE FROM courses WHERE id = '$id'";
        return $this->execute($query);
    }
}
