<?php
require 'DatabaseConnection.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$conn = Connect();
$userName    = $conn->real_escape_string($_POST['userName']);
$password   = $conn->real_escape_string($_POST['password']);
$sql = "CALL checkPassword('" . $userName . "','" . $password . "')";
$result = $conn->query($sql);

foreach($result as $row)
{
    if($row["Type"] == 1)
    {
        echo($password);
        echo("It works. 1");
    }   
    if($row["Type"] == 2)
    {
        echo("It works. 2");
    }
    if($row["Type"] == -1)
    {
        echo("It works. -1");
                echo($password);
    }
    if($row["Type"] == 0)
    {
        echo("It works. 0");
    }
}