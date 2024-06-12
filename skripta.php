<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $upload_status = "Slika ". htmlspecialchars(basename($photo)). " je uspješno uploadana.";

        $sql = "INSERT INTO vijesti (title, about, content, category, archive, photo)
        VALUES ('$title', '$about', '$content', '$category', '$archive', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            echo "Greška: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $upload_status = "Nažalost, došlo je do greške prilikom uploada slike.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji Vijesti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php"><img src="logo.png" alt="Logo" class="logo"></a>
        <div class="line"></div>
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
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><strong>Kratki sadržaj:</strong> <?php echo htmlspecialchars($about); ?></p>
        <p><strong>Sadržaj:</strong> <?php echo htmlspecialchars($content); ?></p>
        <p><strong>Kategorija:</strong> <?php echo htmlspecialchars($category); ?></p>
        <p><strong>Arhivirano:</strong> <?php echo $archive ? 'Da' : 'Ne'; ?></p>
        <p><?php echo $upload_status; ?></p>
        <?php if (isset($target_file)): ?>
            <img src="<?php echo $target_file; ?>" alt="Slika vijesti">
        <?php endif; ?>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
