<?php
  # CAVEAT: Uses the currently beta (as of April 2012) SODA 2.0 API

  require_once("socrata-php/public/socrata.php");

  $socrata = new Socrata("http://data.seattle.gov");

  $geo_column = "geolocation";
  $dataset = "public-art";
  $lat = array_get("latitude", $_POST);
  $long = array_get("longitude", $_POST);
  $meters = array_get("range", $_POST);

  $params = array();
  $params["\$where"] = "within_circle($geo_column, $lat, $long, $meters)";

  $response = $socrata->get("/resource/$dataset.json", $params);
?>
<html>
  <head>
    <title>Seattle Public Art</title>
  </head>
  <body>
    <h1>Seattle Public Art</h1>

      <?# Print rows ?>
      <?php foreach($response as $row) { ?>
        <h2><?= $row["title"] ?></h2>

        <img src="<?= "http://maps.google.com/maps/api/staticmap?center=" . $row["geolocation"]["latitude"] . "," . $row["geolocation"]["longitude"] . "&zoom=14&size=400x400&sensor=false&markers=" . $row["geolocation"]["latitude"] . "," . $row["geolocation"]["longitude"] ?>" />

        <h3>Raw Hash</h3>
        <pre>
          <?= var_dump($row) ?>
        </pre>
      <?php } ?>
  </body>
</html>
