let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 32.94846632703454, lng: 131.11642896896308 },
      zoom: 14,
    });

    // マーカーの設定
    // マーカーを置きたい場所の緯度、経度
    const marker1 = { lat: 32.93844153354462, lng: 131.11849465150752 }
    // マーカーを作成
    new google.maps.Marker({
        position: marker1,
        map,
        title: "マーカー1",
    });

    const image =
    "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
    const marker2 = { lat: 32.94473771568393, lng: 131.1148974117918 }
    // マーカーを作成
    new google.maps.Marker({
        position: marker2,
        map,
        title: "マーカー2",
        icon: image
    });
}


// function initMap() {
//     const map = new google.maps.Map(document.getElementById("map"), {
//       zoom: 15,
//       center: { lat: 32.9378033631452, lng: 131.117460510096 },
//     });

//     const marker1 = { lat: 32.93844153354462, lng: 131.11849465150752 }
//     new google.maps.Marker({
//         position: marker1,
//         map,
//         title: "マーカー1",
//     });

//     const marker2 = { lat: 32.93872232706145, lng: 131.10900488326078 }
//     new google.maps.Marker({
//         position: marker2,
//         map,
//         title: "マーカー2",
//     });


// }

window.initMap = initMap;