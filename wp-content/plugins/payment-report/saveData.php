<?php
   require_once('../../../wp-load.php');
   $name = $_POST['name'];
   $email = $_POST['email'];
   $orderid = $_POST['orderid'];
   $amount = $_POST['amount'];
   $bank = $_POST['bank'];
   $date = $_POST['date'];
   $tel = $_POST['tel'];
   $file = $_FILES["file"]["name"];
   $note = $_POST['note'];
   
   if(!empty($file)){
        $filename = $orderid."_".$file;
        $temp = explode(".", $_FILES["file"]["tmp_name"]);
        $upload_dir = wp_upload_dir();
        $url_upload = $upload_dir['basedir'].'/payment';
        move_uploaded_file($_FILES["file"]["tmp_name"],$url_upload."/".$orderid."_".$_FILES["file"]["name"]);
   }else{
   	    $filename = 'no';
   }

   global $wpdb;
   $wpdb->insert('wp_payment', array(
	    'customer_name' => $name,
	    'customer_email' => $email,
	    'order_id' => $orderid,
	    'amount' => $amount,
	    'date' => $date,
	    'bank' => $bank,
	    'tel' => $tel,
	    'slip' => $filename,
	    'note' => $note,
	));

$body =  '<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

		<!-- CENTER THE EMAIL // -->
		<!--
		1.  The center tag should normally put all the
			content in the middle of the email page.
			I added "table-layout: fixed;" style to force
			yahoomail which by default put the content left.

		2.  For hotmail and yahoomail, the contents of
			the email starts from this center, so we try to
			apply necessary styling e.g. background-color.
		-->
		<center style="background-color:#E1E1E1;">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
				<tr>
					<td align="center" valign="top" id="bodyCell">
						<table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader">

							<tr>
								<td align="center" valign="top">
									<!-- CENTERING TABLE // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<!-- FLEXIBLE CONTAINER // -->
												<table border="0" cellpadding="10" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td valign="top" width="500" class="flexibleContainerCell">

															<!-- CONTENT TABLE // -->
							
														</td>
													</tr>
												</table>
												<!-- // FLEXIBLE CONTAINER -->
											</td>
										</tr>
									</table>
									<!-- // CENTERING TABLE -->
								</td>
							</tr>
							<!-- // END -->

						</table>
						<!-- // END -->

						<!-- EMAIL BODY // -->
					
						<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

							<!-- MODULE ROW // -->
							<!--
								To move or duplicate any of the design patterns
								in this email, simply move or copy the entire
								MODULE ROW section for each content block.
							-->
							<tr>
								<td align="center" valign="top">
									<!-- CENTERING TABLE // -->
									<!--
										The centering table keeps the content
										tables centered in the emailBody table,
										in case its width is set to 100%.
									-->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#00AE4D">
										<tr>
											<td align="center" valign="top">
												<!-- FLEXIBLE CONTAINER // -->
												<!--
													The flexible container has a set width
													that gets overridden by the media query.
													Most content tables within can then be
													given 100% widths.
												-->
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">

															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td align="center" valign="top" class="textContent">
																		<h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;">แจ้งชำระเงินจากลูกค้า</h1>
																	</td>
																</tr>
															</table>
															<!-- // CONTENT TABLE -->

														</td>
													</tr>
												</table>
												<!-- // FLEXIBLE CONTAINER -->
											</td>
										</tr>
									</table>
									<!-- // CENTERING TABLE -->
								</td>
							</tr>
		
							<tr mc:hideable>
								<td align="center" valign="top">
									<!-- CENTERING TABLE // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<!-- FLEXIBLE CONTAINER // -->
												<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td valign="top" width="500" class="flexibleContainerCell">
 
															<!-- CONTENT TABLE // -->
															<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
																<tr>
																	<td width="100"><b>ชื่อ-สกุล</b></td>
																	<td>'.$name.'</td>
																</tr>
																<tr>
																	<td><b>อีเมล์</b></td>
																	<td>'.$email.'</td>
																</tr>
																<tr>
																	<td><b>เลขที่สั่งซื้อ</b></td>
																	<td>'.$orderid.'</td>
																</tr>
																<tr>
																	<td><b>จำนวนเงิน</b></td>
																	<td>'.$amount.' บาท</td>
																</tr>
																<tr>
																	<td><b>วันที่</b></td>
																	<td>'.$date.'</td>
																</tr>
																<tr>
																	<td><b>ธนาคาร</b></td>
																	<td>'.$bank.'</td>
																</tr>
																<tr>
																	<td><b>สลิบ</b></td>
																	<td><a href="'.get_site_url()."/wp-content/uploads/payment/".$orderid.'_'.$_FILES["file"]["name"].'" target="blank_">ดูสลิป</a></td>
																</tr>

																
															</table>
															<!-- // CONTENT TABLE -->

														</td>
													</tr>
												</table>
												<!-- // FLEXIBLE CONTAINER -->
											</td>
										</tr>
									</table>
									<!-- // CENTERING TABLE -->
								</td>
							</tr>
						</table>
						<!-- // END -->
					</td>
				</tr>
			</table>
		</center>
	</body>';

//include phpmailer
require_once('class.phpmailer.php');

$user_smtp = get_custom('user_smtp');
$password_smtp = get_custom('password_smtp');
$name_sentder = get_custom('name_sentder');
$email_sentder = get_custom('email_sentder');
$email_admin = get_custom('email_admin');
$smtp_host = get_custom('smtp_host');
$smtp_status = get_custom('smtp_status');
$smtpport = get_custom('smtpport');
$smtpsecure = get_custom('smtpsecure');
$email_subject = get_custom('email_subject');

//SMTP Settings
$mail = new PHPMailer();
if($smtp_status == 1){
    $mail->IsSMTP();
    $mail->SMTPAuth   = true; 
    $mail->SMTPSecure = $smtpsecure; 
    $mail->Host       = $smtp_host;
    $mail->Port = $smtpport;  
    $mail->Username   = $user_smtp;
    $mail->Password   = $password_smtp;
}

$mail->CharSet = "UTF-8";
$mail->isHTML(true);
$mail->SetFrom($email_sentder, $name_sentder); //from (verified email address)
$mail->Subject = $email_subject; //subject
$mail->AddAddress($email_admin, $name); 

$body = eregi_replace("[\]",'',$body);
$mail->MsgHTML($body);
$mail->Send();

?>