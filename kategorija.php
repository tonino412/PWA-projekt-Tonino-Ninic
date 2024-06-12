<?php
include 'connect.php';

$category = $_GET['kategorija'];
$sql = "SELECT id, title, about, photo FROM vijesti WHERE category='$category' AND archive=0 ORDER BY reg_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(ucfirst($category)); ?> Vijesti</title>
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
        <section>
            <h2><?php echo strtoupper($category); ?></h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="category">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <article>
                            <a href="vijest.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['photo']; ?>" alt="Slika vijesti">
                                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                             </a>
                            <p><?php echo htmlspecialchars($row['about']); ?></p>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Nema vijesti za prikaz u kategoriji <?php echo strtoupper($category); ?>.</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </section>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
