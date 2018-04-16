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
                    ajax: "phpScripts/viewAllItems.php", 
                    resposive: true,
                    columns: [
                        { mData: 'AuctionId'  } ,
                        { mData: 'Description' },
                        { mData: 'DonatedBy' },
                        { mData: 'Value' },
                        { mData: null },
       
                    ],
                    select: true,
                    responsive: true,
                    columnDefs: [
                        {
                            "render": function(data,type,row) {
                                var date = new Date(data.LastModified).toLocaleDateString();
                                 return data.LastModifiedBy + ' on ' + date;
                            },
                            "targets":4
                        }
                    ]
                } );

                 $('#myDataTable tbody').on('click', 'tr', function () {
                    var data = table.row( this ).data();
                    console.log(data);
                    alert( 'You clicked on '+data.AuctionId+'\'s row' );
                    $(this).toggleClass('selected');
                } );

                 $('#button').click( function () {
                    table.row('.selected').remove().draw( false );
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
        
		<div class="container body-content top">
            <table id="myDataTable"  class="display stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class="first head">AuctionId</td>
                        <td class="head">Description</td>
                        <td class="head">Value</td>
                        <td class="head">Donated By</td>
                        <td class="last head">Last Edited By</td>
                    </tr>
                </thead>
            </table>
     </body>

</html>

