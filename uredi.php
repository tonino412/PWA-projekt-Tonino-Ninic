<?php
session_start();

include 'connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$vijest = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM vijesti WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Vijest je uspješno obrisana.";
            header("Location: pregled.php");
            exit();
        } else {
            $message = "Greška pri brisanju vijesti: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $archive = isset($_POST['archive']) ? 1 : 0;

        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($photo);

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_path = $target_file;
            } else {
                $photo_path = $_POST['existing_photo'];
                $message = "Greška pri uploadu datoteke.";
            }
        } else {
            $photo_path = $_POST['existing_photo'];
        }

        $sql = "UPDATE vijesti SET title=?, about=?, content=?, category=?, archive=?, photo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiss", $title, $about, $content, $category, $archive, $photo_path, $id);

        if ($stmt->execute()) {
            $message = "Vijest je uspješno ažurirana.";
        } else {
            $message = "Greška: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM vijesti WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $vijest = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Nije odabrana vijest za uređivanje.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi Vijest</title>
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
        
        <form enctype="multipart/form-data" action="uredi.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vijest['id'] ?? ''); ?>">
            <div class="form-item">
                <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="form-field-textual" value="<?php echo htmlspecialchars($vijest['title'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-item">
                <label for="about">Kratki sadržaj vijesti (do 100 znakova)</label>
                <div class="form-field">
                    <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual"><?php echo htmlspecialchars($vijest['about'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="form-item">
                <label for="content">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"><?php echo htmlspecialchars($vijest['content'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="form-item">
                <label for="photo">Slika: </label>
                <div class="form-field">
                    <input type="file" class="input-text" id="photo" name="photo"/>
                    <input type="hidden" name="existing_photo" value="<?php echo htmlspecialchars($vijest['photo'] ?? ''); ?>">
                    <?php if (!empty($vijest['photo'])): ?>
                        <img src="<?php echo htmlspecialchars($vijest['photo']); ?>" alt="Slika vijesti" width="100">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-item">
                <label for="category">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-field-textual">
                        <option value="sport" <?php if (($vijest['category'] ?? '') == 'sport') echo 'selected'; ?>>Sport</option>
                        <option value="kultura" <?php if (($vijest['category'] ?? '') == 'kultura') echo 'selected'; ?>>Kultura</option>
                    </select>
                </div>
            </div>
            <div class="form-item">
                <label>Spremiti u arhivu:  
                <div class="form-field">
                    <input type="checkbox" name="archive" id="archive" <?php if (!empty($vijest['archive'])) echo 'checked'; ?>>
                </div>
                </label>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" id="slanje">Prihvati</button>
            </div>
        </form>

        <form action="uredi.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vijest['id'] ?? ''); ?>">
            <input type="hidden" name="delete" value="true">
            <div class="form-item">
                <button type="submit" value="Obriši">Obriši</button>
            </div>
        </form>
        <?php if ($message): ?>
            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
