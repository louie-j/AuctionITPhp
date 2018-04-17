<?php
    require 'DatabaseConnection.php';
    $conn = Connect();
    $year = date("Y");

    $hundred = $twohundred = $threehundred = $sixhundred = 'true';
    $unmarked = 'false';

    if(isset($_GET['hundred'])) $hundred = $conn->real_escape_string($_GET['hundred']);
    if(isset($_GET['twohundred'])) $twohundred = $conn->real_escape_string($_GET['twohundred']);
    if(isset($_GET['threehundred'])) $threehundred = $conn->real_escape_string($_GET['threehundred']);
    if(isset($_GET['sixhundred'])) $sixhundred = $conn->real_escape_string($_GET['sixhundred']);
    if(isset($_GET['unmarked'])) $unmarked = $conn->real_escape_string($_GET['unmarked']);


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