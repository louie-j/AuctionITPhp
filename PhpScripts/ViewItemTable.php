<?php
    require 'DatabaseConnection.php';
    $conn = Connect();
    $year = date("Y");

    $hundred = $conn->real_escape_string($_GET['hundred']);
    $twohundred = $conn->real_escape_string($_GET['twohundred']);
    $threehundred = $conn->real_escape_string($_GET['threehundred']);
    $sixhundred = $conn->real_escape_string($_GET['sixhundred']);
    $unmarked = $conn->real_escape_string($_GET['unmarked']);


    $sql = "call viewAuctionItemGroups(" . $hundred . "," . $twohundred . "," . $threehundred . "," . $sixhundred . "," . $unmarked .")";
    $result = $conn->query($sql);
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