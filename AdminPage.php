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
            if($_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
		<script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
        <script type="text/javascript">
            $( document ).ready(function()
            {
                var table = $('#myDataTable').DataTable( {
                    "ajax": "phpScripts/viewAccountsTable.php", 
                    "bPaginate":true,
                    "bProcessing": true,
                    "columns": [
                        { mData: 'Username', "searchable": true } ,
                        { mData: 'Type', "searchable": false },
                        { mData: 'Active', "searchable": false },
                        {  "targets": -1,
                            "data": null,
                            "orderable":false,
                            "defaultContent": "<button>Edit</button>"}         
                    ],
                    "columnDefs": [
                        {
                            "render": function(data,type,row) {
                                 return data == 1 ? 'Active' : 'Inactive';
                            },
                            "targets":1
                        },
                        {
                            "render": function(data,type,row) {
                                 return data == 1 ? 'User' : 'Admin';
                            },
                            "targets":2
                        }
                    ]
                    
                } );

                //Function that responds to user clicking edit button
                $('#myDataTable tbody').on( 'click', 'button', function () {
                    var dataObj = table.row( $(this).parents('td') ).data();
                       
                    //alert( JSON.stringify(data));//alert( JSON.stringify(data));
                    var data    = Object.values(dataObj);
                    $('#UserManagementBody').data( 'accType', data[3] );
                    $('#UserManagementBody').data( 'status', data[4] );

                    //var accType =data[3]; 
                    //var status = data[4];
                   // alert("test" + data[4]);
                    $("#UserManagementBody").load("AccountEditor.php").dialog({
                        appendTo: "#UserManagementBody"
                        
                        });
                    } );    
                    //intialializeRadioBtns(); 

                    setInterval( function () {
                    table.ajax.reload(null, false);
                }, 10000 );
            });
            var interval;
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
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="UserManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div class="container body-content top">
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class="first head">Username</td>
                        <td class="head">State</td>
                        <td class="head">User Type</td>
                        <td class="last head">Edit</td>
                    </tr>
                </thead>
            </table>
        <input id="start" type="button" class="center btn-info" value="Start Rotating Through Pages" onclick="changePagesAutomatically();" />
    </body>

</html>

