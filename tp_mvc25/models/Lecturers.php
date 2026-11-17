<?php

//memasukkan definisi kelas db
require_once __DIR__ . "/DB.php";

//kelas model untuk mengelola data dosen
class Lecturers extends DB {

    //konstruktor memanggil konstruktor induk db
    public function __construct($hostname, $username, $password, $dbname) {
        parent::__construct($hostname, $username, $password, $dbname);
    }

    //mengambil semua data dosen dari database
    public function getLecturers() {
        $query = "SELECT * FROM lecturers ORDER BY id ASC";
        return $this->execute($query);
    }

    //mengambil data satu dosen berdasarkan id
    public function getLecturerById($id) {
        $query = "SELECT * FROM lecturers WHERE id = '$id'";
        return $this->execute($query);
    }

    //menambahkan data dosen baru ke database
    public function addLecturer($data) {
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        $query = "INSERT INTO lecturers (name, nidn, phone, join_date) VALUES ('$name', '$nidn', '$phone', '$join_date')";
        return $this->execute($query);
    }

    //memperbarui data dosen berdasarkan id
    public function updateLecturer($id, $data) {
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        $query = "UPDATE lecturers SET name = '$name', nidn = '$nidn', phone = '$phone', join_date = '$join_date' WHERE id = '$id'";
        return $this->execute($query);
    }

    //menghapus data dosen dari database berdasarkan id
    public function deleteLecturer($id) {
        $query = "DELETE FROM lecturers WHERE id = '$id'";
        return $this->execute($query);
    }
}
