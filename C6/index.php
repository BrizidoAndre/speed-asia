<?php
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$anagrams = [];
if ($isPost) {
    $search = $_POST['search'] ?? '';
    $searchChars = str_split($search);
    sort($searchChars);
    $sortedSearch = implode('', $searchChars);
    $lines = file('dictionary.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $chars = str_split($line);
        sort($chars);
        $sortedLine = implode('', $chars);
        if ($sortedLine === $sortedSearch) {
            $anagrams[$line] = true;
        }
    }
    unset($anagrams[$search]);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anagram finder</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
        }
    </style>
</head>
<body>
<h1>Anagram finder</h1>
<form action="" method="post">
    <input type="text" name="search">
    <button>Find Anagrams</button>
</form>
<?php if ($isPost): ?>
    <h2>Result for <?= $_POST['search'] ?></h2>
    <?php if (!count($anagrams)): ?>
        <p>No anagrams found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($anagrams as $line => $anagram): ?>
                <li><?= $line ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
<?php endif ?>
</body>
</html>
