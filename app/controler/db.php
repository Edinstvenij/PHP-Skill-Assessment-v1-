<?php

$dsn = 'mysql:dbname=task3;host=127.0.0.1';
$user = 'root';
$password = '';
$db = new PDO($dsn, $user, $password);

function request(string $sql, $param = '', bool $receiving = false)
{
  global $db;

  $newComment = $db->prepare($sql);
  if (is_array($param)) {
    $newComment->execute($param);
  } else {
    $newComment->execute();
  }
  if ($receiving === true) {
    return  $newComment->fetchAll(PDO::FETCH_ASSOC);
  }
}
function countPosts(): int
{
  return count(request('SELECT * FROM posts', '', true));
}
