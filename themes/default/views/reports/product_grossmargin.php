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
	#tbstock th {
		border-bottom-width: 1px;
	}

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('product_grossmargin') ; ?>
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
						<div class="col-sm-4">
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
						 </div>
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
						<div class="col-sm-4">
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
                        </div>
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
								<th rowspan="2"><?= lang("no") ?></th>
								<th rowspan="2"><?= lang("item_number") ?></th>
								<th rowspan="2"><?= lang("description") ?></th>
								<th rowspan="2"><?= lang("cate_code") ?></th>
								<th rowspan="2"><?= lang("type") ?></th>
								<th colspan="3"><?= lang("beginning_balance") ?></th>
								<th colspan="2"><?= lang("in") ?></th>
								<th colspan="5"><?= lang("out") ?></th>
								<th rowspan="2"><?= lang("profit") ?></th>
								<th colspan="3"><?= lang("ending_balance") ?></th>
							</tr>
							<tr class="shead">
								<th><?= lang('Qty') ?></th>
								<th><?= lang('cost') ?></th>
								<th><?= lang('tcost') ?></th>

								<th><?= lang('Qty') ?></th>
								<th><?= lang('amount') ?></th>

								<th><?= lang('Qty') ?></th>
								<th><?= lang('cost') ?></th>
								<th><?= lang('sale_price') ?></th>
								<th><?= lang('tcost') ?></th>
								<th><?= lang('total') ?></th>

								<th><?= lang('Qty') ?></th>
								<th><?= lang('cost') ?></th>
								<th><?= lang('tcost') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$gtt = 0;
							$gqty = 0;
							if(is_array($warehouses)){
							   foreach($warehouses as $warehouse){
								
							?>
							<tr>
								<td colspan="19" class="text-left" style="font-weight:bold; font-size:19px !important; color:#428BCA;">
									<?= lang("warehouse"); ?>
									<i class="fa fa-angle-double-right" aria-hidden="true"></i>
									&nbsp;&nbsp;<?=$warehouse->warehouse?>
								</td>
							</tr>
							
							<?php 
							$categories = $this->reports_model->getCategoriesInventoryValuationByWarehouse($warehouse->warehouse_id,$cate_id1,$product_id1,$stockType1,$from_date1,$to_date1,$reference1,$biller1);	
							$total_qoh_per_warehouse_cat = 0;
							$total_assetVal_per_warehouse_cat = 0;
							?>
							
							<?php 
							$total_qoh_per_warehouse = 0;
							$total_assetVal_per_warehouse = 0;
							$products = $this->reports_model->getProductsInventoryValuationByWhCat($warehouse->warehouse_id,($cate_id1?$cate_id1:$category->category_id),$product_id1,$stockType1,$from_date1,$to_date1,$reference1,$biller1);							
							foreach($products as $product){ 
								if(!empty($product->product_id)){
							?>
							<tr>
								<td colspan="19" class="left" style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$product->product_code?$product->product_code:$product->product_id?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?=$product->product_name?> (<?=$product->un;?>)</td>
								
							</tr>
							
							<?php 
							}
							$qty_on_hand = 0;
							$total_on_hand = 0;
							$total_asset_val = 0;
							$btotal_qty = 0;
							$unit_name = "";
							$prDetails = $this->reports_model->getProductsGrossMarginData($warehouse->warehouse_id,($cate_id1?$cate_id1:$category->category_id),($product_id1?$product_id1:$product->product_id),$stockType1,$from_date1,$to_date1,$reference1,$biller1);

							foreach($prDetails as $pr)
							{
								$p_cost = 0;
								$p_qty = 0;
								$tCost = 0;

								$beginINqty = $this->reports_model->getBeginQtyINALL2($pr->product_id,$warehouse->warehouse_id,$from_date2,$to_date2,$biller2);
								$beginOUTqty = $this->reports_model->getBeginQtyOUTALL2($pr->product_id,$warehouse->warehouse_id,$from_date2,$to_date2,$biller2);
								$btotal_qty = $beginINqty->bqty-$beginOUTqty->bqty;
								$begin_qty = $this->reports_model->getBeginQtyALL($pr->product_id,$warehouse->warehouse_id,$from_date2,$to_date2,$biller2);
								
								if($pr->type == 'PURCHASE' 
								|| $pr->type == 'SALE RETURN' 
								|| $pr->type == 'OPENING QUANTITY' )
								{								
									$p_qty = abs($pr->quantity);
								}else if($pr->type == 'TRANSFER'){	
									$p_qty = (-1)*$pr->quantity;	
								}
								else if( $pr->type == 'ADJUSTMENT' ){	
									$p_qty = $pr->quantity;				
								}
								else if( $pr->type == 'CONVERT' ){	
									$p_qty = $pr->quantity;				
								}
								else
								{
									$p_qty = (-1) * $pr->quantity;
								}
								
								//$qa = $this->db->get_where('purchase_items',array('id'=> $pr->field_id),1);
								//$qa = $this->reports_model->getV($pr->field_id);
									
										$unit_name = $this->erp->convert_unit_2_string($pr->product_id,$p_qty);
									
										//$this->db->select("units.name")->join("units","units.id=erp_products.unit","LEFT")->where("erp_products.id",$pr->product_id);
										//$unit = $this->db->get("erp_products")->row();
										//$unit_name2 = $unit->name;
									
								
								
								$qty_on_hand += $p_qty ;// $pr->qty_on_hand;
								
								$p_cost = $this->erp->formatDecimal($pr->cost);
								$avg_cost = $pr->avg_cost;
								$this->db->select("cost")->where("erp_products.id",$pr->product_id);
								$cost = $this->erp->formatDecimal($this->db->get_where("erp_products",array("id"=>$product->product_id),1)->row()->cost);
								$asset_value = $cost * $qty_on_hand;
								$tCost += $btotal_qty * $pr->cost;
								$QtyTCost += $btotal_qty + $tCost;
								
							?>
							<tr>
								<td style="border-top:none;border-bottom:none;"></td>
								<td><?= $pr->pcode ?></td>
								<td><?= $pr->pname ?></td>
								<td><?= $pr->cname ?></td>
								<td><?= $pr->type ?></td>
								<!-- <td><?= $pr->quantity ?></td> -->
								<td><?=$btotal_qty?$this->erp->formatDecimal($btotal_qty):''?></td>
								<td><?= $this->erp->formatMoney($pr->cost) ?></td>
								<td><?= $this->erp->formatMoney($tCost) ?></td>
								
								<?php
								$total_in = 0;
								$total_out = 0;
									if(is_array($num)){
									foreach($num as $tr){
										
										if($tr->transaction_type){
											$allqty = $this->reports_model->getQtyINALL($pr->product_id,$warehouse->warehouse_id,$tr->transaction_type,$from_date2,$to_date2,$biller2);
											$qty_unit = $this->reports_model->getQtyUnitINALL($pr->product_id,$warehouse->warehouse_id,$tr->transaction_type,$from_date2,$to_date2,$biller2);
											?>
											
									<td>
									<?php if($allqty->bqty){?>
									<span><?=$this->erp->formatDecimal($allqty->bqty)?></span>
										<br>
										<?php
										if($qty_unit->bqty){
											echo   $this->erp->convert_unit_2_string($pr->product_id,$qty_unit->bqty);
										}
									}
										?>
									</td>

									<?php
											 $total_in +=$allqty->bqty;
											 $QtyAmount += $allqty->bqty + $pr->avg_cost;
											 
										
										}
									}
									}
									$outCost = $QtyTCost / $QtyAmount;
									// $this->erp->print_arrays($outCost);
									?>
								
								<td><?= $this->erp->formatMoney($pr->avg_cost) ?></td>

								<?php
									if(is_array($num2)){
									
									foreach($num2 as $tr2){
										
											if($tr2->transaction_type){
											$allqty2 = $this->reports_model->getQtyOUTALL($pr->product_id,$warehouse->warehouse_id,$tr2->transaction_type,$from_date2,$to_date2,$biller2);
												$qty_unit2 = $this->reports_model->getQtyUnitOUTALL($pr->product_id,$warehouse->warehouse_id,$tr2->transaction_type,$from_date2,$to_date2,$biller2);?>
												
											 <td style="text-align: center; vertical-align: middle;">
											 <?php if($allqty2->bqty){?>
											 <span><?=$this->erp->formatDecimal($allqty2->bqty)?></span><br>
											 <?php
												 if($qty_unit2->bqty){
													echo   $this->erp->convert_unit_2_string($pr->product_id,$qty_unit2->bqty);
												 }
											 }
											?>
											 </td>
											 
									<?php
											 $total_out+=$allqty2->bqty;
											 $outTotalCost = $allqty2->bqty * $outCost;
											 $outTotal = $allqty2->bqty * $pr->OSPrice;
											 $profit = $outTotalCost - $outTotal;
											 $EndingBalanceQty = $btotal_qty - $allqty2->bqty;
										 }
										
									}
									}
									$am = ($total_in-$total_out);
									$EndingBalanceTotalCost = $EndingBalanceQty * $pr->cost;
									?>

								
								<td><?= $this->erp->formatMoney($outCost); ?></td>
								<td><?= $this->erp->formatMoney($pr->OSPrice); ?></td>
								<td><?= $this->erp->formatMoney($outTotalCost); ?></td>
								<td><?= $this->erp->formatMoney($outTotal); ?></td>
								<td><?= $this->erp->formatMoney($profit); ?></td>
								<td><?= $EndingBalanceQty ?></td>
								<td><?= $this->erp->formatMoney($pr->cost) ?></td>
								<td><?= $EndingBalanceTotalCost ?></td>
							</tr>
							<?php
								$total_on_hand =$qty_on_hand;
								$total_asset_val =$asset_value;
							} ?>
							
							<!-- <tr class="active">
								<td colspan="8" class="right" style="font-weight:bold;"><?= lang("total") ?> 
									<i class="fa fa-angle-double-right" aria-hidden="true"></i> 
								</td>
								<td class="text-right"><b><?= $this->erp->formatDecimal($total_on_hand); ?></b></td>
								<td></td>
								<td class="text-right"><b><?= $this->erp->formatMoney($total_asset_val); ?></b></td>
							</tr> -->
							<?php 
								$total_qoh_per_warehouse += $total_on_hand;
								$total_assetVal_per_warehouse += $total_asset_val;
							} 
							?>	
							<!-- <tr>
									<td class="right" colspan="8" style="font-weight:bold; color:orange; "><?= lang("total") ?> 
										<i class="fa fa-angle-double-right" aria-hidden="true"></i> 
										<?=$category->category_name?></td>
									<td class="text-right"><b><?= $this->erp->formatDecimal($total_qoh_per_warehouse); ?></b></td>
									<td></td>
									<td class="text-right"><b><?= $this->erp->formatMoney($total_assetVal_per_warehouse); ?></b></td>
								</tr> -->	
							<?php
								
								$total_qoh_per_warehouse_cat +=$total_qoh_per_warehouse;
								$total_assetVal_per_warehouse_cat +=$total_assetVal_per_warehouse;
							?>
							
							<!-- <tr>
								<td class="right" colspan="8" style="font-weight:bold; color:green;"><span style=" font-size:17px;"><?= lang("total") ?> 
									<i class="fa fa-angle-double-right" aria-hidden="true"></i> 
									<?=$warehouse->warehouse?></span></td>
								<td class="text-right"><b><?= $this->erp->formatDecimal($total_qoh_per_warehouse_cat); ?></b></td>
								<td></td>
								<td class="text-right"><b><?= $this->erp->formatMoney($total_assetVal_per_warehouse_cat); ?></b></td>
							</tr> -->
							
							<?php
							$gtt +=$total_qoh_per_warehouse_cat;
							$gqty +=$total_assetVal_per_warehouse_cat;
							} 
							}
							?>
								
					
								<!-- <tr>
								<td class="right" colspan="8" style="font-weight:bold; background-color: #428BCA;color:white;text-align:right;"><span style=" font-size:17px;"><?= lang("grand_total") ?></span> </td>	
								<td class="text-right" style='background-color: #428BCA;color:white;text-align:right;'><span style=" font-size:17px;"><b><?= $this->erp->formatDecimal($gtt); ?></b></span></td>
								<td style='background-color: #428BCA;color:white;text-align:right;'></td>
								<td class="text-right" style='background-color: #428BCA;color:white;text-align:right;'><span style=" font-size:17px;"><b><?= $this->erp->formatMoney($gqty); ?></b></span></td>
															</tr> -->
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