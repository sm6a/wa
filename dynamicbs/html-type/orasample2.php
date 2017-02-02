<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oracle Database Connection Template</title>

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body>

	<div class="container">
    
    	<div class="page-header">
        <h3>Oracle Database Connection Sample</a></h3>
        </div>
        
        <div class="row">
        
        	<div class="col-lg-12">
            	
         <div class="panel panel-default">
             <div class="panel-heading">
               Tables
             </div>
                <div class="panel-body">
            		<table width="100%" class="table table-striped table-hover table-condensed" id="dataTables-example">
            		
            		<thead>
            			<tr>
            				<th>Table Name</th>
            				<th>Table Type</th>
            				<th>View</th>
            			</tr>
            		</thead>
            		
            		<tbody>
            		
            		<?php
            		
            		require_once 'oraconfig.php';
            		
            		$query = oci_parse($conn, "SELECT TNAME, TABTYPE FROM tab");
            		oci_execute($query);
            		while($row=oci_fetch_array($query, OCI_ASSOC+OCI_RETURN_NULLS)){
						?>
            <tr>
						<td><?php echo $row['TNAME']; ?></td>
						<td><?php echo $row['TABTYPE']; ?></td>
						<td>
						<button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $row['user_id']; ?>" id="getUser" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
						</td>
						</tr>
						<?php
					}
            		?>
            		
            		</tbody>
            		</table>      
                </div>
                
            </div>
        
        </div>
        
        
        
        
        <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
                            	<i class="glyphicon glyphicon-user"></i> User Profile
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                       	   <div id="modal-loader" style="display: none; text-align: center;">
                       	   	<img src="ajax-loader.gif">
                       	   </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content"></div>
                             
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div><!-- /.modal -->    
    
    </div>

 <!-- jQuery -->
 <script src="../vendor/jquery/jquery.min.js"></script>

 <!-- Bootstrap Core JavaScript -->
 <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
                                                                                                                                                        
 <!-- Metis Menu Plugin JavaScript -->
 <script src="../vendor/metisMenu/metisMenu.min.js"></script>

 <!-- DataTables JavaScript -->
 <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
 <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
 <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

 <!-- Custom Theme JavaScript -->
 <script src="../dist/js/sb-admin-2.js"></script>

 <!-- Page-Level Demo Scripts - Tables - Use for reference -->
 <script>
 $(document).ready(function() {
     $('#dataTables-example').DataTable({
         responsive: true
     });
 });
 </script>

<script>
$(document).ready(function(){
	
	$(document).on('click', '#getUser', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		
		$.ajax({
			url: 'getuser.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content').html('');    
			$('#dynamic-content').html(data); // load response 
			$('#modal-loader').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader').hide();
		});
		
	});
	
});

</script>

</body>
</html>
