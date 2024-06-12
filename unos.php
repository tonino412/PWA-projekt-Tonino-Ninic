<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos Vijesti</title>
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
        <form enctype="multipart/form-data" action="skripta.php" method="POST" id="unosForma">
            <div class="form-item">
                <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="form-field-short">
                </div>
                <span id="porukaTitle"></span>
            </div>
            <div class="form-item">
                <label for="about">Kratki sadržaj vijesti (do 100 znakova)</label>
                <div class="form-field">
                    <textarea name="about" id="about" cols="10" rows="5" class="form-field-short"></textarea>
                </div>
                <span id="porukaAbout"></span>
            </div>
            <div class="form-item">
                <label for="content">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>
                <span id="porukaContent"></span>
            </div>
            <div class="form-item">
                <label for="photo">Slika: </label>
                <div class="form-field">
                    <input type="file" class="input-text" id="photo" name="photo"/>
                </div>
                <span id="porukaSlika"></span>
            </div>
            <div class="form-item">
               <label for="category">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="category" id="category">
                        <option value="" disabled selected>Odabir kategorije</option>
                        <option value="sport">Sport</option>
                        <option value="kultura">Kultura</option>
                    </select>
                </div>
                <span id="porukaKategorija"></span>
            </div>
            <div class="form-item">
                <label for="archive">Spremiti u arhivu:  
                <div class="form-arhiva"> 
                    <input type="checkbox" name="archive" id="archive">
                </div>
                </label>
            </div>
            <div class="form-item">
                <button class= "unos" type="reset" value="Poništi">Poništi</button>
                <button class= "unos" type="submit" value="Prihvati" id="slanje">Prihvati</button>
            </div>
        </form>
    </main>
    <footer>
        <p>Autor: Tonino Ninić | Kontakt: tninic@tvz.hr | Godina: 2024</p>
    </footer>
    <script>
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;

            var poljeTitle = document.getElementById("title");
            var title = document.getElementById("title").value;
            if (title.length < 5 || title.length > 50) {
                slanjeForme = false;
                poljeTitle.style.border="1px dashed red";
                document.getElementById("porukaTitle").innerHTML="Naslov vijesti mora imati između 5 i 50 znakova!<br>";
            } else {
                poljeTitle.style.border="1px solid green";
                document.getElementById("porukaTitle").innerHTML="";
            }

            var poljeAbout = document.getElementById("about");
            var about = document.getElementById("about").value;
            if (about.length < 10 || about.length > 100) {
                slanjeForme = false;
                poljeAbout.style.border="1px dashed red";
                document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
            } else {
                poljeAbout.style.border="1px solid green";
                document.getElementById("porukaAbout").innerHTML="";
            }

            var poljeContent = document.getElementById("content");
            var content = document.getElementById("content").value;
            if (content.length == 0) {
                slanjeForme = false;
                poljeContent.style.border="1px dashed red";
                document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
            } else {
                poljeContent.style.border="1px solid green";
                document.getElementById("porukaContent").innerHTML="";
            }

            var poljeSlika = document.getElementById("photo");
            var photo = document.getElementById("photo").value;
            if (photo.length == 0) {
                slanjeForme = false;
                poljeSlika.style.border="1px dashed red";
                document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
            } else {
                poljeSlika.style.border="1px solid green";
                document.getElementById("porukaSlika").innerHTML="";
            }

            var poljeCategory = document.getElementById("category");
            if(document.getElementById("category").selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border="1px dashed red";
                document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
            } else {
                poljeCategory.style.border="1px solid green";
                document.getElementById("porukaKategorija").innerHTML="";
            }

            if (slanjeForme != true) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>
