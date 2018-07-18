
<?php
	
?>
<!DOCTYPE html>
<html>
<head>
<link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet"/>
<style type="text/css">
	tbody{
		font-family:khmer Os;
		font-family:Times New Roman !important;
	}
	.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th {
			background-color: #444 !important;
			color: #FFF !important;
		}
	.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
		border: 1px solid #000 !important;
	}
	
	@media print {
		body {
                width: 100%;
                font-size: 17px !important;
            }

            .container-fluid {
                width: 99% !important;
                margin: 0 auto !important;
                padding: 0 !important;
                font-size: 17px !important;
            }

            .container {
                width: 45% !important;
                float: left !important;
				margin-left: 33px !important;
                padding: 2px !important;
                font-size: 17px !important;
            }
            .padding10 {
                font-size: 17px !important;
            }
	}
	.container {
		margin:10px auto;
		padding:30px;	
	}

</style>
</head>

<body>		
<div class="container-fluid print_rec" id="wrap" style="margin-top:0 auto;">
<?php for ($i = 1; $i <= 2; $i++) {  ?>
	<div class="container" style="width: 50%; float: left">
		<div class="row">
		<div class="col-lg-12" >
		<?php if ($logo) { ?>
				<div class="col-xs-4 text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="" width="170px">
                </div>
                <div class="col-xs-7 text-center">
                    <?php if($biller->company_kh){ ?>
                        <h4><strong><?= $biller->company_kh ?></strong></h4>
                    <?php } ?>
                    <h4><strong><?= $biller->company ?></strong></h4>
                    <?php 
                        if($biller->address){echo $biller->address;}
						echo '<br>';
                        if($biller->phone){echo lang("tel") . " : ".$biller->phone;}
                        if($biller->email){echo "&nbsp &nbsp".lang("email")." : ". $biller->email;}
                    ?> 
					 <h4><?= lang("deliver_Invoice")?></h4>
                </div>
                <div class="col-xs-3">
                   
                </div>
            <?php } ?>
		</div>
		</div>
		<div class="row" style="border: 1px solid black; border-radius: 15px;">
			<div class="col-lg-12" >
				<div class="col-xs-6" style="padding: 10px;">
					<table>
						<tr>
							<td><?=lang('លក់ជូន​​​​​​ <br/> sold_to')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?= $customer->name ? $customer->name : $customer->company; ?></td>
						</tr>
						<tr>
							<td><?=lang('អស័យដ្ឋាន​ </br> Address')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?= $customer->address;?></td>
						</tr>
						<tr>
							<td><?=lang('ទំនាក់ទំនង </br> Contact')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?= $customer->phone; ?></td>
						</tr>
					</table>
				</div>
				<div class="col-xs-6" style="padding: 10px;">
					<table>
						<tr>
							<td><?=lang('លេខវិក័យប័ត្រ </br> DO No')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?=$inv->do_reference_no; ?></td>
						</tr>
						
						<tr>
							<td><?=lang('ផ្នែកលក់ </br> Showroom Sales')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?= $inv->saleman?></td>
						</tr>
						<tr>
							<td><?=lang('ថ្ងៃខែ </br> Date')?></td>
							<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
							<td><?= $this->erp->hrld($inv->date);?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		</br>
		<div class="row">
			<div class="table-responsive">
				<table class="table "  border="1">
					<thead>
						<tr>
							<th class="text-center"><?=lang('ល.រ </br> Nº')?></th>
							<th class="text-center"><?=lang('លេខកូដទំនិញ </br> Article No')?></th>
							<th class="text-center"><?=lang('ឈ្មោះទំនិញ </br> Description')?></th>
							<th class="text-center"><?=lang('ឯកតា </br> Unit')?></th>
							<th class="text-center"><?=lang('ចំនួន </br> Quanity')?></th>
							<th class="text-center"><?=lang('ម៉េត្រការ៉េ/កេស </br> Measurement')?></th>	
						</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;$r=1;
					 if(is_array($rows)){
						$total = 0;
						foreach ($rows as $row):
						$free = lang('free');
						$product_unit = '';
						
						//$this->erp->print_arrays($row);
						if($row->variant){
							$product_unit = $row->variant;
						}else{
							$product_unit = $row->uname;
						}
						$product_name_setting;
						if($Settings->show_code == 0) {
							$product_name_setting = $row->product_name ;
						}else {
							if($Settings->separate_code == 0) {
								$product_name_setting = $row->product_name . " (" . $row->product_code . ")";
							}else {
								$product_name_setting = $row->product_name;
							}
						}

						if($row->option_id){
                           $getvar = $this->sales_model->getAllProductVarain($row->product_id);
								 foreach($getvar as $varian){
									 if($varian->product_id){
										 if($varian->qty_unit == 0){
											$var = $this->sales_model->getVarain($row->option_id);
											$str_unit = $var->name;
										 }else{
											$var = $this->sales_model->getMaxqtyByProID($row->product_id);
											$var1 = $this->sales_model->getVarain($var->product_id);									
											$str_unit = $var1->name;
										}
									 }else{
										$str_unit = $row->uname;
									}
								}
                        }else{
                            $str_unit = $row->uname;
						}
					?>
					
						<tr>
							<td style=" text-align:center; vertical-align:middle;"><?=$no ;?></td>
							<td style="text-align:left; vertical-align:middle;"><?=$row->code?></td>
							<td style="text-align:left; vertical-align:middle;">
									<?=$row->product_name ?>
							</td>
							<td style="text-align:center; vertical-align:middle;">
								<?php
									if($row->piece != 0){ 
										echo  $str_unit;
										//$this->erp->print_arrays($str_unit);
									}else{ 
										echo $row->unit;
									}
								?>
								
							</td>
							<td style=" text-align:center; vertical-align:middle;">
								<?php 
									if($row->piece != 0){ 
										echo $row->piece; 
										//$this->erp->print_arrays($inv_item);
									}else{ 
										echo $this->erp->formatQuantity($row->quantity_received);}
								?>
							</td>
							<td style=" text-align:center; vertical-align:middle;">
								<?php
									if($row->piece!=0){
										echo $row ->wpiece;
									}
								?>
							</td>
						</tr>
						<?php
							$no++;$r++;
							endforeach;
						}
						 
						?>
						<?php
							if($r<5){
								$k=5 - $r;
								for($j=1;$j<=$k;$j++){
									echo  '<tr>
											<td height="34px" class="text-center">'.$no.'</td>
											<td style="width:34px;"></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											
										</tr>';
									$no++;
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		</br>
		</br>
		
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12" id="footer">
				<div class="col-lg-3 col-sm-3 col-xs-3 text-center">
					<hr style="border:dotted 1px; width:90px; vertical-align:bottom !important; " />
					<b style="text-align:center;margin-left:3px; font-size:12px !important;"><?= lang('​ អ្នកទទួល '); ?></b>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-3 text-center">
				<hr style="border:dotted 1px; width:90px; vertical-align:bottom !important; " />
					<b style="text-align:center;margin-left:3px;font-size:12px !important;;"><?= lang('​​អ្នកដឹក'); ?></b>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-3 text-center">
				<hr style="border:dotted 1px; width:90px; vertical-align:bottom !important; " />
					<b style="text-align:center;margin-left:3px;font-size:12px !important;"><?= lang('​អ្នកលក់'); ?></b>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-3 text-center">
				<hr style="border:dotted 1px; width:90px; vertical-align:bottom !important; " />
					<b style="text-align:center;margin-left:3px;font-size:12px !important;"><?= lang('ប្រធានឃ្លាំង'); ?></b>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
	
</div>
<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>
</body>
</html>