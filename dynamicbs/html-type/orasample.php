<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oracle Database Connection Template</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/filterable.css">

</head>

<body>

	<div class="container">
    
    	<div class="page-header">
        <h3>Oracle Database Connection Sample</a></h3>
        </div>
        
        <div class="row">
        
        	<div class="col-lg-12">
            	
         <div class="panel panel-primary filterable">
             <div class="panel-heading">
                 <h3 class="panel-title">Tables</h3>
                 <div class="pull-right">
                     <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                 </div>
             </div>
            		<table class="table table-striped table-hover table-condensed">
            		
            		<thead>
            			<tr class="filters">
            				<th><input type="text" class="form-control" placeholder="Table Name" disabled></th>
            				<th><input type="text" class="form-control" placeholder="Object Type" disabled></th>
            				<th><input type="text" class="form-control" placeholder="View" disabled></th>
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


<script src="../assets/jquery-1.12.4.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/filterable.js"></script>


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
