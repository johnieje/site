    
<div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">List of members </h1>
	<p>Below is the list of the members.</p>
	<a href="<?php echo base_url(); ?>member/add_member"><button class="btn btn-lg dashboard-button_form"><span class="glyphicon glyphicon-plus"></span>Add New Member</button></a>
	<p><?php echo $this->session->flashdata('message')?></p>
	<div class="table-responsive">
  	<table class="table table-striped">
    	<thead>
    		<tr>
        	<th>Actions</th>
			<th>Member ID:</th>
			<th>First Name:</th>
			<th>Last Name:</th>
			<th>Phone Number:</th>
			<th>Email:</th>
         </tr>
        </thead>
        <tbody>
		<?php 
			foreach($user as $row){
		?>
       	<tr>
		
         <td>
					 <a href="<?php echo base_url(); ?>member/edit_member/<?php echo $row->member_id;?>" class = "tooltip-test" data-toggle = "tooltip" title = "Edit"> <span class="glyphicon glyphicon-edit"></span></a>
					 <a href="#" class = "tooltip-test" data-toggle = "tooltip" title = "Print"><span class="glyphicon glyphicon-print"></span></a>
					 <a href="<?php echo base_url(); ?>member/delete_member/<?php echo $row->member_id;?>" class = "tooltip-test" data-toggle = "tooltip" title = "Delete"><span class="glyphicon glyphicon-remove-circle"></span></a>
         </td>
         <td><?php echo $row->member_id; ?></td>
         <td><?php echo $row->first_name; ?></td>
		 <td><?php echo $row->last_name; ?></td>
		 <td><?php echo $row->phone_number; ?></td>
		 <td><?php echo $row->email; ?></td>
         </tr> 
		<?php
			}
		 ?>		 
        </tbody>
       </table>
      </div>
      <div align="center">
        <nav>
			  <ul class="pagination">
			    <li>
			      <a href="#" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <li><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li>
			      <a href="#" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			  </ul>
			  </nav>
      </div>
</div>
      