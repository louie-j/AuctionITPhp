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
            $( document ).ready(function() {
                
                var table = $('#myDataTable').DataTable( {
                    "ajax": "phpScripts/ViewItemTable.php",
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
                });

                $('select').on('change', function() {
                    if (table.page.info().pages == 1) document.getElementById("start").style.display = "none";
                    else document.getElementById("start").style.display = "block";
                });

                setInterval( function () {
                    table.ajax.reload(null, false);                    
                }, 10000 );


            });
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
