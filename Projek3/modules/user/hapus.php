<?php
// modules/user/hapus.php
include_once '../../config/database.php';

// 1. Buat Object Database (OOP)
$db = new Database();

$id = $_GET['id'];

// 2. Menggunakan method delete() dari Class Database
$filter = "id_barang = '{$id}'"; 
$result = $db->delete('data_barang', $filter); 

if ($result) {
    header('location: ../../indeks.php');
    exit();
} else {
    die("Gagal menghapus data. Cek koneksi atau ID."); 
}
?>