function initializeModalTriggers() {
  const modalTrigger = document.querySelector('.modal-trigger');
  const modal = document.getElementById('myModal');
  const closeModal = document.getElementById('closeModal');

  console.log(document.querySelector('.modal-trigger'));
console.log(document.getElementById('myModal'));
console.log(document.getElementById('closeModal'));


  modalTrigger.addEventListener('click', function() {
    console.log('Modal trigger clicked!');
    getcurrentLocation();
  });

  // 閉じるボタンをクリックしたときの動作を設定
  // closeModal.addEventListener('click', function() {
  //   modal.classList.add('hidden');
  // });
}

