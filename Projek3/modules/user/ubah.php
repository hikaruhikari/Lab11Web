<?php
// modules/user/ubah.php
error_reporting(E_ALL);
include_once '../../config/database.php';
// HAPUS: include_once '../../config/form.php'; 

// 1. Buat Object Database (OOP)
$db = new Database();
// HAPUS: $form = new Form(...);

if (isset($_POST['submit']))
    {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $kategori = $_POST['kategori'];
        $harga_jual = $_POST['harga_jual'];
        $harga_beli = $_POST['harga_beli'];
        $stok = $_POST['stok'];
        $file_gambar = $_FILES['file_gambar'];
        $gambar = null;
        
        // Logika upload file
        if ($file_gambar['error'] == 0 && !empty($file_gambar['name']))
            {
                $filename = str_replace(' ', '_', $file_gambar['name']);
                $destination = dirname(__FILE__) . '/gambar/' . $filename;
                $gambar_path = 'gambar/' . $filename; // Path yang disimpan di DB

                if (move_uploaded_file($file_gambar['tmp_name'], $destination))
                    {
                        $gambar = $gambar_path;
                    }
            }
        
        $data = [
            'nama' => $nama,
            'kategori' => $kategori,
            'harga_jual' => $harga_jual,
            'harga_beli' => $harga_beli,
            'stok' => $stok
        ];
        
        if (!empty($gambar)) {
            $data['gambar'] = $gambar;
        }

        // 2. Menggunakan method update() dari Class Database
        $where = "id_barang = '{$id}'";
        $result = $db->update('data_barang', $data, $where); 

        if ($result) {
            header('location: ../../indeks.php'); exit();
        } else {
            die("Gagal memperbarui data. Cek koneksi atau query.");
        }
    }

// === PROSES AMBIL DATA (GET) ===
$id = $_GET['id'];

// 3. Menggunakan method get() dari Class Database
$data = $db->get('data_barang', "id_barang = '{$id}'"); 

if (!$data) die('Error: Data tidak tersedia');

function is_select($var, $val) {
    if ($var == $val) return 'selected="selected"';
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="../../assets/style.css" rel="stylesheet" type="text/css" />
        <title>Ubah Barang</title>
    </head>
    <body>
        <div id="container">
            <h1>Ubah Barang</h1>
            <div class="main">
                <form method="post" action="ubah.php" enctype="multipart/form-data">
                    <div class="input">
                        <label>Nama Barang</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']);?>" required />
                    </div>
                    <div class="input">
                        <label>Kategori</label>
                        <select name="kategori">
                            <option <?php echo is_select ('Komputer', $data['kategori']);?> value="Komputer">Komputer</option>
                            <option <?php echo is_select ('Elektronik', $data['kategori']);?> value="Elektronik">Elektronik</option>
                            <option <?php echo is_select ('Hand Phone', $data['kategori']);?> value="Hand Phone">Hand Phone</option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Harga Jual</label>
                        <input type="number" name="harga_jual" value="<?php echo htmlspecialchars($data['harga_jual']);?>" required />
                        </div>
                        <div class="input">
                            <label>Harga Beli</label>
                            <input type="number" name="harga_beli" value="<?php echo htmlspecialchars($data['harga_beli']);?>" required />
                        </div>
                        <div class="input">
                            <label>Stok</label>
                            <input type="number" name="stok" value="<?php echo htmlspecialchars($data['stok']);?>" required />
                        </div>
                        <div class="input">
                            <label>File Gambar (Kosongkan jika tidak diubah)</label>
                            <input type="file" name="file_gambar" />
                        </div>
                        <div class="submit">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id_barang']);?>" />
                            <input type="submit" name="submit" value="Simpan" />
                        </div>
                </form>
            </div>
        </div>
    </body>
</html>