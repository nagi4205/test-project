document.addEventListener('DOMContentLoaded', function() {
  const likeButtons = document.querySelectorAll('.like-button');
  console.log(LikeButtons);

  likeButtons.forEach(button => {
      button.addEventListener('click', function(event) {
          const form = event.target.closest('.like-form');
          const formData = new FormData(form);
          fetch(form.action, {
              method: 'POST',
              body: formData,
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': formData.get('_token')
              }
          })
          .then(response => response.json())
          .then(data => {
              const countSpan = form.querySelector('.like-count');
              countSpan.textContent = data.count;

              const icon = form.querySelector('i');
              if (data.status === 'liked') {
                  icon.className = 'fas fa-heart';
              } else {
                  icon.className = 'far fa-heart';
              }
          });
      });
  });
});
