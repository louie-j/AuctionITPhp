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
        <script src="js/jquery.dataTables.min.js"></script>
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
		
		</script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="UserManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div class="container body-content">
            <input id="clickMe" type="button" class="btn-info" value="Start/Stop Rotating Through Pages" onclick="changePagesAutomatically();" />
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td>Username</td>
                        <td>State</td>
                        <td>User Type</td>
                        <td>Edit</td>
                    </tr>
                </thead>
            </table>
    </body>

</html>

