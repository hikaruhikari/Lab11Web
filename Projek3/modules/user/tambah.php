<?php
// modules/user/tambah.php
error_reporting(E_ALL);
include_once '../../config/database.php';
// HAPUS: include_once '../../config/form.php'; 

// 1. Buat Object Database (OOP)
$db = new Database();
// HAPUS: $form = new Form(...);

if (isset($_POST['submit']))
{
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    
    // Logika upload file
    if ($file_gambar['error'] == 0)
        {
            $filename = str_replace(' ', '_',$file_gambar['name']);
            // Pastikan path penyimpanan gambar sudah benar: ../../modules/user/gambar/
            $destination = dirname(__FILE__) .'/gambar/' . $filename; 
            $gambar_path = 'gambar/' . $filename; // Path yang disimpan di DB
            
            if(move_uploaded_file($file_gambar['tmp_name'], $destination))
                {
                    $gambar = $gambar_path;
                }
        }
        
    $data = [
        // Data tidak perlu di-sanitize manual, karena sudah di dalam method insert()
        'nama' => $nama,
        'kategori' => $kategori,
        'harga_jual' => $harga_jual,
        'harga_beli' => $harga_beli,
        'stok' => $stok,
        'gambar' => $gambar 
    ];

    // 2. Menggunakan method insert() dari Class Database (OOP)
    $result = $db->insert('data_barang', $data); 

    if ($result) {
        header('location: ../../indeks.php');
        exit();
    } else {
        echo "Error: Gagal menyimpan data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tambah Barang</title>
        <link rel="stylesheet" href="../../assets/style.css">
    </head>
    <body>
        <div>
            <h1>Tambah Barang</h1>
            <div class="main">
                <form method="post" action="tambah.php" enctype="multipart/form-data">
                    <div class="input">
                        <label>Nama Barang</label>
                        <input type="text" name="nama" required />
                    </div>
                    <div class="input">
                        <label>Kategori</label>
                        <select name="kategori">
                            <option value="Komputer">Komputer</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Hand Phone">Hand Phone</option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Harga Jual</label>
                        <input type="number" name="harga_jual" required />
                    </div>
                    <div class="input">
                        <label>Harga Beli</label>
                        <input type="number" name="harga_beli" required />
                    </div>
                    <div class="input">
                        <label>Stok</label>
                        <input type="number" name="stok" required />
                    </div>
                    <div class="input">
                        <label>File Gambar</label>
                        <input type="file" name="file_gambar" />
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" value="Simpan" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>