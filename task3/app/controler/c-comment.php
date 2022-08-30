<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Comments query

  $id = $_POST['id_post'];
  $name = $_POST['name'];
  $comment =  $_POST['post-comment'];


  //validator
  $isError = false;

  $errors = [
    'id' => [],
    'name' => [],
    'comment' => []
  ];

  // id
  if (empty($id)) {
    $errors['id'][] = 'id is empty!';
  } else {
    $param['id'] = htmlspecialchars(trim($id), ENT_QUOTES);
  }
  // name
  if (empty($name)) {
    $errors['name'][] = 'name is empty!';
  } else {
    if (mb_strlen($name) < 2) {
      $errors['name'][] = 'This name does not exist!';
    } else {
      $param['name'] = htmlspecialchars(trim($name), ENT_QUOTES);
    }
  }
  //comment
  if (empty($comment)) {
    $errors['comment'][] = 'comment is empty!';
  } else {
    $param['comment'] = htmlspecialchars(trim($comment), ENT_QUOTES);
  }

  foreach ($errors as $error) {
    if (count($error) > 0) {
      $isError = true;
    }
  }

  if ($isError == false) {

    $sql = 'INSERT INTO `comments` ( id_post, `author`, `comment`) VALUES (:id, :name, :comment)';

    $newComment = $db->prepare($sql);
    $newComment->execute($param);
    $result['status'] = 1;


    //  receiving new comment
    $sql = 'SELECT * FROM `comments` GROUP BY `id` ORDER BY `id` desc LIMIT 1 ';
    $newComment = request($sql, '', true)[0];
    $newComment['date'] = DateTime::createFromFormat('Y-m-d H:s:i', $newComment['date'])->format('d.m.Y');

    $createComment = <<<Comment
    <h3 class="author">{$newComment['author']}</h3>
    <p class="comment__text">{$newComment['comment']}</p>
    <div class="row row__jce">
      <div class="date">{$newComment['date']}</div>
    </div>
    Comment;


    $result['newComment'] = $createComment;
    echo json_encode($result);
  }
}
