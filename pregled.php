<?php
session_start();

include 'connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM vijesti WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Vijest je uspješno obrisana.";
    } else {
        $message = "Greška pri brisanju vijesti: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT id, title, about, category, photo FROM vijesti";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled Vijesti</title>
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
       

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Naslov</th>
                    <th>Kratki Sadržaj</th>
                    <th>Kategorija</th>
                    <th>Slika</th>
                    <th>Akcije</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['about']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Slika vijesti" width="100"></td>
                        <td>
                            <button><a href="uredi.php?id=<?php echo $row['id']; ?>">Uredi</a></button>
                            <form action="pregled.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="delete" value="true">
                                <button type="submit" onclick="return confirm('Jeste li sigurni?')">Izbriši</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nema vijesti za prikaz.</p>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <?php $conn->close(); ?>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
