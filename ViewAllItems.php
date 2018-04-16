<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <?php
            session_start();
            if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
        <script type="text/javascript">
            var interval;
            var table;
            $( document ).ready(function() {                
                table = $('#myDataTable').DataTable( {
                    "ajax": {
                        "url": "phpScripts/ViewItemTable.php",
                        "data": {
                            "hundred": true,
                            "twohundred": true,
                            "threehundred": true,
                            "sixhundred": true,
                            "unmarked": true,
                        }
                    },
                    "bPaginate":true,
                    "bProcessing": true,
                    "columns": [
                        { mData: 'auctionId', "searchable": true } ,
                        { mData: 'description', "searchable": true },
                        { mData: 'donatedBy', "searchable": false },
                        { mData: 'value', "searchable": false},                        
                        { mData: 'winningbidder', "searchable": false},
                        { mData: 'winningbid', "searchable": false}
                    ]
                }); // end data table

                $('select').on('change', function() {
                    if (table.page.info().pages == 1) document.getElementById("start").style.display = "none";
                    else document.getElementById("start").style.display = "block";
                });
            }); // end on ready


            function changePagesAutomatically()
            {
                var table = $('#myDataTable').DataTable();
                if(interval)
                {
                    document.getElementById("start").value = "Start Rotating Pages";
                    clearInterval(interval);
                    interval = null;
                }
                else
                {
                    document.getElementById("start").value = "Stop Rotating Pages";
                    interval = setInterval( function () {
                        var info = table.page.info();
                        var pageNum = (info.page < info.pages) ? info.page + 1 : 1;
                        table.page(pageNum).draw(false); 
                    }, 10000);                   
                }
            }

            function openCheckBoxDropdown() {
                if (!document.getElementsByClassName("dropper")[0].classList.contains("auto-height")) document.getElementsByClassName("dropper")[0].classList.add("auto-height");
                else document.getElementsByClassName("dropper")[0].classList.remove("auto-height");
            }

            function changeDataTable() {
                var table = $('#myDataTable').DataTable();
                var hundred = document.getElementById('1').checked;
                var twohundred = document.getElementById('2').checked;
                var threehundred = document.getElementById('3').checked;
                var sixhundred = document.getElementById('6').checked;
                var unmarked = document.getElementById('-1').checked;

                table.destroy();

                table = $('#myDataTable').DataTable( {
                    "ajax": {
                        "url": "phpScripts/ViewItemTable.php",
                        "data": {
                            "hundred": hundred,
                            "twohundred": twohundred,
                            "threehundred": threehundred,
                            "sixhundred": sixhundred,
                            "unmarked": unmarked,
                        }
                    },
                    "bPaginate":true,
                    "bProcessing": true,
                    "columns": [
                        { mData: 'auctionId', "searchable": true } ,
                        { mData: 'description', "searchable": true },
                        { mData: 'donatedBy', "searchable": false },
                        { mData: 'value', "searchable": false},                        
                        { mData: 'winningbidder', "searchable": false},
                        { mData: 'winningbid', "searchable": false}
                    ]
                }); // end data table
            } // end change data table

            function clickInput(id) {
                document.getElementById(id).click();
            }

        </script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container body-content top">
            <div onclick="openCheckBoxDropdown()" class="groups">Select Groups ↓</div>
            <div class="dropper">
                <div onclick="clickInput('1')" class="dropdown">100's <input onchange="changeDataTable()" id="1" class="check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('2')" class="dropdown">200's <input onchange="changeDataTable()" id="2" class="check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('3')" class="dropdown">300's <input onchange="changeDataTable()" id="3" class="check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('6')" class="dropdown">600's <input onchange="changeDataTable()" id="6" class="check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('-1')" class="dropdown">Not Numbered<input onchange="changeDataTable()" id="-1" class="check-boxes" checked type="checkbox"></div>
            </div>

            
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class="first head">ItemId</td>
                        <td class="head">Description</td>
                        <td class="head">Donated By</td>
                        <td class="head">Value</td>
                        <td class="head">Winning Bidder</td>
                        <td class="last head">Winning Bid</td>
                    </tr>
                </thead>
            </table>
            <input id="start" type="button" class="btn-info center" value="Start Rotating Pages" onclick="changePagesAutomatically();" />
        </div>
    </body>
</html>
