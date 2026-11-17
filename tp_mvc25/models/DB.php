<?php

//kelas pembungkus database untuk mengelola koneksi dan query
class DB {
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    private $result;

    //konstruktor untuk mengisi konfigurasi database
    public function __construct($hostname, $username, $password, $dbname) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    //membuka koneksi ke server database mysql
    public function open() {
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
    }

    //menjalankan perintah query sql
    public function execute($query) {
        $this->result = mysqli_query($this->conn, $query);
        return $this->result;
    }

    //mengambil data hasil query baris demi baris
    public function getResult() {
        return mysqli_fetch_array($this->result);
    }

    //menutup koneksi database yang sedang aktif
    public function close() {
        mysqli_close($this->conn);
    }
}
