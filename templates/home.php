<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="/assets/default.css">
</head>
<body>
<a href="<?= $site_url ?>"><h1>Epic blog</h1></a>
<a href="<?= $site_url ?>?action=profile">profile</a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <a href="<?= $site_url ?>?message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>

            <div><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['user']; ?></span>
            <span class="right"><?= $message['date']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
<form action="<?= $site_url ?>" method="post">
    <textarea name="message" id="message" rows="10"><?= empty($message_id) ? '' : $messages[0]['message'] ?></textarea>
    <input type="hidden" name="message_id" value="<?= $message_id ?>">
    <input type="submit" name="action" value="save">
    <input type="hidden" name="token" value="<?= $token ?>">
</form>
</body>
</html>