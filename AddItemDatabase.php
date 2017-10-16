<?php
header('Location: AddItem.php');

require 'databaseConnection.php';
$itemNumber = $description = $donatedBy = $value = "";

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);

$sql = "SELECT ItemId, Description, DonatedBy, Value FROM auctionitems WHERE ItemId = '" . $itemNumber . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $newdescription = $row["Description"] . ' and ' . $description;
        $newDonatedBy = $row["DonatedBy"] . ' and ' . $donatedBy;
        $sumValue = $row["Value"] + $value;
        $query   = "UPDATE auctionitems SET Description = '" . $newdescription . "', DonatedBy = '" . $newDonatedBy . "',Value = '" . $sumValue . "' WHERE ItemId = '" . $itemNumber . "'";
        $success = $conn->query($query);
    }
    if (!$success) {
    die("Couldn't enter data: ".$conn->error);
    }
    echo "Item Added <br>";
} 
else {
        $query   = "INSERT into auctionitems (ItemId,Description,DonatedBy,Value) VALUES('" . $itemNumber . "','" . $description . "','" . $donatedBy . "','" . $value . "')";
        $success = $conn->query($query);
        if (!$success) {
            die("Couldn't enter data: ".$conn->error);
 
        }
        echo "Item Added <br>";
}

 
$conn->close();
?>
