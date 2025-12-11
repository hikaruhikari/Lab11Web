<?php
// indeks.php
include("config/database.php");
require_once("views/baka.php");

// 1. Inisiasi Class Database (OOP)
$db = new Database();

// query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';

// 2. Menggunakan method query() dari Class Database
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Data Barang</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <div>
            <header>
                <h1>Data Barang</h1>
            </header>
            <div>
                <a href="modules/user/tambah.php">Tambah Barang</a>
                <table class="main">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Katagori</th>
                            <th>Harga Jual</th>
                            <th>Harga Beli</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><img src="modules/user/<?= $row['gambar'];?>" alt="<?=$row['nama'];?>" style="width: 50px;"></td>
                            <td><?= $row['nama'];?></td>
                            <td><?= $row['kategori'];?></td>
                            <td><?= number_format($row['harga_jual'], 0, ',', '.');?></td>
                            <td><?= number_format($row['harga_beli'], 0, ',', '.');?></td>
                            <td><?= $row['stok'];?></td>
                            <td>
                                <a href="modules/user/ubah.php?id=<?= $row['id_barang']; ?>">Ubah</a> |
                                <a href="modules/user/hapus.php?id=<?= $row['id_barang']; ?>" onclick="return confirm('Yakin akan menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="7">Belum ada data</td>
                            </tr>
                            <?php endif; ?>
                </table>
            </div>
            <?php require_once("views/footer.php"); ?>
        </div>
    </body>
</html>