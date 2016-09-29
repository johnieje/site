
      	<!-- Side Menu Container -->
        <div class="col-sm-3 col-md-2 sidebar">
        	<ul class="nav nav-sidebar">
		  			<li><a href="<?php echo base_url(); ?>member/dashboard"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Make Deposit <span class="sr-only">(current)</span></a></li>
						<li><a href="<?php echo base_url(); ?>member/deposits"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> View Deposits</a></li>
						<li><a href="<?php echo base_url(); ?>member/dashboard"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Help</a></li>
						
						<?php if($user_type == 'admin'){?>
						
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url(); ?>member/member_list"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Members</a></li>
            <li><a href="<?php echo base_url(); ?>member/dashboard"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a></li>
						
						<?php } ?>
						
          </ul>
        </div>