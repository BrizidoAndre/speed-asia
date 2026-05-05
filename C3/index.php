<?php
$filesFound = [];
$lineCount = 0;
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($isPost) {
    $reader = opendir('source');
    $files = [];
    while (($line = readdir($reader)) !== false) {
        if ($line === '..' || $line === '.') {
            continue;
        }
        $fileLines = file('source/' . $line);
        foreach ($fileLines as $id => $fileLine) {
            if (str_contains($fileLine, $_POST['search'])) {
                if (!isset($filesFound[$line])) {
                    $filesFound[$line] = [];
                    $filesFound[$line][$id + 1] = $fileLine;
                } else {
                    $filesFound[$line][$id + 1] = $fileLine;
                }
                $lineCount++;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <label for="search">Enter search keyword:</label>
    <input type="text" name="search" id="search" required>
    <button>Search All Files</button>
</form>
<?php foreach ($filesFound as $id => $file): ?>
    <p><strong>File:</strong> <?= $id ?></p>
    <ul>
        <?php foreach ($file as $number => $line): ?>
            <li>Line <?= $number ?>: <?= $line ?></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
<?php if ($isPost): ?>
    <p><strong>Summary</strong> Found <?= $lineCount ?> matching line(s) in <?= count($filesFound) ?> file(s).</p>
<?php endif ?>
</body>
</html>
