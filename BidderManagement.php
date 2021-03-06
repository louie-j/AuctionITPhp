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
            $( document ).ready(function()
            {
                var table = $('#myDataTable').DataTable( {
                    ajax: "PhpScripts/ViewBidders.php", 
                    resposive: true,

                    columns: [
                        { mData: 'bidder_id', searchable: true},
                        { mData: 'name', searchable: true} ,
                        { mData: 'phone', searchable: false},
                        { mData: 'address', searchable: false}
       
                    ],
                    order: [[0, "asc"]]
                } );

                 $('#myDataTable tbody').on('click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    switch (table.rows('.selected').data().length) {
                        case 0:
                            document.getElementById("btn-new").style.display = "inline";
                            document.getElementById("btn-edit").style.display = "none";
                            document.getElementById("btn-delete").style.display = "none";
                            break;
                        case 1:
                            document.getElementById("btn-new").style.display = "none";
                            document.getElementById("btn-edit").style.display = "inline"; 
                            document.getElementById("btn-delete").style.display = "inline";
                            break; 
                    }
                } );
                
                $('button#btn-new').click( function () {
                    $("#title").text("New Bidder");
                    document.getElementById("lbl-bidder").style.display = "none";
                })

                $('button#btn-edit').click( function () {
                    document.getElementById("lbl-bidder").style.display = "block";
                    $("#bidder").text(table.rows('.selected').data()[0].bidder_id);
                     document.getElementById("bidderId").value = table.rows('.selected').data()[0].bidder_id;
                     document.getElementById("phone").value = table.rows('.selected').data()[0].phone;
                     document.getElementById("address").value = table.rows('.selected').data()[0].address;
                     document.getElementById("name").value = table.rows('.selected').data()[0].name;
                     $("#title").text("Edit Bidder");
                } );   

                $('button#btn-delete').click( function () {
                    var bidderId = table.rows('.selected').data()[0].bidder_id;
                    if (confirm("Are you sure you want to delete the selected item?")) {
                        $.ajax ( {
                            type: "POST",
                            url: "PhpScripts/DeleteBidder.php",
                            data: {bidderId: bidderId},
                            success: function(data) {
                                $('#myDataTable').DataTable().ajax.reload();
                                document.getElementById("btn-new").style.display = "inline";
                                document.getElementById("btn-edit").style.display = "none";
                                document.getElementById("btn-delete").style.display = "none";
                            }
                        });
                    }
                } ); 

                $("button#submit").click(function(){
                      var url = document.getElementById("bidderId").value == "" 
                        ? "PhpScripts/RegisterBidderDatabase.php"
                        : "PhpScripts/EditBidder.php" ; 
                    $.ajax( {
                        type: "POST",
                        url: url,
                        data: $('form.edit').serialize(),
                        success: function(data) {
                            document.getElementById("edit").reset();
                            $('#myDataTable').DataTable().ajax.reload();
                            $("#edit-modal").modal('hide'); 
                            table.rows('.selected').remove(); 
                            document.getElementById("btn-new").style.display = "inline";
                            document.getElementById("btn-edit").style.display = "none";
                            document.getElementById("btn-delete").style.display = "none";
                        }
                    });
                });

                $('.modal').on('hidden.bs.modal', function(){
                    document.getElementById("edit").reset(); 
                    $("#bidder").text("");
                });   
            });         

		</script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="BidderManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div class="container body-content top">
            <div>
                <button type="button" id="btn-new" class="btn btn-info btn-primary" data-toggle="modal" data-target="#edit-modal" style="display: inline;">New Bidder</button>
                <button type="button" id="btn-edit" class="btn btn-info btn-primary" data-toggle="modal" data-target="#edit-modal" style="display: none;">Edit Bidder</button>
                <button type="button" id="btn-delete" class="btn btn-danger" style="display: none;">Delete Bidder</button>
            </div>
            <br />
            <table id="myDataTable"  class="display stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class=" first head">BidderId</td>
                        <td class="head">Name</td>
                        <td class="head">Phone Number</td>
                        <td class="last head">Address</td>
                    </tr>
                </thead>
            </table>    
         
	
	        
    <div id="edit-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">				
				<div class="modal-header">
					<h3 id="title"></h3>
				</div>				
				<div class="modal-body">
					<form class="edit" name="edit" id="edit">
                    <strong id="lbl-bidder">BidderId</strong>
						<p id="bidder" name="bidder" type="text"></p>
                        <input id="bidderId", name="bidderId" type="hidden">
						<strong>Name</strong><br />
						<input id="name" name="name" class="input-xlarge" type="text">
						<br /><br /><strong>Phone Number</strong><br />					
                        <input id="phone" name="phone" type="tel" class="input-xlarge">
                        <br /><br /> <strong>Address</strong><br />
                        <textarea id="address" name="address" class="input-xlarge"></textarea>
					</form>
				</div>			
				<div class="modal-footer">
					<button class="btn btn-success" id="submit">Save</button>
					<a href="#" class="btn" data-dismiss="modal">Close</a>
				</div>
			</div>
        </div>
    </div>  
     </body>
</html>

