<?php

$country_list = [];

if (isset($_GET['type'])) {

  $type = $_GET['type'];

  function filterType($list)
  {
    return array_map(function ($data) {
      global $type;
      return [$type => $data[$type]];
    }, $list);
  };

  if ($type === "name") {
    $country_list = filterType($country_dataset, 'name');
  }

  if ($type === "code") {
    $country_list = filterType($country_dataset, 'code');
  }

  if ($type === "both") {
    $country_list = $country_dataset;
  }
}

if (isset($_GET['country'])) {
  $country_list = array_filter($country_list, function ($data) {
    $country = $_GET['country'];
    $name = $data['name'];
    return strtolower($name) === strtolower($country);
  });
  $country_list = array_values($country_list);
}

if (isset($_GET['ls'])) {

  $type = $_GET['type'];
  $start = substr($_GET['ls'], 0, 1);


  if ($_GET['type'] !== 'both') {

    $country_list = array_filter($country_list, function ($data) {
      global $start, $type;
      $firstL = substr($data[$type], 0, 1);
      return strtolower($firstL) === strtolower($start);
    });

    $country_list = array_values($country_list);

  } else {

    $country_list = array_filter($country_list, function ($data) {
      global $start;
      $firstL = substr($data['name'], 0, 1);
      return strtolower($firstL) === strtolower($start);
    });

    $country_list = array_values($country_list);

  }
}

if (isset($_GET['limit'])) {

  $limit = $_GET['limit'];

  $country_list = array_slice($country_list, 0, $limit);
}

echo json_encode($country_list);
