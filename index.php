<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna Stranica</title>
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
            <?php
            include 'connect.php';
            $category = "sport";
            echo "<h2>" . strtoupper($category) . "</h2>";
                $sql = "SELECT id, title, about, photo FROM vijesti WHERE category='$category' ORDER BY reg_date DESC LIMIT 3";
                $result = $conn->query($sql);
                if ($result->num_rows > 0): ?>
                    <div class="category">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <article>
                            <a href="vijest.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $row['photo']; ?>" alt="Slika vijesti"></a>
                            <a href="vijest.php?id=<?php echo $row['id']; ?>"><h3><?php echo htmlspecialchars($row['title']); ?></h3></a>  
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>Nema vijesti za prikaz u kategoriji <?php echo strtoupper($category); ?>.</p>
                <?php endif;
            $conn->close();
            ?>
        </section>
        <section>
            <?php
            include 'connect.php';
            $category = "kultura";
            echo "<h2>" . strtoupper($category) . "</h2>";
            $sql = "SELECT id, title, about, photo FROM vijesti WHERE category='$category' ORDER BY reg_date DESC LIMIT 3";
            $result = $conn->query($sql);
            if ($result->num_rows > 0): ?>
                <div class="category">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <article>
                            <a href="vijest.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $row['photo']; ?>" alt="Slika vijesti"></a>
                            <a href="vijest.php?id=<?php echo $row['id']; ?>"><h3><?php echo htmlspecialchars($row['title']); ?></h3></a>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Nema vijesti za prikaz u kategoriji <?php echo strtoupper($category); ?>.</p>
            <?php endif;
            $conn->close();
            ?>
        </section>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
</body>
</html>
