    
<div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Add New Member </h1>
	<p> Please enter member details in the form below.</p>
 		<div class="row col-sm-6">
			<div class="dashboard-form">
				<p><?php echo $this->session->flashdata('message')?></p>
				<?php
				echo form_open_multipart('member/add_member_validation');
				
				echo validation_errors('<div class="alert alert-danger">', '</div>');
				
				echo '<p>';
				echo form_label('Member ID');
				$member_id = array(
					'name' => 'member_id',
					'class' => "form-control",
					'required' => '',
					'value' => $new_id,
					'disabled' => ''
				);
				echo form_input($member_id);
				echo '</p>';
				
				echo '<p>';
				echo form_label('First Name');
				$first_name = array(
					'name' => 'first_name',
					'class' => "form-control",
					'placeholder' => "First Name (e.g. John)",
					'required' => ''
				);
				echo form_input($first_name);
				echo '</p>';
				
				echo '<p>';
				echo form_label('Last Name');
				$last_name = array(
					'name' => 'last_name',
					'class' => "form-control",
					'placeholder' => "Last Name (e.g. Doe)",
					'required' => '',
				);
				echo form_input($last_name);
				echo '</p>';
				
				echo '<p>';
				echo form_label('Phone Number');
				$member_phone = array(
					'name' => 'phone_number',
					'class' => "form-control",
					'placeholder' => "0700xxxxxx",
				);
				echo form_input($member_phone);
				echo '</p>';
				
				echo '<p>';
				echo form_label('Email Address');
				$member_email = array(
					'name' => 'email',
					'class' => "form-control",
					'placeholder' => "johndoe@email.com",
				);
				echo form_input($member_email);
				echo '</p>';
				
				echo '<p>';
				$submit = array(
					'style' => "background: #4CAF50",
					'class' => "dashboard-button_form",
				);
				echo form_submit('submit','Add Member', $submit);
				echo '</p>';

				echo form_close();
				?>
			</div>
 		</div>
</div>
      