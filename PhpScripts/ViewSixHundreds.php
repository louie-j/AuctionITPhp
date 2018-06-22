<?php

    require 'DatabaseConnection.php';

    $conn   = Connect();
    $result = $conn->query("SELECT * FROM view_six_hundreds");
    $data   = array();

    while( $rows = mysqli_fetch_assoc($result) ) {
        $data[] = $rows;
    }

    echo json_encode(array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData" => $data
    ));
   
?>