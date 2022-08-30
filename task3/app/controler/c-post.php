<?php
require_once 'db.php';
// require_once 'receipt_posts_and_comments.php';
require_once 'rating.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  $text = $_POST['post-text'];

  $errors = [
    'name' => [],
    'text' => []
  ];
  //validator
  $isError = false;

  if (empty($name)) {
    $errors['name'][] = 'name is empty!';
  } else {
    if (mb_strlen($name) < 2) {
      $errors['name'][] = 'This name does not exist!';
    } else {
      $param['name'] = htmlspecialchars(trim($name), ENT_QUOTES);
    }
  }
  if (empty($text)) {
    $errors['text'][] = 'text is empty!';
  } else {
    $param['text'] = htmlspecialchars(trim($text), ENT_QUOTES);
  }
  foreach ($errors as $error) {
    if (count($error) > 0) {
      $isError = true;
      $result['status'] = 0;
    }
  }


  if ($isError == false) {

    $sql = 'INSERT INTO `posts` (`author`, `text`) VALUES (:name, :text)';
    request($sql, $param);

    // $newPost = $db->prepare($sql);
    // $newPost->execute($param);


    $sql = 'SELECT * FROM `posts` GROUP BY `id`
    ORDER BY `id` desc LIMIT 1 ';

    $newPost = request($sql, '', true)[0];
    $newPost['data'] = DateTime::createFromFormat('Y-m-d H:i:s', $newPost['date'])->format('d.m.Y');
    $newPost['rating'] =  (averageRating($newPost['id'])) ? averageRating($newPost['id']) : '';

    $createPost = <<<EOT
    <section class="post">
       <button class="btn btn-add-comment" type="submit" name="id" value="{$newPost['id']}">Add Comment</button>
    <div class="row">
      <h3 class="author"> {$newPost['author']}</h3>
    </div>
    <div class="row">
      <p class="post__text">{$newPost['text']}</p>
    </div>
    <div class="row row__jcsb">
      <div class="form__rating">
        <div class="rating rating_set" data-ajax='true'>
          <div class="rating__body">
            <div class="rating__active"></div>
            <div class="rating__items">
              <input type="hidden" name="post_id" value=" {$newPost['id']} ">
              <input class="rating__item" type="radio" name="rating" value="1">
              <input class="rating__item" type="radio" name="rating" value="2">
              <input class="rating__item" type="radio" name="rating" value="3">
              <input class="rating__item" type="radio" name="rating" value="4">
              <input class="rating__item" type="radio" name="rating" value="5">
            </div>
          </div>
          <div class="rating__value">{$newPost['rating']}</div>
        </div>
      </div>
      <div class="date"> {$newPost['data']}</div>
    </div>
  </section>
  <section class="comments">
  </section>
  EOT;


    $result = [
      'status' => 1,
      'newCount' => countPosts(),
      'newPost' => $createPost,
    ];
  }
  echo json_encode($result);
}
