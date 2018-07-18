<?php 
	//$this->erp->print_arrays($inv->customer);
?>
<!Doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?= $inv->reference_no ?></title>
</head>
	<body>
	<style type="text/css">
	body {
			height: auto;
			width: 739px;
			/* to centre page on screen*/
			margin-left: auto;
			margin-right: auto;
		}
		#topleft{
			width: 40%;
			float:left;
			margin-top:5px;
			
		}
		#topleft p {
			line-height: 0.5;
		}
		#topright{
			width:25%;
			float:left;
			margin-top:65px;
			font-weight:bold !important;
		}
		#topcenter{
			width:34%;
			float:left;
			text-align:center;
			font-family:khmer OS Muol;
			font-size:20px;
		}
		#title{
			margin-left:100px;
		}
		#top2left{
			clear:both;
			float:left;
		}
		#top2left p {
			line-height: 0.5;
		}
		#top2right{
			float:right;
		}
		.tbStyle{
			width:739px;
			font-size:14px;
		}
		table{
			border-collapse: collapse;
		}
		table, th, td {
			border: 1px solid black;
		}
		#fleft{
			float:left;
			margin-left:30px;
			font-size:14px;
		}
		#fright{
			float:right;
			margin-right:50px;
			font-size:14px;
		}
		@media print {
			.print_d {
				display: none !important;
			}
		}
	</style>
		
		<div style="width:100%;">
			<span id="topright" style="font-weight:bold !important;">
				ការិយាល័យកណ្តាល
			</span>
			<span id="topcenter">
				<b>លិខិតកម៉្មង់ទំនិញ</b>
			</span>
			<span id="topleft">
				<p style="line-height:20px;"><b>ឈ្មោះអតិថិជន:&nbsp;<span><?php echo $inv->customer ?></span></b></p>
				<p>Address:&nbsp; <?= $inv->address; ?></p>
				<p>Tel:&nbsp; <?= $inv->customer_phone; ?></p>
				
			</span>
		</div>
		<div id="top2left">
			<p>ដឹកទៅកាន់: <span style="font-weight:bold;"><strong><?php echo $inv->bill_to ?></strong></span></p>
			<p><?= $this->erp->decode_html(strip_tags($inv->note)); ?></p>
		</div>
		<div id="top2right">
			លេខយោង:  <span><?php echo $inv->reference_no ?></span> <br>  ថ្ងៃខែឆ្នាំ:  <span><?php echo $this->erp->hrsd($inv->date) ?></span>
		</div>
		<table class="tbStyle">
			<thead>
				<th>ល.រ</th>
				<th>លេខកូដ</th>
				<th>រាយមុខទំនិញ</th>
				<th>ចំនួន</th>
				<th>ឯកតា</th>
				<th>ផ្សេងៗ</th>
			</thead>
			<tbody align="center">
			<?php 
				$row_number = 1;
				$empty_row = 1;
			?>
			<?php 
			$str_unit = "";
			foreach ($rows as $row):
				if($row->option_id){
					$var = $this->sales_model->getVar($row->option_id);
					$str_unit = $var->name;
				}else{
					$str_unit = $row->product_unit;
				}
			?>
			<tr>
				<td class="text-center"><?= $row_number ?></td>
				<td><?= $row->product_code ?></td>
				<td style="text-align: left"><?= $row->product_name?></td>
				<td><?= $this->erp->formatQuantity($row->quantity); ?></td>
				<td class="text-center"><?= $str_unit ?></td>
				<td style="text-align: left;"><?= $row->product_noted ?></td>
			</tr>
			<?php
				$row_number++;
				$empty_row++;
			?>
			<?php endforeach ?>
			<?php
				if ($empty_row < 16) {
					$k=16 - $empty_row;
					for ($j = 1; $j <= $k; $j++) {
						echo  '<tr>
							<td class="text-center" height="34px">'.$row_number.'</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>';
						$row_number++;
					}
				}
			?>
			</tbody>
		</table>
		<div style="font-size:12px">
			មិនសម្រាប់ប្រើប្រាស់ជាវិក័យប័ត្រអតិថិជនឡើយ
		</div>
		<div id="fleft" style="width: 150px">
			<center>
				<strong>ស្នើរដោយ:</strong><br><br><br><br><br><br>
				<hr>
			</center>
		</div>
		<div id="fright" style="width: 150px">
			<center>
				<strong>បញ្ចេញដោយ:</strong><br><br><br><br><br><br>
				<hr>
			</center>
		</div>
		<div class="print_d" style="clear:both;">
			<button onclick="print_document()">Print</button>
		</div>
	</body>
	<script type="text/javascript" src="<?= $assets ?>js/jquery.js"></script>
	<script>
		function print_document() {
			$('.print_d').hide();
			window.print();
		}
	</script>
</html>




















