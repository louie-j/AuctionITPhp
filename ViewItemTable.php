<?php
    require 'DatabaseConnection.php';
    $conn = Connect();
    $year = date("Y");
    $query = "CALL viewItemTable(".$year.")";
    $result = $conn->query($query);
    $data = array();
    while( $rows = mysqli_fetch_assoc($result) ) {
        $data[] = $rows;
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
   
?>

