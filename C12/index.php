<?php

$cell_size = $_GET['cell_size'] ?? 50;
$image = imagecreatefromjpeg('original.jpg');
imagefilter($image, IMG_FILTER_PIXELATE, $cell_size);

header('Content-type: image/jpeg');
imagejpeg($image);