// ボタンがクリックされた時の処理
document.getElementById('home-button').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let radius = '3'; // デフォルトの値
            if (document.getElementById('radius_5').checked) {
                radius = '5';
            } else if (document.getElementById('radius_10').checked) {
                radius = '10';
            }
            // ページをリロードし、位置情報をパラメータとして送信
            window.location.href = '/post?latitude=' + position.coords.latitude + '&longitude=' + position.coords.longitude + '&radius=' + radius;
        },
        function(error) {
            // 位置情報の取得に失敗したときのエラーハンドリング
            console.error('Geolocation error: ', error);
        });
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
});
