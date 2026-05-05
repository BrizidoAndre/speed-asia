<?php
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$id = $_GET['id'] ?? false;
if ($id) {
    $file = json_decode(file_get_contents('urls.txt'), true);
    $content = file_get_contents($file[$id]);
    echo $content;
    return null;
}
if ($isPost) {
    $file = json_decode(file_get_contents('urls.txt'), true);
    $file[random_int(10000, 99999)] = $_POST['url'];
    file_put_contents('urls.txt', json_encode($file));
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File based URL Shortener</title>
</head>
<body>
<h1>File based URL Shortener</h1>
<form action="" method="post">
    <label for="url">Url:</label>
    <input type="url" name="url" id="url">
    <button>Submit</button>
</form>
</body>
</html>
