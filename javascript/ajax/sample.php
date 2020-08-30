<?php

function getCd($type) {
  $data = [
    ["cd" => 8001, "name" => "山崎"],
    ["cd" => 8002, "name" => "猪木"],
    ["cd" => 8003, "name" => "猪木"],
  ];
  if($type === "person") {
    $ids = [];
    foreach($data as $row) {
      $ids[] = $row["cd"];
    }
    $cd = max($ids);
    $cd +=1;
  }
  return $cd;
}

echo getCd("person");
