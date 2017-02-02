<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bootstrap Modal with Dynamic MySQL Data using Ajax & PHP</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">

</head>

<body>

	<div class="container">
    
    	<div class="page-header">
        <h3>Modal with Dynamic MySQL Data using Ajax & PHP</a></h3>
        </div>
        
        <div class="row">
        
        	<div class="col-lg-12">
            	
            		<table class="table table-striped table-hover table-condensed">
            		
            		<thead>
            			<tr>
            				<th>Full Name</th>
            				<th>Email Address</th>
            				<th>View Profile</th>
            				<th>Action</th>
            			</tr>
            		</thead>
            		
            		<tbody>
            		
            		<?php
            		
            		require_once 'dbconfig.php';
            		
            		$query = "SELECT * FROM tbl_members";
            		$stmt = $DBcon->prepare( $query );
            		$stmt->execute();
            		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
						?>
            <!--START if condition depend on the data -->
            <?php if ($row['email'] == "jacksilva@mail.com"): ?>
						 <tr class="danger">
            <?php else: ?>
             <tr>
            <?php endif; ?>
            <!--END   if condition depend on the data -->
						<td><?php echo $row['first_name']."&nbsp;".$row['last_name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td>
						<button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $row['user_id']; ?>" id="getUser" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
						</td>
            <td>
            <?php if ($row['email'] == "jacksilva@mail.com"): ?>
						 <button class="btn btn-danger">Action</button>
            <?php endif; ?>
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
