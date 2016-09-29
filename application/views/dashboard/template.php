<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "SACCO MASTER";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
ob_start();
    // we can have any view part here like HTML, PHP etc
	
	echo '<h4>';
	echo "Deposit Summary:";
	echo '</h4>';
	
	echo '<p>';
	echo "Member ID: ".$member_id;
	echo '</p>';
	
	echo '<p>';
	echo "Reference ID: ".$record['reference_id'];
	echo '</p>';
	
	echo '<p>';
	echo "Date of Deposit: ".$record['deposit_date'];
	echo '</p>';
	
	echo '<p>';
	echo "Savings: ".number_format($record['savings']);
	echo '</p>';
	
	echo '<p>';
	echo "Shares: ".number_format($record['shares']);
	echo '</p>';
	
	echo '<p>';
	echo "Amount deposited: ".number_format($record['amount']);
	echo '</p>';
	
	echo '<p>';
	echo "Currency: ".$record['currency_id'];
	echo '</p>';
	
	echo '<p>';
	echo "Payment Mode: ".$record['payment_mode_id'];
	echo '</p>';
	
	echo '<p>';
		if($record['verified'] == true){
			$status = "Verified";
		}else{
			$status = "Pending";
		}
	echo "Verification Status: ".$status;
	echo '</p>';
	
	echo '<p>';
	echo "Receipt name: ".$record['receipt_upload'];
	echo '</p>';
	
    $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('printout.pdf', 'I');