<?php

//kelas untuk memproses dan merender berkas template html
class Template {
    private $filename = '';
    private $content = '';

    //konstruktor untuk membaca berkas template ke dalam properti konten
    public function __construct($filename = '') {
        $this->filename = $filename;
        $this->loadTemplate();
    }

    //membaca isi berkas template jika berkas ada
    public function loadTemplate() {
        if (!empty($this->filename) && file_exists($this->filename)) {
            $this->content = file_get_contents($this->filename);
        }
    }

    //mengganti teks pola tertentu pada template dengan nilai dinamis
    public function replace($old = '', $new = '') {
        $this->content = str_replace($old, $new, $this->content);
    }

    //mencetak hasil akhir render html ke layar pengguna
    public function write() {
        echo $this->content;
    }

    //mengembalikan teks konten html hasil pemrosesan
    public function getContent() {
        return $this->content;
    }
}
