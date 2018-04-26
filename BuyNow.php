<?php
    session_start();
    if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
    {
        header('Location: index.php'); 
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
		<script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
        <script type="text/javascript">
            var toBuy;
            var text;
            var total;
            $( document ).ready(function()
            {
                var table = $('#myDataTable').DataTable( {
                    ajax: "PhpScripts/ViewSixHundreds.php", 
                    resposive: true,
                    paginate: false,
                    columns: [
                        { mData: 'auctionId', searchable: true} ,
                        { mData: 'description', searchable: true},
                        { mData: 'value', searchable: false},
                        { "targets": -1, "data": null, 
                          "defaultContent": "<input class='table-input' onkeyup='updateCart()' type='number'>" }
                    ],
                    order: [[0, "asc"]]
                } );
            });

            function updateCart() {
                var allValid = true;
                var rows = document.getElementsByTagName('tr');
                toBuy = [];
                for (var i = 1; i < rows.length; i++) {
                    var buyNowObj = { "id": rows[i].cells[0].textContent, 
                                  "description": rows[i].cells[1].textContent, 
                                  "value": rows[i].cells[2].textContent,
                                  "quantity": rows[i].cells[3].children[0].value };
                    if (buyNowObj.quantity > 0) toBuy.push(buyNowObj);
                    if (buyNowObj.quantity < 0) {
                        document.getElementById('quantity-error').classList.remove('none');
                        allValid = false;
                    }
                }
                if (allValid && toBuy.length) {
                    document.getElementById('enabled').classList.remove('none');
                    document.getElementById('disabled').classList.add('none');
                    document.getElementById('total').classList.remove('none');
                    document.getElementById('quantity-error').classList.add('none');
                    runningTotal();    
                }
                else {
                    document.getElementById('disabled').classList.remove('none');
                    document.getElementById('enabled').classList.add('none');
                    if (allValid) document.getElementById('total').classList.add('none');
                }
            }

            function runningTotal() {
                total = 0;
                text = "";
                for (var i = 0; i < toBuy.length; i++) {
                    total += ( parseInt(toBuy[i].quantity) * parseInt(toBuy[i].value));
                    text += (toBuy[i].quantity + " " + toBuy[i].description + ", ");
                }
                text = text.substring(0,text.length-2);
                text += " = $" + total;
                document.getElementById('total').textContent = text;
            }

            function areYouSure() {
                alert("Are you sure you want to spend $" + total + " on " + text.substring(0,text.length - 4 - total.toString().length) + "?");
            }

        </script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container">
            <table id="myDataTable"  class="display stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class=" first head">AuctionId</td>
                        <td class="head">Description</td>
                        <td class="head">Value</td>
                        <td class="head last">Quantity</td>
                    </tr>
                </thead>
            </table>
            <div class="after-table">
                <div id="total" class="total"></div>
                <button onclick="areYouSure()" id="enabled" class="btn btn-primary none">Buy Now</button>
                <button id="disabled" disabled class="btn btn-primary">Buy Now</button>
                <div id="quantity-error" class="error none">Quantity cannot be negative</div>
            </div>

        </div>
    </body>