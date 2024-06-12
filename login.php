<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $conn->prepare("SELECT id, username, password, admin FROM korisnik WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $sql->store_result();
    $sql->bind_result($id, $username, $hashed_password, $admin);
    $sql->fetch();

    if ($sql->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['admin'] = $admin;
        header("Location: administrator.php");
        exit();
    } else {
        $message = "Netočno korisničko ime ili lozinka. <a href='registracija.php'>Registrirajte se</a>";
    }

    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php"><img src="logo.png" alt="Logo" class="logo"></a>
        <div class="line"></div>
    </header>
    <main>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-item">
                <label for="username">Korisničko ime:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-item">
                <label for="password">Lozinka:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-item">
                <button type="submit">Prijava</button>   
            </div>
            <a href='registracija.php' style="text-decoration: underline";>Niste registrirani? Registrirajte se</a>
        </form>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
