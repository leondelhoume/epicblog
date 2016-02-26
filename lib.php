<?php

function db_connection()
{
    static $pdo;
    if (empty($pdo)) {
        $pdo = new \PDO("mysql:host=localhost;dbname=epicblog", 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);
    }
    return $pdo;
}

function add_message()
{
    if (empty($_POST['title'])||empty($_POST['message']))
    {
        print "<h2>Write your message!</h2>";
    }
    else {
        $user_id = $_SESSION['user_id'];
        $title = htmlspecialchars($_POST['title']);
        $message = htmlspecialchars($_POST['message']);

        $connect = db_connection();
        $params = [':user_id' => $user_id, ':title' => $title, ':message' => $message];
        $sql = 'INSERT INTO messages SET user_id=:user_id, title=:title, date=NOW(),message=:message';
        $query = $connect->prepare($sql);
        $query->execute($params);
    }
}

function show_messages()
 {
        $connect=db_connection();
        $statement=$connect->query("SELECT messages.id, messages.title, messages.date,
                         messages.message, users.user FROM messages
 						LEFT JOIN users ON messages.user_id=users.id
 						ORDER BY messages.date DESC");

        $row=$statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $key=>$value)
            {
                print "<form name='form' action='' method='POST'>";
 	    print "<h2>".$row[$key]['title']."</h2>";
 	    print "<p>".$row[$key]['message']."<br>";
 	    print "<p>".$row[$key]['user']."</p>";
 	    print "<p>".$row[$key]['date']."</p>";
 	    print "<input type='hidden' name='message_id[]' value='".$row[$key]['id']."'>";
 	    print "</form>";
     }
 }

function delete_messages()
{
    if (empty($_POST['message_id'][0]))
    {
        print "Error";
        return;
    }
    else
    {
        $message_id=$_POST['message_id'][0];
    }
    $connect=db_connection();
    $query=$connect->prepare('DELETE FROM messages WHERE id=:message_id');
    $query->execute([':message_id'=>$message_id]);
}

function token()
{
    $token=uniqid();
    $_SESSION['token']=$token;
    return $token;
}

function validate_token($token)
{
    if (!empty($_SESSION['token'])&&$token==$_SESSION['token'])
    {
        return true;
    }
}

function templates($name, array $vars=[])
{
    if (!is_file($name))
    {
        throw new exception ("Can't load template");
    }
    else
    {
        ob_start();
        extract($vars);
        require($name);
        $content=ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

function login()
{
    $connect=db_connection();
    if ((empty($_POST['user']))||empty($_POST['password']))
    {
        print "Error";
        return;
    }
    else
    {
        $login=$_POST['user'];
        $password=$_POST['password'];
    }
    $query=$connect->prepare('SELECT * FROM users WHERE name=:user AND password=:password');
    $query->execute([':user'=>$login, ':password'=>$password]);
    $user=$query->fetch();
    if (!empty($user))
    {
        $_SESSION['user_id']=$user['id'][0];
        setcookie('default');
        header('Location: /epicblog/templates/home.php');
    }
}