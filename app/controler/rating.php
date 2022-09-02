<?php
require_once 'db.php';
require_once 'receipt_posts_and_comments.php';


function averageRating($postId)
{
  $sql = 'SELECT * FROM posts_ratinng WHERE post_id = :post_id';

  $allRating = request($sql, ['post_id' => $postId], true);


  if (count($allRating) < 1) {
    return  0;
  }

  $averageRating = 0;
  for ($index = 0, $count = count($allRating); $index < $count; $index++) {
    $averageRating += $allRating[$index]['rating'];
  }

  return  round($averageRating / count($allRating), 1);
}
function initFilterPosts($posts)
{
  $resultGrade = [
    'negativePosts' => 0,
    'positivePosts' => 0
  ];

  foreach ($posts as $post) {
    if (averageRating($post['id']) <= 2 && averageRating($post['id']) !== 0) {
      ++$resultGrade['negativePosts'];
    } elseif (averageRating($post['id']) >= 4) {
      ++$resultGrade['positivePosts'];
    }
  }
  return $resultGrade;
}




if (!empty(file_get_contents('php://input'))) {
  $data = json_decode(file_get_contents('php://input'), true);
  if (!empty($data['post_id'])) {

    // Recording rating

    $param['post_id'] = $data['post_id'];
    $param['rating'] = $data['userRating'];

    $sql = 'INSERT INTO `posts_ratinng` (post_id, rating) VALUES ( :post_id, :rating)';

    $newComment = $db->prepare($sql);
    $newComment->execute($param);

    // Average rating

    $averageRating = averageRating($param['post_id']);

    $resultGrade = initFilterPosts($posts);

    $result = [
      'newRating' => $averageRating,
      'newNegativePosts' => $resultGrade['negativePosts'],
      'newPositivePosts' => $resultGrade['positivePosts'],
    ];


    echo (json_encode($result));
  }
}
