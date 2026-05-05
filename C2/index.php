<?php
$row = 1;
$sums = [];
if (($handle = fopen("data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c = 0; $c < $num; $c++) {
            if ($c === 0) {
                $key = $data[$c];
                if (!isset($sums[$key])) {
                    $sums[$key] = (float)$data[1];
                } else {
                    $sums[$key] += (float)$data[1];
                }
            }
        }
    }
    fclose($handle);
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
<ul>
    <?php foreach ($sums as $key => $sum): ?>
        <li><?= $key ?>: <?= $sum ?></li>
    <?php endforeach ?>
</ul>
</body>
</html>
