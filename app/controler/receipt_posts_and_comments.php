<?php
require_once 'db.php';

// Receipt posts
$sql = 'SELECT * FROM posts';
$posts = $db->prepare($sql);
$posts->execute();
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

//Receipt comments

$sql = 'SELECT * FROM comments';
$comments = $db->prepare($sql);
$comments->execute();
$comments = $comments->fetchAll(PDO::FETCH_ASSOC);

$data = [
  'posts' => $posts,
  'comments' => $comments
];


//Negative Posts and Positive Posts

$resultGrade = initFilterPosts($posts);
