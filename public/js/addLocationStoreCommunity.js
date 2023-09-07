$('#submitPostButton').prop('disabled', true);

function setLocation(pos) {

  const lat = pos.coords.latitude;
  const lng = pos.coords.longitude;

  console.log(lat);
  console.log(lng);

  $("#latitude").val(lat);
  $("#longitude").val(lng);

  fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyDLm3FiiHj5SL12ki1Nigf2P9i9irwpXZU&language=ja`)
  .then(response => response.json())
  .then(data => {
    console.log(data);
    let components = [];
    for (let component of data.results[0].address_components) {
      if (component.types.includes("administrative_area_level_1") || component.types.includes("locality") || component.types.includes("sublocality_level_1") || component.types.includes("sublocality_level_2")) {
        components.unshift(component.long_name); // componentsという配列の先頭にcomponent.long_nameを追加
      }
    }
    let address = components.join(' ');
    console.log(address);
    $("#location_name").val(address);

    const newSVG = `
    <svg class="flex-shrink-0 h-6 w-6 text-white" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.1965 7.85999C15.1965 3.71785 11.8387 0.359985 7.69653 0.359985C3.5544 0.359985 0.196533 3.71785 0.196533 7.85999C0.196533 12.0021 3.5544 15.36 7.69653 15.36C11.8387 15.36 15.1965 12.0021 15.1965 7.85999Z" fill="currentColor" class="fill-green-500"/>
        <path d="M10.9295 4.88618C11.1083 4.67577 11.4238 4.65019 11.6343 4.82904C11.8446 5.00788 11.8702 5.32343 11.6914 5.53383L7.44139 10.5338C7.25974 10.7475 6.93787 10.77 6.72825 10.5837L4.47825 8.5837C4.27186 8.40024 4.25327 8.0842 4.43673 7.87781C4.62019 7.67142 4.93622 7.65283 5.14261 7.83629L7.01053 9.49669L10.9295 4.88618Z" fill="currentColor"/>
    </svg>
    `;

    $('#locationStatus').find('svg').replaceWith(newSVG);
    $('#locationMessage').text('取得しました！');
    $('#submitPostButton').prop('disabled', false);
  })
  .catch(error => {
    console.error("Geocodingエラー:", error);

    $('#locationMessage').text('位置情報の取得に失敗しました');
  });
}

function showErr(err) {
  switch (err.code) {
      case 1 :
          alert("位置情報の利用が許可されていません");
          break;
      case 2 :
          alert("デバイスの位置が判定できません");
          break;
      case 3 :
          alert("タイムアウトしました");
          break;
      default :
          alert(err.message);
  }
}

// geolocation に対応しているか否かを確認
if ("geolocation" in navigator) {
  var opt = {
      "enableHighAccuracy": true,
      "timeout": 10000,
      "maximumAge": 0,
  };
  //ここで位置情報を取得？
  navigator.geolocation.getCurrentPosition(setLocation, showErr, opt);
} else {
  alert("ブラウザが位置情報取得に対応していません");
}