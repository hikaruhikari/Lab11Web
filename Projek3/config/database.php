<?php
// config/database.php (Versi OOP)

class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct() {
        // Panggil konfigurasi dari config.php
        $this->getConfig();
        
        // Menggunakan mysqli() dalam bentuk OOP untuk koneksi
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    private function getConfig() {
        // Path include config.php disesuaikan berada di folder yang sama
        include_once("config.php"); 
        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }

    // Mengambil semua hasil query (digunakan di indeks.php)
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    // Mengambil satu baris data (digunakan di ubah.php)
    public function get($table, $where=null) {
        if ($where) {
            $where = " WHERE " . $where;
        }
        $sql = "SELECT * FROM " . $table . $where;
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    // Menyimpan data (digunakan di tambah.php)
    public function insert($table, $data) {
        $column = [];
        $value = [];
        if (is_array($data)) {
            foreach($data as $key => $val) {
                // **SANITASI DATA** menggunakan real_escape_string (PENTING!)
                $val_bersih = $this->conn->real_escape_string($val ?? ''); 
                $column[] = $key;
                $value[] = "'{$val_bersih}'";
            }
            $columns = implode(",", $column);
            $values = implode(",", $value);
        } else {
             return false;
        }
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        return $this->conn->query($sql);
    }

    // Memperbarui data (digunakan di ubah.php)
    public function update($table, $data, $where) {
        $update_value = [];
        if (is_array($data)) {
            foreach($data as $key => $val) {
                // **SANITASI DATA**
                $val_bersih = $this->conn->real_escape_string($val ?? ''); 
                $update_value[] = "$key='{$val_bersih}'";
            }
            $update_value = implode(",", $update_value);
        } else {
             return false;
        }
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        return $this->conn->query($sql);
    }
    
    // Menghapus data (digunakan di hapus.php)
    public function delete($table, $filter) {
        $sql = "DELETE FROM " . $table . " WHERE " . $filter;
        return $this->conn->query($sql);
    }
}
?>