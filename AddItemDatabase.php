<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$itemNumber = $description = $donatedBy = $value = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $itemNumber = test_input($_POST["itemNumber"]);
  $description = test_input($_POST["decription"]);
  $donatedBy = test_input($_POST["donatedBy"]);
  $value = test_input($_POST["value"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
