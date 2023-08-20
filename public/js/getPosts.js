  // 位置情報取得の関数
  function getLocation() {
    // fetchFollowerPosts が先に実行されたかどうかを確認するフラグ
    if (window.fetchFollowerPostsExecuted) return;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
  }

  function showLoading() {
    $('#loading-div').show();
  }

  function hideLoading() {
      $('#loading-div').hide();
  }

  function showPosition(position) {
      fetchLocationPosts(position.coords.latitude, position.coords.longitude);
  }

  function showError(error) {
      switch(error.code) {
          case error.PERMISSION_DENIED:
              alert("User denied the request for Geolocation.");
              break;
          case error.POSITION_UNAVAILABLE:
              alert("Location information is unavailable.");
              break;
          case error.TIMEOUT:
              alert("The request to get user location timed out.");
              break;
          case error.UNKNOWN_ERROR:
              alert("An unknown error occurred.");
              break;
      }
  }

  // この関数でAjaxを使ってサーバーから投稿を取得
  function fetchLocationPosts(latitude, longitude) {
      showLoading();
      $.ajax({
          url: 'posts', // これはあなたのルートに応じて変更してください
          type: 'GET',
          data: {
              latitude: latitude,
              longitude: longitude,
              radius: 5 // この数値も変更可能です
          },
          success: function(data) {
              $('#containerForPosts').html(data);
              hideLoading();

              initializeLikeButtons();
          },
          error: function(error) {
              alert('Error fetching posts!');
              hideLoading();
          }
      });
  }

  function fetchFollowerPosts() {
    // fetchFollowerPosts が実行されたことを示すフラグをセット
    window.fetchFollowerPostsExecuted = true;

    showLoading();
    $.ajax({
        url: 'posts', // これはあなたのルートに応じて変更してください
        type: 'GET',
        data: {
          fetchFollowingPosts: true
        },
        success: function(data) {
            $('#containerForPosts').html(data);
            hideLoading();
            window.fetchFollowerPostsExecuted = true;
        },
        error: function(error) {
            alert('Error fetching posts!follow');
            hideLoading();
        }
    });
  }

  $(document).ready(function() {
    // ボタンがクリックされたときのみfetchFollowerPostsを実行
    $("#fetch-following-posts").on("click", function() {
        fetchFollowerPosts();
        // window.fetchFollowerPostsExecuted = true;  // フラグをセット
    });

    if (!window.fetchFollowerPostsExecuted) {
        getLocation();
    }
  });

// document.getElementById('fetch-location-posts').addEventListener('click', function() {
//   getLocation();
// });

// document.getElementById('fetch-following-posts').addEventListener('click', function() {
//   fetchFollowerPosts();
// });
