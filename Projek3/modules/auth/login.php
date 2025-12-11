<?php
session_start();
$peng = [
    "namira@gmail.com" => ["id" => 1, "nama" => "Namira Shinta", "password" => "namira123", "role" => "User"],
    "leni@gmail.com" => ["id" => 2, "nama" => "leni Jamilah", "password" => "leni456", "role" => "User"],
    "wafa@gmail.com" => ["id" => 3, "nama" => "Wafa Khoirunnisa", "password" => "wafa789", "role" => "Admin"]
];
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (array_key_exists($email, $peng)) {
        $user = $peng[$email];

        if ($user['password'] === $password) { 
            
            $_SESSION['login'] = true;
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            header('Location: ../../views/dashboard.php'); 
            exit();
        }
    }
    
    $error_message = "Email atau password salah. Cek akun hardcoded di bawah.";
}

require_once("../../views/baka.php");
?>

<div>
    <h2>Login Dulu</h2>
    
    <?php if ($error_message): ?>
        <div class="error">
            <?= $error_message ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="input">
            <label for="username">Email</label>
            <input type="text" id="username" name="username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>
        <div class="input">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="submit">
            <input type="submit" value="Login">
        </div>
        <p>
            Akun untuk Coba:<br>
            - Admin: <strong>wafa@gmail.com</strong> / <strong>wafa789</strong><br>
            - User: <strong>namira@gmail.com</strong> / <strong>namira123</strong>
        </p>
    </form>
</div>

<?php
require '../../views/footer.php';
?>