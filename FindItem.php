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
                        { mData: 'ItemId', visible: false},
                        { mData: 'AuctionId'  } ,
                        { mData: 'Description' },
                        { mData: 'DonatedBy' },
                        { mData: 'Value' },
                        { mData: null },
       
                    ],
                    columnDefs: [
                        {
                            "render": function(data,type,row) {
                                var date = new Date(data.LastModified).toLocaleDateString();
                                 return data.LastModifiedBy + ' on ' + date;
                            },
                            "targets":5
                        }
                    ]
                } );

                 $('#myDataTable tbody').on('click', 'tr', function () {
                    var data = table.row( this ).data();
                    console.log(data);
                    //alert( 'You clicked on '+data.AuctionId+'\'s row' );
                    $(this).toggleClass('selected');
                    switch (table.rows('.selected').data().length) {
                        case 0:
                            document.getElementById("btn-edit").style.display = "none";
                            document.getElementById("btn-merge").style.display = "none";
                            document.getElementById("btn-separate").style.display = "none";
                            document.getElementById("btn-delete").style.display = "none";
                            break;
                        case 1:
                            if (table.rows('.selected').data()[0].ItemId > -1)
                                document.getElementById("btn-edit").style.display = "inline";
                            else
                                document.getElementById("btn-edit").style.display = "none";    
                            document.getElementById("btn-merge").style.display = "none";
                            document.getElementById("btn-separate").style.display = "inline";
                            document.getElementById("btn-delete").style.display = "inline";
                            break;
                        default:
                            document.getElementById("btn-edit").style.display = "none";
                            document.getElementById("btn-merge").style.display = "inline";
                            document.getElementById("btn-separate").style.display = "none";
                            document.getElementById("btn-delete").style.display = "inline";
                            break;    

                    }
                } );

                $('button#btn-edit').click( function () {
                     document.getElementById("auctionId").value = table.rows('.selected').data()[0].AuctionId;
                     document.getElementById("description").value = table.rows('.selected').data()[0].Description;
                     document.getElementById("donatedBy").value = table.rows('.selected').data()[0].DonatedBy;
                     document.getElementById("value").value = table.rows('.selected').data()[0].Value;
                     document.getElementById("itemId").value = table.rows('.selected').data()[0].ItemId;
                } );    

                 $('button#btn-merge').click( function () {
                     console.log("Merge");
                    console.log( table.rows('.selected').data()[0]);
                } );
                $("button#submit").click(function(){
                    console.log("Save Button");
                    console.log($('form.edit').serialize());
                    $.ajax( {
                        type: "POST",
                        url: "phpScripts/EditItemDatabase.php",
                        data: $('form.edit').serialize(),
                        success: function(data) {
                            $('#myDataTable').DataTable().ajax.reload();
                            $("#edit-modal").modal('hide'); 
                        }
                    });
                });               
            });         
		</script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/DataTables-1.10.16/css/dataTables.jqueryui.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="UserManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div class="container body-content top">
            <table id="myDataTable"  class="display stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td ></td>
                        <td class=" first head">AuctionId</td>
                        <td class="head">Description</td>
                        <td class="head">Donated By</td>
                        <td class="head">Value</td>
                        <td class="last head">Last Edited By</td>
                    </tr>
                </thead>
            </table>
                <button type="button" id="btn-edit" class="btn btn-info btn-primary" data-toggle="modal" data-target="#edit-modal">Edit</button>
                <button type="button" id="btn-merge" class="btn btn-primary">Merge</button>
                <button type="button" id="btn-delete" class="btn btn-danger">Delete</button>
                <button type="button" id="btn-separate" class="btn btn-warning">Separate</button>           
         
	
	        
    <div id="edit-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">				
				<div class="modal-header">
					<h3>Edit Item</h3>
				</div>				
				<div class="modal-body">
					<form class="edit" name="edit">
                        <input id="itemId", name="itemId" type="hidden">
						<strong>AuctionId</strong>
						<br />
						<input id="auctionId" type="number" name="auctionId" class="input-xlarge" value=0>
						<br /><br /><strong>Description</strong><br />
						<textarea id="description" name="description" class="input-xlarge"></textarea>
						<br /><br /><strong>Donated By</strong><br />					
                        <input id="donatedBy" name="donatedBy" type="text" class="input-xlarge" value="">
                        <br /><br /> <strong>Value</strong>
						<br />
                        <input id="value" type="number" name="value" step="0.01" class="input-xlarge" value=0>
					</form>
				</div>			
				<div class="modal-footer">
					<button class="btn btn-success" id="submit">Save</button>
					<a href="#" class="btn" data-dismiss="modal">Close</a>
				</div>
			</div>
        </div>
    </div> 
    <div id='response'></div>   
     </body>
</html>

