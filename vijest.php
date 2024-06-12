<?php
include 'connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM vijesti WHERE id=$id";
$result = $conn->query($sql);
$vijest = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($vijest['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php"><img src="logo.png" alt="Logo" class="logo"></a>
        <nav>
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="unos.php">Unos Vijesti</a></li>
                <li><a href="pregled.php">Pregled Vijesti</a></li>
                <li><a href="kategorija.php?kategorija=sport">Sport</a></li>
                <li><a href="kategorija.php?kategorija=kultura">Kultura</a></li>
                <li><button class="logout"><a href="logout.php">Logout</a></button></li>
            </ul>
        </nav>
    </header>
    <main>
        <article>
            <h2 class="naslov"><?php echo htmlspecialchars($vijest['title']); ?></h2>
            <img src="<?php echo $vijest['photo']; ?>" alt="Slika vijesti" class="slika">
            <p class="podnaslov"><?php echo htmlspecialchars($vijest['about']); ?></p>
            <p class="sadrzaj"><?php echo htmlspecialchars($vijest['content']); ?></p>
        </article>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
