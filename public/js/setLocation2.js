function setLocation(pos) {

  const lat = pos.coords.latitude;
  const lng = pos.coords.longitude;

  $("#latitude").val(lat);
  $("#longitude").val(lng);

  console.log(lat);
  console.log(lng);

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

  })
  .catch(error => {
    console.error("Geocodingエラー:", error);
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



// $('.btn').prop('disabled', false) //post.searchのボタンを押せるようになる

// function setLocation(pos) {
//   const lat = pos.coords.latitude;
//   const lng = pos.coords.longitude;

//   console.log(lat);
//   console.log(lng);

//   // $("#latitude").val(lat);
//   // $("#longitude").val(lng);

//   fetch('/api/location', {
//       method: 'POST',
//       headers: {
//           'Content-Type': 'application/json',
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//       },
//       body: JSON.stringify({ latitude: lat, longitude: lng })
//   }).then(response => {
//       if (!response.ok) {
//           throw new Error('Network response was not ok');
//       }
//       // return response.json();
//       return response.text();
//   }).then(data => {
//       // console.log(data);
//       console.log('Success:', data);
//   }).catch((error) => {
//       console.error('Error:', error);
//   });
// }
// // エラー時に呼び出される関数
// function showErr(err) {
//   switch (err.code) {
//       case 1 :
//           alert("位置情報の利用が許可されていません");
//           break;
//       case 2 :
//           alert("デバイスの位置が判定できません");
//           break;
//       case 3 :
//           alert("タイムアウトしました");
//           break;
//       default :
//           alert(err.message);
//   }
// }

// // geolocation に対応しているか否かを確認
// if ("geolocation" in navigator) {
//   var opt = {
//       "enableHighAccuracy": true,
//       "timeout": 10000,
//       "maximumAge": 0,
//   };

//   navigator.geolocation.getCurrentPosition(setLocation, showErr, opt);
// } else {
//   alert("ブラウザが位置情報取得に対応していません");
// }

// $('.btn').prop('disabled', false) post.searchのボタンを押せるようになる