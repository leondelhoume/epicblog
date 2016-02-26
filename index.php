<?php session_start(); ?>
<?php setcookie("default"); ?>
<?php require './lib.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Epic Blog</title>
    <link rel="stylesheet" href="/assets/default.css" type="text/css"/>
</head>
<body>
<h3>Choose your theme:</h3>
<form name="style" action="" method="POST">
    <input type="radio" name="style" value="default" checked="checked">default<Br>
    <input type="radio" name="style" value="blue">blue<Br>
    <input type="radio" name="style" value="yellow">yellow<Br>
    <input type="submit" name="view" value="View">
</form>


<hr>

<?php show_messages(); ?>
<hr>
<h2>Add your message:</h2>
<div class='form'>
    <form name="add_message" action="" method='POST'>
        <p><input type='text' name='title' value='title' size='45'></p>
        <textarea name='message' rows="8" cols="45">Your Message</textarea>
        <br>
        <input type='hidden' name='token' value='<?=$token ?>'>
        <input type="submit" name="save" value="Save">
        </p>
    </form>
    <?php
    if (!empty($_POST['save']))
    {
        add_message();
    }
    ?>
</div>
</body>
</html>