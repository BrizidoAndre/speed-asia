<?php
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$messages = json_decode(file_get_contents('data.json'), true);
if ($isPost) {
    $messages[] = [
            'date' => date('Y-m-d H:i:s'),
            'name' => $_POST['author'],
            'message' => $_POST['message']
    ];
    file_put_contents('data.json', json_encode($messages));
    $messages = json_decode(file_get_contents('data.json'), true);
}

$perPage = 5;
$totalPages = ceil(count($messages) / $perPage);
/*getting page and calculating its offset for slicing purposes*/
$page = $_GET['page'] ?? 1;
$page = max(1, min($page, $totalPages));
$offset = ($page - 1) * $perPage;

//calculating how the page links should appear
$linksToShow = 5;
$half = floor($linksToShow / 2);
$start = max(1, $page - $half);
$end = min($totalPages, $start + $linksToShow - 1);

if ($end - $start < $linksToShow - 1) {
    $start = max(1, $end - $linksToShow + 1);
}

// the previous and next should show up?
$canPrevious = $page > 1;
$canNext = $page < $totalPages;
//cutting the messages
$messagesShow = array_slice($messages, $offset, $perPage);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Guestbook</title>
    <style>
        .container {
            width: clamp(300px, 80%, 600px);
            margin: 0 auto;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        button {
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Guest book</h1>
    <form action="" method="post">
        <input type="text" name="author">
        <textarea name="content" id="" rows="10"></textarea>
        <button>Submit</button>
    </form>
    <h2>Messages</h2>
    <div>
        <?php foreach ($messagesShow as $message): ?>
            <div class="card">
                <h3><?= $message['name'] ?> <?= $message['date'] ?></h3>
                <p><?= $message['message'] ?></p>
            </div>
        <?php endforeach ?>
    </div>
    <div class="container-links">
        <?php if ($canPrevious): ?>
            <a href="?page=<?= ($page - 1) ?>">Previous</a>
        <?php endif ?>

        <?php for ($i = $start; $i < $end + 1; $i++) : ?>
            <a href="?page=<?= $i ?>">
                <?= $i ?>
            </a>
        <?php endfor ?>
        <?php if ($canNext): ?>
            <a href="?page=<?= ($page + 1) ?>">Next</a>
        <?php endif ?>
    </div>
</div>
</body>
</html>
