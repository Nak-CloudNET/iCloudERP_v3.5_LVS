<?php 
	//$this->erp->print_arrays($from_date2,$to_date2);
?>

<script type="text/javascript">
$(document).ready(function(){
	
	$('body').on('click', '#excel1', function(e) {
	   e.preventDefault();
	   var k = false;
	   $.each($("input[name='val[]']:checked"), function(){
	    k = true;

	   });
	   $('#form_action').val($('#excel1').attr('data-action'));
	   $('#action-form-submit').trigger('click');
  	});
  	$('body').on('click', '#pdf1', function(e) {
	   e.preventDefault();
	   var k = false;
	   $.each($("input[name='val[]']:checked"), function(){
	    
	    k = true;
	   });
	   $('#form_action').val($('#pdf1').attr('data-action'));
	   $('#action-form-submit').trigger('click');
  	});
});
</script>
<style>
	#tbstock .shead th{
		background-color: #428BCA;border-color: #357EBD;color:white;text-align:center;
	}

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('products_in_out') ; ?>
        </h2>
		<div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
				<li class="dropdown">
					<a href="#" id="pdf" data-action="export_pdf"  class="tip" title="<?= lang('download_pdf') ?>">
						<i class="icon fa fa-file-pdf-o"></i>
					</a>
				</li>
                <li class="dropdown">
					<a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>">
						<i class="icon fa fa-file-excel-o"></i>
					</a>
				</li>
            </ul>
        </div>       
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
				<?php
				//echo $this->session->userdata('user_id');
				?>
                <p class="introtext"><?= lang('list_results'); ?></p>
                <div id="form">
				<?php echo form_open('reports/inventory_inout', 'id="action-form"'); ?>
					<div class="row">
                       <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="cat"><?= lang("products"); ?></label>
                                <?php
								$pro[""] = "ALL";
                                foreach ($products as $product) {
                                    $pro[$product->id] = $product->code.' / '.$product->name;
                                }
                                echo form_dropdown('product', $pro, (isset($_POST['product']) ? $_POST['product'] : $product2), 'class="form-control" id="product" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("producte") . '"');
                                ?>
								
                            </div>
                        </div>
						<?php if(isset($biller_idd)){?>
						<!--<div class="col-sm-4">
						 <div class="form-group">
                                    <?= lang("biller", "biller"); ?>
                                    <?php 
									$str = "";
									$q = $this->db->get_where("companies",array("id"=>$biller_idd),1);
									 if ($q->num_rows() > 0) {
										 $str = $q->row()->company.' / '.$q->row()->name;
										echo form_input('biller',$str , 'class="form-control" id="biller"');
									 }
									?>
                                </div>
						 </div>-->
						<?php } ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("warehouse", "warehouse") ?>
                                <?php
                                $waee[''] = "ALL";
                                foreach ($warefull as $wa) {
                                    $waee[$wa->id] = $wa->code.' / '.$wa->name;
                                }
                                echo form_dropdown('warehouse', $waee, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'class="form-control select" id="warehouse" placeholder="' . lang("select") . " " . lang("warehouse") . '" style="width:100%"')
							
                                ?>

                            </div>
                        </div>
						<!--<div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("biller"); ?></label>
                                <?php
								$bill[""] = "ALL";
                                foreach ($billers as $biller) {
                                    $bill[$biller->id] =  $biller->code.' / '.$biller->name;
                                }
                                echo form_dropdown('biller', $bill, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>-->
						<div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("category", "category") ?>
                                <?php
                                $cat[''] = "ALL";
                                foreach ($categories as $category) {
                                    $cat[$category->id] = $category->name;
                                }
                                echo form_dropdown('category', $cat, (isset($_POST['category']) ? $_POST['category'] : $category2), 'class="form-control select" id="category" placeholder="' . lang("select") . " " . lang("category") . '" style="width:100%"')
                                ?>

                            </div>
                        </div>
						 <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("from_date", "from_date"); ?>
                                <?php echo form_input('from_date', (isset($_POST['from_date']) ? $_POST['from_date'] : $this->erp->hrsd($from_date2)), 'class="form-control date" id="from_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("to_date", "to_date"); ?>
                                <?php echo form_input('to_date', (isset($_POST['to_date']) ? $_POST['to_date'] : $this->erp->hrsd($to_date2)), 'class="form-control date" id="to_date"'); ?>
                            </div>
                        </div>		
					
						
						</div>
					<div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary sub"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>
					
                </div>
                <div class="clearfix"></div>
				<?php
					$wid = $this->reports_model->getWareByUserID();
					
					if(!$warehouse2){
						$warehouse2 = $wid;
					}
					
					$num = $this->reports_model->getTransuctionsPurIN($product2,$warehouse2,$from_date2,$to_date2,$biller2);
					
					$k = 0;
					if(is_array($num)){
					foreach($num as $r){
						if($r->transaction_type){
							$k++;
						}
					}
					}
					
					$num2 = $this->reports_model->getTransuctionsPurOUT($product2,$warehouse2,$from_date2,$to_date2,$biller2);
					$k2 = 0;
					if(is_array($num2)){
					foreach($num2 as $r2){
						if($r2->transaction_type){
							$k2++;
						}
					}
					}
					
					//$numMonth=1;
					//echo $startDate=date('Y-m-01',strtotime($from_date2 . " + $numMonth month"));
					//echo $endDate=date('Y-m-t',strtotime($from_date2 . " + $numMonth month"));
				?>
                <div class="table-responsive" style="width:100%;overflow:auto;">
                    <table id="tbstock" class="table table-condensed table-bordered table-hover table-striped" >
                        <thead>
							<tr>							
								<th rowspan="2">Location <span style="color:orange;">/</span> Category <span style="color:orange;">/</span> Item</th>
								<th rowspan="2"><?= lang("begin") ?></th>
								<?php if($k){?>
								<th colspan="<?=$k?>"><?= lang("in") ?></th>
								<?php } ?>
								<th rowspan="2"><?= lang("total_in") ?></th>
								<?php if($k2){?>
								<th  colspan="<?=$k2?>"><?= lang("out") ?></th>
								<?php } ?>
								<th rowspan="2"><?= lang("total_out") ?></th>
								<th rowspan="2"><?= lang("balance") ?></th>
							</tr>
							<tr class="shead">
								
								<?php
									if(is_array($num)){
									foreach($num as $tr){
										if($tr->transaction_type){
											echo "<th>".lang(strtolower($tr->transaction_type))."</th>";
										}
									}
									}
								?>
								<?php
									if(is_array($num2)){
									foreach($num2 as $tr2){
										if($tr2->transaction_type){
											echo "<th>".lang(strtolower($tr2->transaction_type))."</th>";
										}
									}
									}
								?>
								
							</tr>
						</thead>
                        <tbody>
							<?php
							if(is_array($ware)){
								foreach($ware as $rw){
							?>		
								<tr>
									<td colspan="<?=$k+$k2+5?>" style="color:green;"><span style="font-size:17px;"><b><?=$rw->name;?> /</b></span></td>
								</tr>
								<?php
									$total2_inn = 0;
									$total2_outt = 0;
									$total_balance = 0;
									$total_begin_balance = 0;
									
									$procat = $this->reports_model->getProCat($rw->id,$category2,$product2,$biller2,$from_date2,$to_date2);
									$total_in_cate_w = array();
									$total_out_cate_w = array();
									//$this->erp->print_arrays($procat);
									foreach($procat as $rc){
									
								?>
									<tr>
									<td colspan="<?=$k+$k2+5?>" style="color:orange;">&nbsp;&nbsp;&nbsp;<span style="font-size:15px;"><b><?=$rc->name;?> /</b></span></td>
									</tr>
								<?php
									$balance = 0;
									$total_inn = 0;
									$total_outt = 0;
									$am = 0;
									$begin_balance = 0;
									$btotal_qty = 0;
									$total_in_cate = array();
									$total_out_cate = array();
									
									$propur = $this->reports_model->getProPur($rw->id,$rc->id,$product2,$biller2);
									
									foreach($propur as $rp){
										
										$beginINqty = $this->reports_model->getBeginQtyINALL($rp->product_id,$rw->id,$from_date2,$to_date2,$biller2);
										$beginOUTqty = $this->reports_model->getBeginQtyOUTALL($rp->product_id,$rw->id,$from_date2,$to_date2,$biller2);
										$btotal_qty = $beginINqty->bqty-$beginOUTqty->bqty;
										$begin_qty = $this->reports_model->getBeginQtyALL($rp->product_id,$rw->id,$from_date2,$to_date2,$biller2);
										
								?>
										<tr>
											<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $rp->name? "(" . $rp->code . ")" . $rp->name:$rp->product_id;?><?=" (".$rp->name_unit.")"?></td>
											<td style='text-align:right;'>
											<?php if($btotal_qty){?>
												<span style="color:blue;"><?=$btotal_qty?$this->erp->formatDecimal($btotal_qty):''?></span>
												<?php
												if($begin_qty->bqty){
													echo  $this->erp->convert_unit_2_string($rp->product_id,$begin_qty->bqty);
												}
												
											}
												?>
												
											</td>
										<?php
										$total_in = 0;
										$total_out = 0;
											if(is_array($num)){
											foreach($num as $tr){
												if($tr->transaction_type){
													$allqty = $this->reports_model->getQtyINALL($rp->product_id,$rw->id,$tr->transaction_type,$from_date2,$to_date2,$biller2);
													$qty_unit = $this->reports_model->getQtyUnitINALL($rp->product_id,$rw->id,$tr->transaction_type,$from_date2,$to_date2,$biller2);
													//$this->erp->print_arrays($allqty);
													?>
											
											<td style='text-align:right;'>
												<?php if($allqty->bqty){?>
												<span style="color:blue;"><?=$this->erp->formatDecimal($allqty->bqty)?></span>
													<br>
													<?php
													if($qty_unit->bqty){
														echo   $this->erp->convert_unit_2_string($rp->product_id,$qty_unit->bqty);
													}
												}
												?>
											</td>

											<?php
													 $total_in +=$allqty->bqty;
												
													// $total_in_cate[$tr->transaction_type] +=$allqty->bqty;
												
												}
											}
											}?>
											<td style='text-align:right;'>
											
											<b><?=$this->erp->formatDecimal($total_in?$total_in:'')?></b>
											
											</td>
											<?php
											if(is_array($num2)){
											
											foreach($num2 as $tr2){
													if($tr2->transaction_type){
													$allqty2 = $this->reports_model->getQtyOUTALL($rp->product_id,$rw->id,$tr2->transaction_type,$from_date2,$to_date2,$biller2);
														$qty_unit2 = $this->reports_model->getQtyUnitOUTALL($rp->product_id,$rw->id,$tr2->transaction_type,$from_date2,$to_date2,$biller2);
														//$this->erp->print_arrays($allqty2);
														?>
														
													 <td style='text-align:right;'>
													 <?php if($allqty2->bqty){?>
													 <span style="color:blue;"><?=$this->erp->formatDecimal($allqty2->bqty)?></span><br>
													 <?php
														 if($qty_unit2->bqty){
															echo   $this->erp->convert_unit_2_string($rp->product_id,$qty_unit2->bqty);
														 }
													 }
													?>
													 </td>
													 
											<?php
													 $total_out+=$allqty2->bqty;
														
													/*	if(in_array($tr2->transaction_type,$total_out_cate)){
															$total_out_cate[$tr2->transaction_type] +=$allqty2->bqty;
														}*/
												 }
												
											}
											}
											//$qty_unit3 = $this->reports_model->getQtyUnitALL($rp->product_id,$rw->id,$from_date2,$to_date2);
											$am = ($total_in-$total_out);
											?>
											<td style='text-align:right;'><b><?=$this->erp->formatDecimal($total_out?$total_out:'')?></b> </td>
											<td style='text-align:right;'><span><b><?=$this->erp->formatDecimal($am?$am:'')?></b></span><br>
											<?php
											
													 if($am){
														
															echo   $this->erp->convert_unit_2_string($rp->product_id,$am);
														 
													}
													?>
											</td>
										</tr>
										
							<?php	
										$balance+=$am;
										$begin_balance+=$btotal_qty;
										$total_inn +=$total_in;
										$total_outt +=$total_out;
									}
								?>
								<tr>
									<td style=" text-align:right;background:#F0F8FF;"><b>Total <span style="color:orange;">>></span> <?=$rc->name;?>:</b></td>
									<td style='text-align:right;background:#F0F8FF;'>
												<b><?=$this->erp->formatDecimal($begin_balance?$begin_balance:'')?></b>
									</td>
									<?php
										if(is_array($num)){
											foreach($num as $tr){
												if($tr->transaction_type){
													$amount_qty = $this->reports_model->getAmountQtyINALL($product2,$rw->id,$tr->transaction_type,$rc->id,$from_date2,$to_date2,$biller2);
													 
													 echo "<td style='text-align:right;background:#F0F8FF;'><b>".$this->erp->formatDecimal($amount_qty->bqty?$amount_qty->bqty:'')."</b></td>";
												
													 //$total_in_cate_w[$tr->transaction_type] += $total_in_cate[$tr->transaction_type];
											
													 
												}
											}
										}?>
										<td style='text-align:right;background:#F0F8FF;'><b><?=$this->erp->formatDecimal($total_inn?$total_inn:'')?></b></td>
										<?php
										if(is_array($num2)){
										
											foreach($num2 as $tr2){
												 
													if($tr2->transaction_type){
													 $amount_qty2 = $this->reports_model->getAmountQtyOUTALL($product2,$rw->id,$tr2->transaction_type,$rc->id,$from_date2,$to_date2,$biller2);
														
														 echo "<td style='text-align:right;background:#F0F8FF;'><b>".$this->erp->formatDecimal($amount_qty2->bqty?$amount_qty2->bqty:'')."</b></td>";
														// $total_out_cate_w[$tr2->transaction_type] += $total_out_cate[$tr2->transaction_type];
														
													
													}
												
											}
										}
											?>
									<td style='text-align:right;background:#F0F8FF;'><b><?=$this->erp->formatDecimal($total_outt?$total_outt:'')?></b></td>
									<td style='text-align:right;background:#F0F8FF;'><b><?=$this->erp->formatDecimal($balance?$balance:'')?></b></td>
									</tr>
							<?php
									$total_balance+=$balance;
									$total_begin_balance+=$begin_balance;
									$total2_inn +=$total_inn;
									$total2_outt +=$total_outt;
									}
							?>		
								<tr>
									<td  style="text-align:right; background:#428BCA;color:white;border-color: #357EBD;"><b>Grand Total >> <?=$rw->name;?>:</b></td>
									<td style="text-align:right; background:#428BCA;color:white;border-color: #357EBD;"><b><?=$this->erp->formatDecimal($total_begin_balance?$total_begin_balance:'')?></b></td>
									<?php
										if(is_array($num)){
											foreach($num as $tr){
												if($tr->transaction_type){
													$amount_qty_cat = $this->reports_model->getAmountQtyINALLCAT($product2,$rw->id,$tr->transaction_type,$category2,$from_date2,$to_date2,$biller2);
													
													 echo "<td style='text-align:right; background:#428BCA;color:white;border-color: #357EBD;'><b>".$this->erp->formatDecimal($amount_qty_cat->bqty?$amount_qty_cat->bqty:'')."</b></td>";
												
												}
											}
										}?>
										<td style="text-align:right; background:#428BCA;color:white;border-color: #357EBD;"><b><?=$this->erp->formatDecimal($total2_inn?$total2_inn:'')?></b></td>
										
										<?php
										if(is_array($num2)){
											foreach($num2 as $tr2){
												
												if($tr2->transaction_type){
													 $amount_qty_cat2 = $this->reports_model->getAmountQtyOUTALLCAT($product2,$rw->id,$tr2->transaction_type,$category2,$from_date2,$to_date2,$biller2);
													
													 echo "<td style='text-align:right; background:#428BCA;color:white;border-color: #357EBD;'><b>".$this->erp->formatDecimal($amount_qty_cat2->bqty?$amount_qty_cat2->bqty:'')."</b></td>";
													
												}
												 
											}
										}
											?>
									<td style="text-align:right; background:#428BCA;color:white;border-color: #357EBD;"><b><?=$this->erp->formatDecimal($total2_outt?$total2_outt:'')?></b></td>
									<td style="text-align:right; background:#428BCA;color:white;border-color: #357EBD;"><b><?=$this->erp->formatDecimal($total_balance?$total_balance:'')?></b></td>
									</tr>
							<?php
								}
							}
							?>
                        </tbody>                       
                    </table>
                </div>
				
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

	$(document).on('focus','.date-year', function(t) {
			$(this).datetimepicker({
				format: "yyyy",
				startView: 'decade',
				minView: 'decade',
				viewSelect: 'decade',
				autoclose: true,
			});
	});
    $('#form').hide();
    $('.toggle_down').click(function () {
        $("#form").slideDown();
        return false;
    });
    $('.toggle_up').click(function () {
        $("#form").slideUp();
        return false;
    });
	$('#excel').on('click', function (e) {
		e.preventDefault();
		if ($('.checkbox:checked').length <= 0) {
			window.location.href = "<?= site_url('reports/inventoryInoutReport/0/xls/'.$product1.'/'.$category1.'/'.$warehouse1.'/'.$from_date2.'/'.$to_date2) ?>";
			return false;
		}
	});
	$('#pdf').on('click', function (e) {
		e.preventDefault();
		if ($('.checkbox:checked').length <= 0) {
			window.location.href = "<?= site_url('#') ?>";
			return false;
		}
	});	
});


		
</script>