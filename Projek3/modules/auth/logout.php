<?php
session_start();
$header_path = "../../views/baka.php";
$footer_path = "../../views/footer.php";
$login_path = "login.php";
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: $login_path"); 
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'logout_now') {
    $_SESSION = [];
    session_destroy();
    header("Location: $login_path"); 
    exit();
}
require_once($header_path);
?>
<div class="container" style="padding: 20px;">
    <h2>Konfirmasi Keluar</h2>
    <p>Halo, **<?= htmlspecialchars($_SESSION['nama']) ?>**. Apakah Anda yakin ingin **keluar (logout)** dari akun Anda?</p>
    <div style="margin-top: 20px;">
        <a href="?action=logout_now" style="text-decoration: none; padding: 10px 20px; background-color: #dc3545; color: white; border-radius: 5px;">
            Ya, Keluar Sekarang
        </a>
        <a href="javascript:history.back()" style="text-decoration: none; padding: 10px 20px; background-color: #6c757d; color: white; border-radius: 5px; margin-left: 10px;">
            Tidak, Kembali
        </a>
    </div>
</div>
<?php
require_once($footer_path);
?>