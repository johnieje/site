    
<div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Member Deposit Form </h1>
	<p> Please enter deposit details in the form below.</p>
 		<div class="row col-sm-6">
			<div class="dashboard-form">
				<p><?php echo $this->session->flashdata('message')?></p>
				<?php
				echo form_open_multipart('member/deposit_validation');
				
				echo validation_errors('<div class="alert alert-danger">', '</div>');
				
				echo '<p>';
				echo form_label('Amount Deposited');
				$deposit = array(
					'class' => "form-control",
					'placeholder' => "Amount deposited (e.g. 50000)",
					'required' => '',
					'value' => $this->input->post('deposit_amount'),
				);
				echo form_input('deposit_amount','',$deposit);
				echo '</p>';
					
				echo '<p>';
				echo form_label('Deposit Breakdown');
				echo '<div class="form-inline">';
				$savings = array(
					'class' => "form-control",
					'placeholder' => "Savings",
					'value' => $this->input->post('deposit_savings'),
				);
				echo form_input('deposit_savings','',$savings);
				$shares= array(
					'class' => "form-control",
					'placeholder' => "Shares",
					'value' => $this->input->post('deposit_shares'),
				);	
				echo form_input('deposit_shares','',$shares);
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
				echo form_dropdown('pay_mode',$pay_mode,'cash','class="form-control"');
				echo '</p>';
				
				echo '<p>';
				echo form_label('Date of Deposit');
				$date = array(
					'type' => 'text',
					'id' => 'validate_dd_id',
					'name' => 'date',
					'class' => "form-control",
					'placeholder' => "dd/mm/yyyy (e.g. 12/12/2016)",
					'required' => ''
				);
				echo form_input($date);
				echo '</p>';
				
				echo '<p>';
				echo form_label('Reciept upload (Optional)');
				$upload = array(
					'class' => "none",
					'name' => 'receipt_upload'
				);
				echo form_upload($upload);
				echo '</p>';
				
				echo '<p>';
				$textarea = array(
					'name' => 'comment',
					'class' => "form-control",
					'placeholder'         => 'Comment (optional)',
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
      