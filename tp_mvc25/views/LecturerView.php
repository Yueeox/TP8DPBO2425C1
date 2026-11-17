<?php

//memasukkan definisi kelas template
require_once __DIR__ . "/Template.php";

//kelas view untuk mengelola tampilan data dosen
class LecturerView {

    //merender tampilan tabel daftar dosen
    public function render($data) {
        //membuat instance template untuk halaman daftar
        $template = new Template("templates/index.html");

        //menyiapkan navigasi dan judul halaman
        $template->replace("DATA_TITLE", "Daftar Dosen");
        $template->replace("DATA_NAV_LECTURERS", "active");
        $template->replace("DATA_NAV_COURSES", "");
        $template->replace("DATA_ADD_BUTTON", "<a href='index.php?page=lecturers&action=add' class='btn btn-primary'>Tambah Dosen</a>");

        //menyiapkan baris header tabel
        $thead = "<tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NIDN</th>
                    <th>No. Telepon</th>
                    <th>Tanggal Bergabung</th>
                    <th>Aksi</th>
                  </tr>";
        $template->replace("DATA_THEAD", $thead);

        //menyusun data baris tabel dari data dosen
        $tbody = "";
        if (empty($data)) {
            $tbody = "<tr><td colspan='6' class='text-center'>Tidak ada data dosen.</td></tr>";
        } else {
            foreach ($data as $row) {
                $tbody .= "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['nidn']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['join_date']}</td>
                            <td>
                                <a class='btn btn-success btn-sm' href='index.php?page=lecturers&action=edit&id={$row['id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='index.php?page=lecturers&action=delete&id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus dosen ini?');\">Delete</a>
                            </td>
                          </tr>";
            }
        }
        $template->replace("DATA_TBODY", $tbody);

        //menampilkan hasil render template ke browser
        $template->write();
    }

    //merender tampilan formulir tambah atau edit dosen
    public function renderForm($data = null) {
        //membuat instance template untuk halaman formulir
        $template = new Template("templates/form.html");

        //menentukan mode tambah atau edit berdasarkan keberadaan data
        $isEdit = !empty($data);
        $title = $isEdit ? "Edit Dosen" : "Tambah Dosen";
        $action = $isEdit ? "index.php?page=lecturers&action=edit&id={$data['id']}" : "index.php?page=lecturers&action=add";

        //menyiapkan nilai awal atribut formulir
        $name = $isEdit ? htmlspecialchars($data['name']) : "";
        $nidn = $isEdit ? htmlspecialchars($data['nidn']) : "";
        $phone = $isEdit ? htmlspecialchars($data['phone']) : "";
        $join_date = $isEdit ? htmlspecialchars($data['join_date']) : "";

        //mengganti placeholder informasi dasar formulir
        $template->replace("DATA_FORM_TITLE", $title);
        $template->replace("DATA_NAV_LECTURERS", "active");
        $template->replace("DATA_NAV_COURSES", "");
        $template->replace("DATA_FORM_ACTION", $action);
        $template->replace("DATA_CANCEL_URL", "index.php?page=lecturers");

        //menyusun elemen input formulir
        $inputs = "
            <div class='mb-3'>
                <label for='name' class='form-label'>Nama Dosen</label>
                <input type='text' class='form-control' id='name' name='name' value='{$name}' required>
            </div>
            <div class='mb-3'>
                <label for='nidn' class='form-label'>NIDN</label>
                <input type='text' class='form-control' id='nidn' name='nidn' value='{$nidn}' required>
            </div>
            <div class='mb-3'>
                <label for='phone' class='form-label'>No. Telepon</label>
                <input type='text' class='form-control' id='phone' name='phone' value='{$phone}'>
            </div>
            <div class='mb-3'>
                <label for='join_date' class='form-label'>Tanggal Bergabung</label>
                <input type='date' class='form-control' id='join_date' name='join_date' value='{$join_date}' required>
            </div>
        ";
        $template->replace("DATA_FORM_INPUTS", $inputs);

        //menampilkan formulir ke layar pengguna
        $template->write();
    }
}
