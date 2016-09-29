    
<div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Edit Record (REFERENCE ID: <?php echo $record['reference_id']; ?>). </h1>
	<p> Please enter deposit details in the form below.</p>
 		<div class="row col-sm-6">
			<div class="dashboard-form">
				<p><?php echo $this->session->flashdata('message')?></p>
				<?php
				echo form_open_multipart('member/edit_deposit_validation');
				
				echo validation_errors('<div class="alert alert-danger">', '</div>');
				// Hidden form fields
				echo form_hidden('id',set_value('id',$record['id']));
				echo form_hidden('reference_id',set_value('reference_id',$record['reference_id']));
				echo form_hidden('verified',set_value('verified',$record['verified']));
				echo form_hidden('user_id',set_value('user_id',$record['user_id']));
				
				echo '<p>';
				echo form_label('Amount Deposited');
				$deposit = array(
					'name' => 'deposit_amount',
					'class' => "form-control",
					'required' => '',
					'placeholder' => "Amount deposited (e.g. 50000)",
					'value' => $record['amount'],
				);
				echo form_input($deposit);
				echo '</p>';
					
				echo '<p>';
				echo form_label('Deposit Breakdown');
				echo '<div class="form-inline">';
				$savings = array(
					'name' => 'deposit_savings',
					'class' => "form-control",
					'placeholder' => "Savings",
					'value' => $record['savings'],
				);
				echo form_input($savings);
				$shares= array(
					'name' => 'deposit_shares',
					'class' => "form-control",
					'placeholder' => "Shares",
					'value' => $record['shares'],
				);	
				echo form_input($shares);
				echo '</div></p>';
				
				echo '<p>';
				echo form_label('Currency');
				$currency = array(
					'UGX'         => 'Uganda Shilling',
					'USD'           => 'US Dollar',
				);		
				echo form_dropdown('currency',$currency,'UGX','class="form-control"');
				echo '</p>';
				
				echo '<p>';
				echo form_label('Payment Mode');
				$pay_mode = array(
					'cash' => 'Cash',
					'cheque'         => 'Cheque',
					'eft' => "Wire Transfer"
				);
				echo form_dropdown('pay_mode',$pay_mode,'selected','class="form-control"');
				echo '</p>';
				
				echo '<p>';
				echo form_label('Date of Deposit');
				$date = array(
					'type' => 'text',
					'id' => 'validate_dd_id',
					'name' => 'date',
					'class' => "form-control",
					'placeholder' => "dd/mm/yyyy (e.g. 12/12/2016)",
					'value' => $record['deposit_date'],
					'required' => ''
				);
				echo form_input($date);
				echo '</p>';
				
				echo '<p>';
				echo form_label('Reciept upload (Optional)');
				$upload = array(
					'class' => "none",
					'name' => 'receipt_upload',
					'value' => set_value($record['receipt_upload']),
				);
				echo form_upload($upload);
				echo '</p>';
				
				echo '<p>';
				$textarea = array(
					'name' => 'comment',
					'class' => "form-control",
					'placeholder'         => 'Comment (optional)',
					'value' => $record['comment'],
				);
				echo form_textarea($textarea);
				echo '</p>';
				
				echo '<p>';
				$submit = array(
					'style' => "background: #4CAF50",
					'class' => "dashboard-button_form",
				);
				echo form_submit('submit','Submit Transaction', $submit);
				echo '</p>';

				echo form_close();
				?>
			</div>
 		</div>
</div>
      