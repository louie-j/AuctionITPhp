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
                            document.getElementById("btn-edit").style.display = "inline";
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

                 $('button#btn-merge').click( function () {
                     console.log("Merge");
                    console.log( table.rows('.selected').data()[0]);
                } );               
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
                        <td class="first head">AuctionId</td>
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
					<a class="close" data-dismiss="modal">�</a>
					<h3>Send Feedback</h3>
				</div>				
				<div class="modal-body">
					<form class="edit" name="edit">
						<strong>AuctionId</strong>
						<br />
						<input type="text" name="auctionId" class="input-xlarge" value="Laeeq">
						<br /><br /><strong>Email</strong><br />
						<input type="email" name="email" class="input-xlarge" value="phpzag@gmail.com">
						<br /><br /><strong>Message</strong><br />					
						<textarea name="message" class="input-xlarge">Thanks for tutorials and demos!</textarea>
					</form>
				</div>			
				<div class="modal-footer">
					<button class="btn btn-success" id="submit">Send</button>
					<a href="#" class="btn" data-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
	</div>
        </div>
     </body>
</html>

