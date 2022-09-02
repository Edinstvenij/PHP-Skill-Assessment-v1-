$(document).ready(function () {

  $('#btn-add-post').click(function (event) {
    $('.popup-add-post').addClass('active');
  });

  $('.close').click(function (event) {
    $('.popup-add-post').removeClass('active');
    $('.popup-add-comment').removeClass('active');
  });


  ///**
  //ajax 
  //**

  //** rating **//
  const ratings = document.querySelectorAll('.rating');
  if (ratings.length > 0) {
    initRatings();
  }
  // Main function
  function initRatings() {
    let ratingActive, ratingValue;
    for (let index = 0; index < ratings.length; index++) {
      const rating = ratings[index];
      initRating(rating);
    }
  }
  // one rating
  function initRating(rating) {
    initRatingVars(rating);
    setRatingActiveWitdth();

    setRating(rating);
  }
  // var
  function initRatingVars(rating) {
    ratingActive = rating.querySelector('.rating__active');
    ratingValue = rating.querySelector('.rating__value');
  }
  //update active row star
  function setRatingActiveWitdth(index = ratingValue.innerHTML) {
    const ratingActiveWitdth = index / 0.05;

    ratingActive.style.width = `${ratingActiveWitdth}%`;
  }

  // Opportunity to evaluate
  function setRating(rating) {
    const ratingItems = rating.querySelectorAll('.rating__item');
    for (let index = 0; index < ratingItems.length; index++) {
      const ratingItem = ratingItems[index];

      ratingItem.addEventListener("mouseenter", function (e) {
        if (!rating.classList.contains('rating_sending')) {

          initRatingVars(rating);
          setRatingActiveWitdth(ratingItem.value);
        };

      });

      ratingItem.addEventListener("mouseleave", function (e) {
        setRatingActiveWitdth();
      });

      ratingItem.addEventListener("click", function (e) {
        initRatingVars(rating);

        setRatingValue(ratingItem.value, rating);
      });
    }
  }



  async function setRatingValue(value, rating) {
    if (!rating.classList.contains('rating_sending')) {
      rating.classList.add('rating_sending')
      rating.querySelectorAll('input').forEach(element => {
        element.disabled = 1 < 2;;
      });
    }
    let post_id = rating.querySelector('input[name=post_id]').value;

    let response = await fetch('app/controler/rating.php', {
      method: 'POST',

      body: JSON.stringify({
        userRating: value,
        post_id: post_id
      }),
      headers: {
        'content-type': 'application/json'
      }
    });

    if (response.ok) {
      const result = await response.json();

      const NegativePostsValue = document.querySelector('.counter__number-negative');
      const PositivePostsValue = document.querySelector('.counter__number-positive');

      const newNegativePosts = result.newNegativePosts;
      const newPositivePosts = result.newPositivePosts;
      const newRating = result.newRating;

      ratingValue.innerHTML = newRating;
      NegativePostsValue.innerHTML = newNegativePosts;
      PositivePostsValue.innerHTML = newPositivePosts;

      setRatingActiveWitdth;

    } else {
      alert('Error');
      rating.classList.remove('rating_sending');
    }
  }
  //** END rating **//



  //update posts




  //submit form add post
  $('#form-add-post').submit(function (event) {
    event.preventDefault();
    let th = $(this);
    let popup = $('.popup-add-post');
    let mess = $('.mess');
    let btn = th.find('.btn');

    $.ajax({
      url: 'app/controler/c-post.php',
      type: 'POST',
      data: th.serialize(),
      success: function (data) {

        data = JSON.parse(data);

        if (data['status'] == 1) {
          btn.addClass('success'),

            mess.html('<div class="row row__jce row__col row__aie form__item"><div>Messages sent successfully</div></div>'),
            setTimeout(() => {
              popup.removeClass('active');
              mess.html('');
              btn.removeClass('success');
              event.target.reset();
            }, 2000);


          const newPost = data['newPost'];
          const newCountPosts = data['newCount'];

          const contentPosts = document.getElementById('posts__content');
          const newCountElement = document.querySelector('.counter__number-countPosts');
          const newElement = document.createElement('article');

          newCountElement.innerHTML = newCountPosts;

          newElement.classList.add('content__item');
          newElement.innerHTML = newPost;
          contentPosts.append(newElement);

          initRating(newElement.querySelector('.rating'));

          updateBtnAddCmment();

        } else {
          mess.html('<div class="row row__jce row__col row__aie form__item"><div class="error">Error</div></div>')
        }
      }, error: function () {
        mess.html('<div class="row row__jce row__col row__aie form__item"><div class="error">Error submit</div></div>')
      }
    });
  });



  updateBtnAddCmment();

  function updateBtnAddCmment() {

    const allBtnAddComment = document.getElementsByClassName('btn-add-comment');

    for (let btnAddComment of allBtnAddComment) {
      btnAddComment.addEventListener('click', function (event) {
        updateIdPostInPopup(event, allBtnAddComment);
        $('.popup-add-comment').addClass('active');
      });

    }
  }


  function updateIdPostInPopup(event, allBtnAddComment) {
    $.each(allBtnAddComment, function (key, btnAddComment) {
      if (btnAddComment.value == event.target.value) {
        $('#id_post')[0].value = btnAddComment.value;
      }
    });
  }

  //submit form add comment
  $('#form-add-comment').submit(function (event) {
    event.preventDefault();
    let th = $(this);
    let popup = $('.popup-add-comment');
    let mess = $('.mess');
    let btn = th.find('.btn');

    $.ajax({
      url: 'app/controler/c-comment.php',
      type: 'POST',
      data: th.serialize(),
      success: function (data) {

        data = JSON.parse(data);

        if (data['status'] == 1) {
          btn.addClass('success'),
            mess.html('<div class="row row__jce row__col row__aie form__item"><div>Messages sent successfully</div></div>');

          const newComment = data['newComment'];

          const newElement = document.createElement('section');
          newElement.classList.add('comment');

          newElement.innerHTML = newComment;

          updateCountComments();
          updateBtnAddCmment();
          commentsElement.append(newElement);


          setTimeout(() => {
            popup.removeClass('active');
            mess.html('');
            btn.removeClass('success');
          }, 2000);
        } else {
          mess.html('<div class="row row__jce row__col row__aie form__item"><div class="error">' + data + '</div></div>')
        }
      }, error: function () {
        mess.html('<div class="row row__jce row__col row__aie form__item"><div class="error">Error submit</div></div>')
      }
    });
    event.target.reset();
  });

  function updateCountComments() {
    $.each($('.btn-add-comment'), function (key, item) {
      if (item.value == $('#id_post')[0].value) {
        return commentsElement = item.parentElement.parentElement.children[1];
      }
    });
  }




});