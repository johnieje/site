    
<div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">
	Deposits : TOTAL = <?php echo number_format($deposit_amount); ?></h1>
	
	<h3>
	SAVINGS = <?php echo number_format($deposit_savings); ?>
	:
	SHARES = <?php echo number_format($deposit_shares); ?>
	</h3>
	<a href="<?php echo base_url(); ?>member/dashboard"><button class="btn btn-lg dashboard-button_form">New Deposit</button></a>
	
	<p>See below for a summary of your deposits.</p>
	<p><?php echo $this->session->flashdata('message')?></p>
	<div class="table-responsive">
  	<table class="table table-striped">
    	<thead>
    		<tr>
        	<th>Actions</th>
          <th>ReferenceID</th>
          <th>Date of Deposit</th>
          <th>Amount</th>
          <th>Currency</th>
          <th>Payment Mode</th>
          <th>Receipt</th>
					<th>Verification Status</th>
         </tr>
        </thead>
        <tbody>
       	<tr>
					<?php 
					foreach($user_data as $row){
					?>
         <td>

					 <a href="<?php echo base_url(); ?>member/pdf/<?php echo $row->reference_id;?>" class = "tooltip-test" data-toggle = "tooltip" title = "Export"><span class="glyphicon glyphicon-file"></span></a>
					 <?php if($row->verified == false){
						?>
						<a href="<?php echo base_url(); ?>member/edit_deposit/<?php echo $row->reference_id;?>" class = "tooltip-test" data-toggle = "tooltip" title = "Edit"> <span class="glyphicon glyphicon-edit"></span></a>
						<a href="<?php echo base_url(); ?>member/delete_record/<?php echo $row->reference_id;?>" class = "tooltip-test disabled" data-toggle = "tooltip" title = "Delete"><span class="glyphicon glyphicon-remove-circle"></span></a>
						<?php 
					 }else{
					 }?>
					 
         </td>
         <td><?php echo $row->reference_id; ?></td>
         <td><?php echo $row->deposit_date; ?></td>
         <td><?php echo number_format($row->amount); ?></td>
         <td><?php echo $row->currency_id; ?></td>
         <td><?php echo $row->payment_mode_id; ?></td>
         <td>
					 <?php
						if(($row->receipt_upload) == 1){
							echo "Not Available";
						}else{
							echo '<a href="'.base_url().'assets/receipts/'.$row->receipt_upload.'">Uploaded</a>';
						}
					 ?>
					</td>
					<td>
						<?php
							if($row->verified == true){
								$status = "<button type='button' class='btn btn-success'>  Verified!</button>";
							}else{
								$status = "<button type='button' class='btn btn-warning'> Pending!</button>";
							}
						echo $status;
						?>
					</td>
         </tr> 
					<?php 		
					} //close foreach loop
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
      