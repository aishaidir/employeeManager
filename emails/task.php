<?php

$date = $this->dateTime;
$dateSent = date("l, M d, Y", strtotime($date)) . " at ". date("h:i:s A", strtotime($date));
$emailBody = '<!DOCTYPE html>
				<html>
				<head>
				</head>

				<body style="background:#f9f9f9;">

				<link href="https://fonts.googleapis.com/css?family=Karla:400,700" rel="stylesheet">
				<div style="background: #f9f9f9;font-family:"Karla", sans-serif;font-size:15px;padding: 1em;">

					<div style="width: 100%;max-width:650px;margin: 0 auto;">
						<div style="width: 195px;height: auto;position: relative;margin: 0 auto 10px;">
							<a style="color: #333;" href="">
								<img style="width: 100%;height: 100%;object-fit: contain;" src="http://69.64.87.150:9090/stm_v1.0/imgs/logo.png">
							</a>
						</div>
					</div>
					
					<div style="width: 100%;max-width:650px;margin: 0 auto;background: #fff;border-top: 3px solid #03a9f4;border-radius: 4px;">
						<h3 style="margin:0;padding-top: 20px;color:#666666;font-size: 12px;text-transform: uppercase;text-align: center;">Task Manager</h3>
						<table border="0" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:4px;width: 100%;">

							<tr>
							<td style="padding:60px 20px;">
							<p style="font-size:18px;padding-bottom: 20px;">Hi '. $firstName .',</p>
							<p style="padding-bottom: 20px;"><strong>'. $authorName .'</strong> has assigned a task to you. </p>
							<a href="'. $taskURL .'" style="color: #03a9f4;font-size: 15px;padding-bottom: 40px;display: block;">Click here to view</a>
							<p style="color: #9d9da3;">Sent on '. $dateSent .'</p>
							</td>
							</tr>

						</table>
					</div>

				</div>

				</body></html>';