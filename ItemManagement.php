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
        <script src="js/customItemFilter.js"></script>
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
                        { mData: 'Description2' },
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
                            "targets":6
                        },
                        {
                            "render": function(data,type,row) {
                                 return data == -1 ? "Priceless" : data;
                            },
                            "targets":5
                        },
                        {
                            "render": function(data,type,row) {
                                 return data == null ? "Unassigned" : data;
                            },
                            "targets":1
                        }
                    ],
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                } );

                $('.idFilter').click( function() {
                    table.draw();
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
                            document.getElementById("btn-unassign").style.display = "none";
                            document.getElementById("btn-delete").style.display = "none";
                            break;
                        case 1:
                            document.getElementById("btn-new").style.display = "none";
                            if (table.rows('.selected').data()[0].ItemId > -1)
                                document.getElementById("btn-edit").style.display = "inline";
                            else
                                document.getElementById("btn-edit").style.display = "none"; 
                            if (table.rows('.selected').data()[0].AuctionId == null)
                                document.getElementById("btn-unassign").style.display = "none";
                            else
                                document.getElementById("btn-unassign").style.display = "inline";
                            document.getElementById("btn-delete").style.display = "inline";
                            break; 
                    }
                } );

                $('input#noId').click( function () {
                    document.getElementById('auctionId').readOnly = document.getElementById('noId').checked;
                    document.getElementById("auctionId").value = document.getElementById('noId').checked || table.rows('.selected').data().length == 0 ?
                        null :
                        table.rows('.selected').data()[0].AuctionId;
                    isValid();
                } );
                
                $('input#noValue').click( function () {
                    document.getElementById('value').readOnly = document.getElementById('noValue').checked;
                    document.getElementById("value").value = document.getElementById('noValue').checked || table.rows('.selected').data().length == 0 ?
                        null :
                        table.rows('.selected').data()[0].Value;
                    isValid();
                } );
                
                $('button#btn-new').click( function () {
                    $("#title").text("New Item");
                    isValid();
                })

                $('button#btn-edit').click( function () {
                    if (table.rows('.selected').data()[0].AuctionId) {
                        document.getElementById("auctionId").value = table.rows('.selected').data()[0].AuctionId;
                        document.getElementById('noId').checked = false;
                        document.getElementById('auctionId').removeAttribute("readonly");
                    }
                     else{
                        document.getElementById("auctionId").value = null;
                        document.getElementById('auctionId').readonly = true;
                        document.getElementById('noId').checked = true;
                     }

                     document.getElementById("description").value = table.rows('.selected').data()[0].Description;
                     document.getElementById("description2").value = table.rows('.selected').data()[0].Description2;
                     document.getElementById("donatedBy").value = table.rows('.selected').data()[0].DonatedBy;
                     document.getElementById("value").value = table.rows('.selected').data()[0].Value;
                     document.getElementById("itemId").value = table.rows('.selected').data()[0].ItemId;
                     $("#title").text("Edit Item");
                     isValid();
                } );   

                $('button#btn-unassign').click( function () {
                    var auctionId = table.rows('.selected').data()[0].AuctionId;
                    $.ajax ( {
                        type: "Post",
                        url: "phpScripts/unassignAuctionItems.php",
                        data: {auctionId: auctionId },
                        success: function(data) {
                            $('#myDataTable').DataTable().ajax.reload();
                            document.getElementById("btn-new").style.display = "inline";
                            document.getElementById("btn-edit").style.display = "none";
                            document.getElementById("btn-unassign").style.display = "none";
                            document.getElementById("btn-delete").style.display = "none";
                        }
                    });
                } ); 

                $('button#btn-delete').click( function () {
                    if (table.rows('.selected').data()[0].AuctionId == null) {
                        var id = table.rows('.selected').data()[0].ItemId;
                        var isAssigned = false;
                    }
                    else {
                        var id = table.rows('.selected').data()[0].AuctionId;
                        var isAssigned = true;
                    }
                    if (confirm("Are you sure you want to delete the selected item?")) {
                        $.ajax ( {
                            type: "POST",
                            url: "phpScripts/deleteAuctionItem.php",
                            data: {auctionId: id, isAssigned: isAssigned },
                            success: function(data) {
                                $('#myDataTable').DataTable().ajax.reload();
                                document.getElementById("btn-new").style.display = "inline";
                                document.getElementById("btn-edit").style.display = "none";
                                document.getElementById("btn-unassign").style.display = "none";
                                document.getElementById("btn-delete").style.display = "none";
                            }
                        });
                    }
                } ); 

                $("button#submit").click(function(){
                   
                    var url = document.getElementById("itemId").value == "" 
                        ? "phpScripts/AddItemDatabase.php"
                        : "phpScripts/EditItemDatabase.php" ;
                    $.ajax( {
                        type: "POST",
                        url: url,
                        data: $('form.edit').serialize(),
                        success: function(data) {
                            document.getElementById("edit").reset();
                            $('#myDataTable').DataTable().ajax.reload();
                            $("#edit-modal").modal('hide'); 
                            table.rows('.selected').remove();
                        }
                    });
                });

                $('.modal').on('hidden.bs.modal', function(){
                    document.getElementById("edit").reset();
                    $(".error").removeClass("none");
                });   
            });         

            function openCheckBoxDropdown() {
                if (!document.getElementsByClassName("dropper")[0].classList.contains("auto-height")) document.getElementsByClassName("dropper")[0].classList.add("auto-height");
                else document.getElementsByClassName("dropper")[0].classList.remove("auto-height");
            }

            function clickInput(id) {
                document.getElementById(id).click();
            }

            function checkId () {
                var id = document.getElementById('auctionId').value;
                var idExists = document.getElementById('noId').checked;
                if ((id > 99 && id < 400) || (id > 599 && id < 700) || idExists ) {
                    document.getElementById("auctionError").classList.add("none");
                    return true;
                }   
                else {
                    document.getElementById("auctionError").classList.remove("none");
                    return false;
                }
            }

            function checkDescription () {
                var description = document.getElementById('description').value;
                if (description == null || description == "" ) {
                    document.getElementById("descriptionError").classList.remove("none");
                    return false;
                }   
                else {
                    document.getElementById("descriptionError").classList.add("none");
                    return true;
                }
            }

            function checkDonatedBy () {
                var donatedBy = document.getElementById('donatedBy').value;
                if (donatedBy == null || donatedBy == "" ) {
                    document.getElementById("donatedByError").classList.remove("none");
                    return false;
                }   
                else {
                    document.getElementById("donatedByError").classList.add("none");
                    return true;
                }
            }

            function checkValue () {
                var value = document.getElementById('value').value;
                var priceless = document.getElementById('noValue').checked;
                if (value !== "" || priceless ) {
                    document.getElementById("valueError").classList.add("none");
                    return true;
                }   
                else {
                    document.getElementById("valueError").classList.remove("none");
                    return false;
                }
            }

            function isValid () {
                if (checkId() && checkDescription() && checkDonatedBy() && checkValue() ) 
                    document.getElementById("submit").removeAttribute('disabled');
                else
                    document.getElementById("submit").disabled = true;
            }

		</script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="UserManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div style="width: 100% !important;" class="container body-content top">
            <div>
                <button type="button" id="btn-new" class="btn btn-info btn-primary" data-toggle="modal" data-target="#edit-modal" style="display: inline;">New Item</button>
                <button type="button" id="btn-edit" class="btn btn-info btn-primary" data-toggle="modal" data-target="#edit-modal" style="display: none;">Edit Item</button>
                <button type="button" id="btn-delete" class="btn btn-danger" style="display: none;">Delete Item</button>
                <button type="button" id="btn-unassign" class="btn btn-warning" style="display: none;">Unassign Item</button> 
            </div>
            <br />
            <div onclick="openCheckBoxDropdown()" class="groups" data-toggle="dropdown">Select Groups ↓</div>
            <div class="dropper" style="top: 98px !important">
                <div onclick="clickInput('one')" class="dropdown">100's <input id="one" class="idFilter check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('two')" class="dropdown">200's <input id="two" class="idFilter check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('three')" class="dropdown">300's <input id="three" class="idFilter check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('six')" class="dropdown">600's <input id="six" class="idFilter check-boxes" checked type="checkbox"></div>
                <div onclick="clickInput('unassigned')" class="dropdown">Not Numbered<input id="unassigned" class="idFilter check-boxes" checked type="checkbox"></div>
            </div>
            <table id="myDataTable"  class="display stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td ></td>
                        <td class=" first head">AuctionId</td>
                        <td class="head">Description</td>
                        <td class="head">Optional Description</td>
                        <td class="head">Donated By</td>
                        <td class="head">Value</td>
                        <td class="last head">Last Edited By</td>
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
                        <input id="itemId", name="itemId" type="hidden">
						<strong>AuctionId</strong>
						<br />
                        <input id="auctionId" type="number" name="auctionId" class="input-xlarge" onkeyup=isValid() readonly>
                        <label><input type="checkbox" value="true" class="input-xlarge" name="noId" id="noId" checked>No AuctionId</label>
						<br /><br /><strong>Description</strong><br />
						<textarea id="description" name="description" class="input-xlarge" onkeyup="isValid()"></textarea>
						<br /><br /><strong>Optional Description</strong><br />
						<textarea id="description2" name="description2" class="input-xlarge"></textarea>
						<br /><br /><strong>Donated By</strong><br />					
                        <input id="donatedBy" name="donatedBy" type="text" class="input-xlarge" value="" onkeyup="isValid()">
                        <br /><br /> <strong>Value</strong><br />
                        <input id="value" type="number" name="value" step="0.01" class="input-xlarge" onkeyup="isValid()">
                        <label><input type="checkbox" value="true" class="input-xlarge" name="noValue" id="noValue">Priceless</label>
					</form>
                    <div class="error none" id="auctionError">That Auction Number is invalid</div>
                    <div class="error none" id="descriptionError">Description is required</div>
                    <div class="error none" id="donatedByError">Donated By is required</div>
                    <div class="error none" id="valueError">Item value is required</div>
				</div>			
				<div class="modal-footer">
					<button class="btn btn-success" disabled id="submit">Save</button>
					<a href="#" class="btn" data-dismiss="modal">Close</a>
				</div>
			</div>
        </div>
    </div> 
    <div id='response'></div>   
     </body>
</html>

