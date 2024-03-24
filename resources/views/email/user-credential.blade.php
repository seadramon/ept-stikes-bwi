<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account Notification</title>
	
	<style type="text/css" media="screen">
@media screen {
	@import {  }

	* {
		font-family: 'Source Sans Pro', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
	}

	.w280 {
		width: 280px !important;
	}
}
</style>
	<style type="text/css" media="only screen and (max-width: 480px)">
@media only screen and (max-width: 480px) {
	table[class*="w320"] {
		width: 320px !important;
	}

	td[class*="w320"] {
		width: 280px !important;
		padding-left: 20px !important;
		padding-right: 20px !important;
	}

	img[class*="w320"] {
		width: 250px !important;
		height: 67px !important;
	}

	td[class*="mobile-spacing"] {
		padding-top: 10px !important;
		padding-bottom: 10px !important;
	}

	*[class*="mobile-hide"] {
		display: none !important;
	}

	*[class*="mobile-br"] {
		font-size: 12px !important;
	}

	td[class*="mobile-w20"] {
		width: 20px !important;
	}

	img[class*="mobile-w20"] {
		width: 20px !important;
	}

	td[class*="mobile-center"] {
		text-align: center !important;
	}

	table[class*="w100p"] {
		width: 100% !important;
	}

	td[class*="activate-now"] {
		padding-right: 0 !important;
		padding-top: 20px !important;
	}
}
</style>
</head>
<body offset="0" class="body" style="-webkit-font-smoothing: antialiased; width: 100%; height: 100%; color: #6f6f6f; font-weight: 400; font-size: 18px; padding: 0; margin: 0; display: block; background: #eeebeb; -webkit-text-size-adjust: none;" bgcolor="#eeebeb">
<!-- preheader text -->
<div style="font-size:0px;line-height:1px;mso-line-height-rule:exactly;display:none;max-width:0px;max-height:0px;opacity:0;overflow:hidden;mso-hide:all;">
	<!-- Add 85-100 Characters of Preheader Text Here -->
	Hello, Ini adalah informasi credential akun Anda
</div>  
	
	<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" style="border-collapse: collapse;">
		<tr>
			<td align="center" valign="top" style="font-family: Arial, sans-serif; border-collapse: collapse; background-color: #eeebeb;" width="100%" bgcolor="#eeebeb">
				<center>
					<table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-collapse: collapse;">
						<tr>
							<td align="center" valign="top" style="font-family: Arial, sans-serif; border-collapse: collapse;">

							<table style="margin: 0 auto; border-collapse: collapse;" cellspacing="0" cellpadding="0" width="100%">
								<tr>
									<td style="font-family: Arial, sans-serif; border-collapse: collapse; text-align: left; padding: 10px 0;" align="left">
										<img height="50" src="https://stikesbanyuwangi.ac.id/wp-content/uploads/2019/01/logo_stikes.png" alt="STIKES-BWI" style="max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;">
									</td>
								</tr>
							</table>

							<table cellspacing="0" cellpadding="0" width="100%" style="background-color: #23325D; border-collapse: collapse;" bgcolor="#23325D">
								<tr>
									<td style="font-family: Arial, sans-serif; border-collapse: collapse; background-color: #23325D;" bgcolor="#23325D">

										<table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse;">
											<tr>
												<td style="font-family: Arial, sans-serif; border-collapse: collapse; font-size: 40px; font-weight: 200; color: #ffffff; text-align: center; height: 10px;" class="mobile-spacing" height="10" align="center">
												
											</td></tr>
										</table>

									<table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse;">
										<tr>
											<td style="font-family: Arial, sans-serif; border-collapse: collapse;">
												<img src="https://stikesbanyuwangi.ac.id/wp-content/uploads/2021/08/STIKES-Banyuwangi-Solusi-Masa-Depan-Yang-Cemerlang.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; max-width: 100%; display: block;">
											</td>
										</tr>
									</table>

							</td>
						</tr>
					</table>

					<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" style="border-collapse: collapse;">
						<tr>
							<td style="font-family: Arial, sans-serif; border-collapse: collapse; background-color: #ffffff;" bgcolor="#ffffff">

								<table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse;">
									<tr>
										<td style="font-family: Arial, sans-serif; border-collapse: collapse; padding: 0 75px; text-align: left;" class="mobile-center body-padding w320" align="left">

											<div class="mobile-br">&nbsp;</div>
											
											Hello, {!! $name !!}
											<p>
												Akun EPT Anda telah berhasil dibuat. Anda dapat melakukan login dengan credential berikut : 
											</p>

											<b>Account Information</b>
											<hr style="border: 0; border-top: 1px solid #e7e7e7;">
											<table>
												<tr>
													<td>Username</td>
													<td>:</td>
													<td>{!! $recipient !!}</td>
												</tr>
												<tr>
													<td>Password</td>
													<td>:</td>
													<td>{!! $password !!}</td>
												</tr>
											</table>

											<div align="center" style="margin-top: 50px;">

												<table border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="text-btn-large" bgcolor="#23325D" style="background: #23325D; color:#ffffff; font-family:'Poppins', Arial,sans-serif; font-size:14px; line-height:18px; text-align:center; border:0px solid #e5e5e5; padding:15px 35px;">
														<a href="https://ept.stikesbanyuwangi.ac.id/login" target="_blank" class="link-2" style="color:#ffffff; text-decoration:none;"><span class="link-2" style="color:#ffffff; text-decoration:none;">Login</span></a>
														</td>
													</tr>
												</table>

											</div>
										</td>
									</tr>
									<tr>
										<td style="font-family: Arial, sans-serif; border-collapse: collapse; padding: 50px 75px 0 75px; text-align: right;" class="mobile-center body-padding w320" align="right">
											&nbsp;
										</td>
									</tr>
								</table>

								<div class="mobile-br">&nbsp;</div>

								<table cellspacing="0" cellpadding="0" bgcolor="#e7e7e7" class="force-full-width" style="border-collapse: collapse; width: 100%;" width="100%">
									
									<tr>
										<td style="font-family: Arial, sans-serif; border-collapse: collapse; color: #363636; font-size: 14px; text-align: center;padding-top: 10px; padding-bottom: 4px;" align="center">
											&copy; 2023 Stikes Banyuwangi All Rights Reserved
										</td>
									</tr>
									<tr>
										<td style="font-family: Arial, sans-serif; border-collapse: collapse; padding: 0 75px; color: #363636; text-align: center; font-size: 14px; line-height: 22px;" class="mobile-center body-padding w320" align="center">
											Jl. Letkol Istiqlah No 109, Banyuwangi – Jawa Timur, Indonesia – 68400
										</td>
									</tr>
									<tr>
										<td class="mobile-center body-padding w320" style="font-size: 12px; font-family: Arial, sans-serif; border-collapse: collapse; padding: 10px 75px 0 75px; text-align: center;">
											If you no longer wish to receive these emails, click on the following links: <a href="#" style="color: #27aa90; text-decoration: none;">Unsubscribe</a>
										</td>
									</tr>
									<tr>
										<td style="font-family: Arial, sans-serif; border-collapse: collapse; font-size: 12px;">
											&nbsp;
										</td>
									</tr>
								</table>

						</td>
					</tr>
				</table>

				</td>
			</tr>
		</table>
		</center>
		</td>
	</tr>
</table>
</body></html>