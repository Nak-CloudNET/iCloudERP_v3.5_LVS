<link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet"/>
<style>
        @media print{
        	.table{
        		padding: 0px !important;
        		margin: 0px auto !important;
        		padding-left: -15px !important;
        		margin-left: -1.5% !important;
        	}
			#box {
				width:100% !important; 
				margin:0px auto !important;

			}
			#pd {
			 	padding-top:5px !important;
			}
			tr td{
				font-size:10px !important;
			}
			p{
				font-size: 10px;
				
			}
			body{
				font-family: Khmer OS;
			}
			#note{
				border-left-color: white !important;
			}
			#logo{
				max-width: 158px !important;
				margin-left: 10% !important;
				margin-top: 15px !important;
			}
		}
        #head-box tr td {
				  font-size:12px !important;
		}
		tbody td{
			font-size:12px;
		}
		body{
			font-family: Khmer OS;
		}
		#logo{
			margin-top: 12px !important;
		}

</style>
<div id ="box" style="max-width:590px;" class="container">
<br>
 	<div class="row">
 		<div class="col-md-12 col-xs-12">
 			<div class="col-md-4 col-xs-4" style="font-size: 11px;">
	 			<table>
	 				<tr>
		 				<p><b><?= lang("អាស័យដ្ឋាន"); ?>:<?php echo $customer->address; ?></b></p>
	 				</tr>
	 			</table>
 			</div>
 			<div class="col-md-4 col-xs-4">
			<?php 
			foreach($rows as $img){
				$image = $img->image; 
				//$this->erp->print_arrays($image);
			}
			
			?>
 				<img style="width:150px;height:80px;" src="<?= base_url() . 'assets/uploads/' . $image; ?>"
                         alt="" id="logo">
 			</div>
 			<div class="col-md-4 col-xs-4" style="font-size: 11px;">
 				<table>
 					<tr>
 						<p style="text-align: right;"><b><?= lang("លេខ"); ?>:</b>&nbsp;&nbsp;&nbsp;<?= $inv->reference_no;?></p>
 					</tr>
 					<tr>
 						<p style="text-align: right;"><b><?= lang("date_kh"); ?>:</b>&nbsp;&nbsp;&nbsp;<?= $date;?></p>
 					</tr>
 					<tr>
 						<p style="text-align: right;"><b><?= lang("customer_kh"); ?>:</b>&nbsp;&nbsp;&nbsp;<?php if($customer->name_kh){ echo $customer->name_kh; }else{ echo $customer->name; } ?></p>
 					</tr>
 				</table>
 			</div>
 		</div>
 	</div>
	<table class="table-responsive" width="48%" border="0" cellspacing="0" style="margin: 0 auto;">
			<div class="col-md-12 col-xs-12">
				<div class="col-md-4 col-xs-4" style="margin-left:-7px">
					<?php if($pos->display_qrcode) {
					     $ref = strtoupper($inv->reference_no);
					    ?>
					        <?php $br = $this->erp->save_barcode($ref); ?>
					        <img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png" alt="<?= $ref ?>" style="width: 158px;"/>
					    <?php } 
					?>
				</div>
				<div class="col-md-2 col-xs-3 tt" style="font-size:15px;text-align: center;margin-left: 30px;margin-top:10px;font-family: Khmer OS Muol Light"><?= lang("វិក្ក័យប័ត្រ"); ?></div>
				<div class="col-md-6 col-xs-5" style="height: 12px;"></div>
			</div>
			<td colspan="5">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead> 
						<tr style="font-size: 11px;">
							<th style="text-align:center;width:5px;"><?= lang("ល.រ"); ?></th>
							<th style="text-align:center;"><?= lang("កូដ"); ?></th>
							<th style="text-align:center;"><?= lang("ឈ្មោះទំនិញ"); ?></th>
							<th style="text-align:center;"><?= lang("ចំនួនកេស"); ?></th>
							<th style="text-align:center;width:5px;"><?= lang("ចំនួនរាយ"); ?></th>
							<th style="text-align:center;width:10px;"><?= lang("តម្លៃឯកតា"); ?></th>
							<th style="text-align:center;"><?= lang("ចំនួនទឹកប្រាក់"); ?></th>
						</tr>
						</thead>
						<tbody>
							<?php $r = 1;
	                        $tax_summary = array();
	                        foreach ($rows as $row):
	                                $str_unit = "";
	                                $grand_total += ($row->quantity)*($row->unit_price);
	                               	// $this->sales_model->getCurrencyByID($row->product_id);
	                                if($row->option_id){
	                                   $getvar = $this->sales_model->getAllProductVarain($row->product_id);
											foreach($getvar as $varian){
												// $var = $this->sales_model->getVarain($varian->product_id);
												$Max_unitqty = $this->sales_model->getMaxqty($varian->product_id);
												$Min_unitqty = $this->sales_model->getMinqty($varian->product_id);
												$maxqty =  $Max_unitqty->maxqty;
												$minqty =  $row->quantity;
												$Max_unit = $this->sales_model->getMaxunit($maxqty,$row->product_id);
												$Min_unit = $this->sales_model->getMinunit($Min_unitqty->minqty,$row->product_id);
												$maxunit = $Max_unit->name;
												$minunit = $Min_unit->name;
												$min_price = $row->unit_price;  
											}

	                                }else{
	                                	$maxqty =  $row->quantity;
										$minqty =  $row->quantity;
										$maxunit = " ";
										$minunit = $row->uname;
										$min_price = $row->unit_price;                                  
									}
								
								// $this->erp->print_arrays($currentcy);
	                            //$this->erp->print_arrays($row);
							  	// $this->sales_model->getcurrentcy($row->product_id);
									
								$this->db->select('currencies.rate,currencies.code')->from('products')
								->join('currencies', 'currencies.code = products.currentcy_code', 'left')
								->where('products.id', $row->product_id);
								$rate_pro = $this->db->get()->row();
	                           $variant = $this->sales_model->getProductVariantByOptionID($row->product_id);
	                           if($rate_pro->code == "USD"){
                            		$total += $minqty * $min_price;
                            	}else{
                            		$total += $minqty * $min_price/$rate_pro->rate;
                            	}
              	 	
	                        ?>
							<tr>
								<td style="text-align:center;vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_code ?>
                                </td>
                                <td style="text-align:right; vertical-align:middle;">
                                	<?= $row->product_name ?>
                                </td>
                                 <td style="text-align:right; vertical-align:middle;">
                                   <?php
                                if($row->option_id){
                                 		if($row->variant == $maxunit){ 
                                			echo $this->erp->formatMoney($minqty)." ".$maxunit;
                                		}else{
                                			echo $this->erp->formatMoney($minqty/$maxqty)." ".$maxunit;
                                		}  
                                	}else{
                                		if($this->erp->formatMoney($minqty/$maxqty) == 1.00){
                                			echo "0";
                                		}
                                	}
                                	?>
                                </td>
                                <td style="text-align:right;">
                                    <?php
                                    if($row->option_id){
                                    	if($row->variant == $minunit){
                                    		echo $this->erp->formatMoney($minqty)." ".$minunit;
                                    	}else{
                                    		echo $this->erp->formatMoney($maxqty*$minqty)." ".$minunit;
                                    	}
                                    }else{
                                    	echo $this->erp->formatMoney($minqty)." ".$minunit;
                                    }  ?>
                                </td>
                                 <td style="text-align:right;">
                                 <?php echo $this->erp->formatMoney($min_price)." ".$row->currentcy_code; ?>
                                </td>
                               	<td style="text-align:right;">
                                    <?php
                                    if($row->option_id){
                                    	if($row->variant == $minunit){
                                    		if($rate_pro->code == "USD"){
                                    			echo $this->erp->formatMoney($minqty*$min_price)." ".$rate_pro->code;
                                    		}else{
                                    			echo $this->erp->formatMoney($minqty*$min_price)." ".$rate_pro->code."</br>"."( ".$this->erp->formatMoney($minqty*$min_price/$rate_pro->rate)." USD )";
                                    		 	$curren = $rate_pro->code;
                                    		 	$curren_rate = $rate_pro->rate;
                                    		     
                                    		}		
                                    	}else{
                                    		if($rate_pro->code == "USD"){
												echo $this->erp->formatMoney($minqty*$min_price)." ".$rate_pro->code;
											}else{
												echo $this->erp->formatMoney($minqty*$min_price)." ".$rate_pro->code."</br>"."( ".$this->erp->formatMoney($minqty*$min_price/$rate_pro->rate)." USD )";
                                    		 	$curren = $rate_pro->code;
                                    		 	 $curren_rate = $rate_pro->rate;
											}
										}
                                    }else{
                                    	if($rate_pro->code == "USD"){
                                    		echo $this->erp->formatMoney($minqty*$min_price)." ".$rate_pro->code;
                                    	}else{
                                    		echo $this->erp->formatMoney($row->subtotal)." ".$rate_pro->code,"<br>"."(".$this->erp->formatMoney($minqty*$min_price/$rate_pro->rate)." USD )";
                                    		 $curren = $rate_pro->code;
                                    		 $curren_rate = $rate_pro->rate;
                                    	}
                                    }  ?>
                                </td>
							</tr> 
							<?php   
							$r++;
						endforeach;

					?>
					<tr class="blank" style="height: 120px;">
						<td colspan="5"></td>
					</tr>
					<tr>
						<td id="note" colspan="3" rowspan="9" style="font-size: 11px;border-left-color: white;"><?php if($inv->note){echo "<b>Note:</b> ".strip_tags($inv->note);}  ?></td>
						<td colspan="2" style="text-align:right;"><?= lang("total_kh")." (USD)" ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?php echo $this->erp->formatMoney($total)." USD"; ?></b>
						</td>
					</tr>
					<?php if($curren){ ?>
					<tr>
						<td  colspan="2" style="text-align:right;"><?= lang("total_kh")."( ".$curren." )"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($total* $curren_rate)." ".$curren ?></b>
						</td>
					</tr>
					<?php } ?>
					<?php if($inv->total_discount != 0){ ?>
					<tr>
						<td colspan="2"  style="text-align:right;"><?= lang("discount_khmer")." (USD)"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($inv->total_discount)." USD" ?></b>
						</td>
					</tr>
					<?php } ?>
					<?php if($inv->total_tax != 0){ ?>
					<tr>
						<td colspan="2" style="text-align:right;"><?= lang("tax_khmer")." (USD)"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($inv->total_tax)." USD" ?></b>
						</td>
					</tr>
					<?php } ?>
					<?php if($inv->shipping != 0){ ?>
					<tr>
						<td colspan="2"  style="text-align:right;"><?= lang("shipping_kh")." (USD)"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($inv->shipping)." USD" ?></b>
						</td>
					</tr>
					<?php } ?>
					<?php if($inv->deposit != 0){ ?>
					<tr>
						<td colspan="2"  style="text-align:right;"><?= lang("deposit_kh")." (USD)"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($inv->deposit)." USD" ?></b>
						</td>
					</tr>
					<?php } ?>
					<?php if($inv->paid != 0){ ?>
					<tr>
						<td colspan="2"  style="text-align:right;"><?= lang("paid_kh")." (USD)"; ?></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b><?= $this->erp->formatMoney($inv->paid)." USD" ?></b>
						</td>
					</tr>
					<?php } ?>	
					<tr>
						<td colspan="2" style="text-align:right;"><b><?= lang("balance_khmer")." USD"; ?></b></td>
						<td colspan="3" style="text-align:right; vertical-align:middle;">
							<b>
								<?= $this->erp->formatMoney($total-$inv->total_discount+$inv->total_tax-$inv->paid-$inv->deposit)." USD" ?>
							</b>
						</td>
					</tr>
					<?php if($curren){ ?>
					<tr>
						<td  colspan="2" style="text-align:right;"><b><?= lang("balance_khmer")."( ".$curren." )"; ?></b></td>
						<td colspan="2" style="text-align:right; vertical-align:middle;">
							<b>
							<?= $this->erp->formatMoney($total*$curren_rate-$inv->total_discount*$curren_rate+$inv->total_tax*$curren_rate+$inv->shipping*$curren_rate-$inv->paid*$curren_rate-$inv->deposit*$curren_rate)." ".$curren?>
							</b>
						</td>
					</tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<table border="0" cellspacing="0" style="font-size: 11px;">
					<tr>
						<td id="pd" colspan="3" width="25%">
							<span>ហត្ថលេខាអ្នកត្រួតពិនិត្យ</span>
						</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td id="pd" colspan="3" width="25%">
							<span>ហត្ថលេខាអ្នកប្រគល់ទំនិញ</span>
						</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td id="pd" colspan="3" width="25%">
							<span>ហត្ថលេខាអតិថិជន</span>
						</td>
						
					</tr>
					<tr>
						<td style="height: 100px;vertical-align:top !important;">
					</tr>			
					<tr>
						<td id="pd" colspan="3" width="25%" valign="bottom" style="font-size: 11px">
							<span>ឈ្មោះ: <?= $created_by->username; ?></span>
							<hr style="border:dotted 1px; width:160px; vertical-align:bottom !important; " />
							<span>ថ្ងៃបោះពុម្ភ: <?= $inv->date; ?></span>
						</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td id="pd" colspan="3" width="25%" valign="bottom" style="font-size: 11px">
							<span>ឈ្មោះ: </span>
							<hr style="border:dotted 1px; width:160px; vertical-align:bottom !important; " />
							<span>ម៉ោងចេញ: </span>
						</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td id="pd" colspan="3" width="25%" valign="bottom" style="font-size: 11px">
							<span>ឈ្មោះ:</span>
							<hr style="border:dotted 1px; width:160px; vertical-align:bottom !important; " />
							<span>ម៉ោងទទួល: </span>
						</td> 
					</tr>						
				</table>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>