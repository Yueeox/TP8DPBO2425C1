<?php

//memasukkan definisi kelas template
require_once __DIR__ . "/Template.php";

//kelas view untuk mengelola tampilan data mata kuliah
class CoursesView {

    //merender tampilan tabel daftar mata kuliah
    public function render($data) {
        //membuat instance template untuk halaman daftar
        $template = new Template("templates/index.html");

        //menyiapkan navigasi dan judul halaman
        $template->replace("DATA_TITLE", "Daftar Mata Kuliah");
        $template->replace("DATA_NAV_LECTURERS", "");
        $template->replace("DATA_NAV_COURSES", "active");
        $template->replace("DATA_ADD_BUTTON", "<a href='index.php?page=courses&action=add' class='btn btn-primary'>Tambah Mata Kuliah</a>");

        //menyiapkan baris header tabel
        $thead = "<tr>
                    <th>ID</th>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Dosen Pengampu</th>
                    <th>Aksi</th>
                  </tr>";
        $template->replace("DATA_THEAD", $thead);

        //menyusun data baris tabel dari data mata kuliah
        $tbody = "";
        if (empty($data)) {
            $tbody = "<tr><td colspan='7' class='text-center'>Tidak ada data mata kuliah.</td></tr>";
        } else {
            foreach ($data as $row) {
                $lecturerName = !empty($row['lecturer_name']) ? $row['lecturer_name'] : "-";
                $tbody .= "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['course_code']}</td>
                            <td>{$row['course_name']}</td>
                            <td>{$row['credits']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$lecturerName}</td>
                            <td>
                                <a class='btn btn-success btn-sm' href='index.php?page=courses&action=edit&id={$row['id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='index.php?page=courses&action=delete&id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus mata kuliah ini?');\">Delete</a>
                            </td>
                          </tr>";
            }
        }
        $template->replace("DATA_TBODY", $tbody);

        //menampilkan hasil render template ke browser
        $template->write();
    }

    //merender tampilan formulir tambah atau edit mata kuliah
    public function renderForm($data = null, $lecturers = []) {
        //membuat instance template untuk halaman formulir
        $template = new Template("templates/form.html");

        //menentukan mode tambah atau edit berdasarkan keberadaan data
        $isEdit = !empty($data);
        $title = $isEdit ? "Edit Mata Kuliah" : "Tambah Mata Kuliah";
        $action = $isEdit ? "index.php?page=courses&action=edit&id={$data['id']}" : "index.php?page=courses&action=add";

        //menyiapkan nilai awal atribut formulir
        $course_code = $isEdit ? htmlspecialchars($data['course_code']) : "";
        $course_name = $isEdit ? htmlspecialchars($data['course_name']) : "";
        $credits = $isEdit ? htmlspecialchars($data['credits']) : "";
        $semester = $isEdit ? htmlspecialchars($data['semester']) : "";
        $selectedLecturer = $isEdit ? $data['lecturer_id'] : "";

        //mengganti placeholder informasi dasar formulir
        $template->replace("DATA_FORM_TITLE", $title);
        $template->replace("DATA_NAV_LECTURERS", "");
        $template->replace("DATA_NAV_COURSES", "active");
        $template->replace("DATA_FORM_ACTION", $action);
        $template->replace("DATA_CANCEL_URL", "index.php?page=courses");

        //menyusun pilihan dropdown dosen pengampu
        $lecturerOptions = "<option value=''>-- Pilih Dosen Pengampu --</option>";
        foreach ($lecturers as $lec) {
            $isSelected = ($lec['id'] == $selectedLecturer) ? "selected" : "";
            $lecturerOptions .= "<option value='{$lec['id']}' {$isSelected}>{$lec['name']}</option>";
        }

        //menyusun elemen input formulir
        $inputs = "
            <div class='mb-3'>
                <label for='course_code' class='form-label'>Kode Mata Kuliah</label>
                <input type='text' class='form-control' id='course_code' name='course_code' value='{$course_code}' required>
            </div>
            <div class='mb-3'>
                <label for='course_name' class='form-label'>Nama Mata Kuliah</label>
                <input type='text' class='form-control' id='course_name' name='course_name' value='{$course_name}' required>
            </div>
            <div class='mb-3'>
                <label for='credits' class='form-label'>SKS</label>
                <input type='number' class='form-control' id='credits' name='credits' value='{$credits}' min='1' max='6' required>
            </div>
            <div class='mb-3'>
                <label for='semester' class='form-label'>Semester</label>
                <input type='number' class='form-control' id='semester' name='semester' value='{$semester}' min='1' max='8' required>
            </div>
            <div class='mb-3'>
                <label for='lecturer_id' class='form-label'>Dosen Pengampu</label>
                <select class='form-select' id='lecturer_id' name='lecturer_id'>
                    {$lecturerOptions}
                </select>
            </div>
        ";
        $template->replace("DATA_FORM_INPUTS", $inputs);

        //menampilkan formulir ke layar pengguna
        $template->write();
    }
}
