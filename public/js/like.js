function initializeLikeButtons() {
  const likeButtons = document.querySelectorAll('.like-button');

  likeButtons.forEach(button => {
      button.removeEventListener('click', likeButtonClickHandler);

      button.addEventListener('click', likeButtonClickHandler);
  });
}

function likeButtonClickHandler(event) {
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
}


// document.addEventListener('DOMContentLoaded', initializeLikeButtons);