<?php require_once 'app/controler/db.php' ?>
<?php require_once 'app/controler/rating.php'; ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Simple One Page Blog</title>
</head>

<body>
  <!-- counter -->
  <section class="counter">
    <div class="container">
      <h2 class="title">COUNTER</h2>
      <div class="row row__jcsb">
        <div class="counter__item counter__item-negative">
          <p class="counter__number counter__number-negative"><?= $resultGrade['negativePosts'] ?></p>
          <p class="counter__name">Negative Posts</p>
        </div>
        <div class="counter__item counter__item-all">
          <p class="counter__number counter__number-countPosts"><?= count($posts); ?></p>
          <p class="counter__name">All Posts</p>
        </div>
        <div class="counter__item counter__item-positive">
          <p class="counter__number counter__number-positive"><?= $resultGrade['positivePosts'] ?></p>
          <p class="counter__name">Positive Posts</p>
        </div>
      </div>
    </div>
  </section>
  <!-- posts -->
  <section class="posts">
    <div class="container">
      <h2 class="title">POSTS</h2>
      <div class="row row__jce">
        <button class="btn btn-add-post" id="btn-add-post">Add Post</button>
      </div>
      <div class="posts__content" id="posts__content">

        <?php foreach ($posts as $post) : ?>
          <article class="content__item">
            <section class="post">
              <button class="btn btn-add-comment" type="submit" name="id" value="<?= $post['id'] ?>">Add Comment</button>
              <div class="row">
                <h3 class="author"><?= $post['author'] ?></h3>
              </div>
              <div class="row">
                <p class="post__text"><?= $post['text'] ?></p>
              </div>
              <div class="row row__jcsb">
                <div class="form__rating">
                  <div class="rating rating_set" data-ajax='true'>
                    <div class="rating__body">
                      <div class="rating__active"></div>
                      <div class="rating__items">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <input class="rating__item" type="radio" name="rating" value="1">
                        <input class="rating__item" type="radio" name="rating" value="2">
                        <input class="rating__item" type="radio" name="rating" value="3">
                        <input class="rating__item" type="radio" name="rating" value="4">
                        <input class="rating__item" type="radio" name="rating" value="5">
                      </div>
                    </div>
                    <div class="rating__value"><?= (averageRating($post['id'])) ? averageRating($post['id']) : '' ?></div>
                  </div>
                </div>
                <div class="date"><?= DateTime::createFromFormat('Y-m-d H:s:i', $post['date'])->format('d.m.Y'); ?></div>
              </div>
            </section>
            <section class="comments">

              <?php foreach ($comments as  $comment) :
                if (!empty($comment) && $comment['id_post'] === $post['id']) :
              ?>

                  <section class="comment">
                    <h3 class="author"><?= $comment['author'] ?></h3>
                    <p class="comment__text"><?= $comment['comment'] ?></p>
                    <div class="row row__jce">
                      <div class="date"><?= DateTime::createFromFormat('Y-m-d H:s:i', $comment['date'])->format('d.m.Y'); ?></div>
                    </div>
                  </section>
              <?php
                endif;
              endforeach; ?>
            </section>
          </article>
        <?php endforeach ?>

      </div>
    </div>
  </section>


  <!-- popup -->
  <!-- popup add post -->
  <section class="popup-add-post">
    <div class="form__wrapper">
      <form class="form" id="form-add-post" method="POST">
        <div class="row row__jcsb form__item">
          <label class="form__lable" for="name">Name</label>
          <input class="form__input" type="text" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="row row__jcsb form__item">
          <label class="form__lable" for="text">Text</label>
          <textarea class="form__textarea" id="text" name="post-text" rows="3" placeholder="Enter text"></textarea>
        </div>
        <div class="mess"></div>
        <div class="row row__jce"><button class="btn form__btn" type="submit" name="post" value="1">submit</button></div>
      </form>
    </div>
    <div class="close"></div>
  </section>
  <!-- popup add comment -->
  <section class="popup-add-comment">
    <div class="form__wrapper">
      <form class="form" id="form-add-comment" method="POST">
        <input type="hidden" id="id_post" name="id_post" value="">
        <div class="row row__jcsb form__item">
          <label class="form__lable" for="name">Name</label>
          <input class="form__input" type="text" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="row row__jcsb form__item">
          <label class="form__lable" for="comment">Comment</label>
          <textarea class="form__textarea" id="comment" name="post-comment" rows="3" placeholder="Enter comment" required></textarea>
        </div>
        <div class="mess"></div>
        <div class="row row__jce"><button class="btn form__btn" type="submit" name="comment" value="1" require>submit</button></div>
      </form>
    </div>
    <div class="close"></div>
  </section>

  <!-- JS jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="js/main.js">

  </script>
</body>

</html>