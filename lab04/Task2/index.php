<?php
$dir = "image/";
$files = scandir($dir);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Champions Gallery</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <nav>
        <a href="#">About Champions</a> |
        <a href="#">News</a> |
        <a href="#">Lore</a>
    </nav>
</header>

<main>
    
<p>Welcome to the world of Legends</p>

<div class="gallery">

<?php

if ($files !== false) {

    for ($i = 0; $i < count($files); $i++) {

        if ($files[$i] != "." && $files[$i] != "..") {

            $path = $dir . $files[$i];

            echo "<img src='$path' alt='champion'>";
        }
    }

}

?>

</div>

</main>

<footer>
    <p>league of legends 2026</p>
</footer>

</body>
</html>