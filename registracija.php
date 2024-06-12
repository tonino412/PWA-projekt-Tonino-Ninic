<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $admin = isset($_POST['admin']) ? 1 : 0;

    $sql = $conn->prepare("INSERT INTO korisnik (username, password, admin) VALUES (?, ?, ?)");
    $sql->bind_param("ssi", $username, $password, $admin);

    if ($sql->execute()) {
        $message = "Registracija uspješna. <button><a href='login.php'>Prijavite se</a></button>";
    } else {
        $message = "Greška: " . $sql->error;
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
    <title>Registracija</title>
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
        <?php else: ?>
            <form action="registracija.php" method="POST">
                <div class="form-item">
                    <label for="username">Korisničko ime:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-item">
                    <label for="password">Lozinka:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-item">
                    <label for="admin">Administrator:</label>
                    <input type="checkbox" name="admin" id="admin">
                </div>
                <div class="form-item">
                    <button type="submit">Registracija</button>
                </div>
            </form>
        <?php endif; ?>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
