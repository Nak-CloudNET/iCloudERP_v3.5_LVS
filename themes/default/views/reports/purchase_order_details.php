<?php

	$v = "";
	
	if ($this->input->post('reference_no')) {
		$v .= "&reference_no=" . $this->input->post('reference_no');
	}
	
	if ($this->input->post('biller')) {
		$v .= "&biller=" . $this->input->post('biller');
	}
	if ($this->input->post('warehouse')) {
		$v .= "&warehouse=" . $this->input->post('warehouse');
	}
	if ($this->input->post('user')) {
		$v .= "&user=" . $this->input->post('user');
	}
	
	if ($this->input->post('start_date')) {
		$v .= "&start_date=" . $this->input->post('start_date');
	}
	if ($this->input->post('end_date')) {
		$v .= "&end_date=" . $this->input->post('end_date');
	}
	if (isset($biller_id)) {
		$v .= "&biller_id=" . $biller_id;
	}

?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        <?php if ($this->input->post('customer')) { ?>
        $('#customer').val(<?= $this->input->post('customer') ?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "customers/suggestions/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data.results[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            },
			$('#customer').val(<?= $this->input->post('customer') ?>);
        });

        <?php } ?>
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>

<?php
    echo form_open('reports/purchase_order_detail_actions', 'id="action-form"');
?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('purchase_order_detail'); ?><?php
            if ($this->input->post('start_date')) {
                echo " From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                            class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                            class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="pdf" data-action="export_pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                            class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                            class="icon fa fa-file-picture-o"></i></a></li>
            </ul>
        </div>
		
    </div>

    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>
				<input type="hidden" value="helo" name="test">
                <div id="form">

					<?php echo form_open('reports/purchase_order_details', 'id="action-form" method="GET"'); ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="reference_no"><?= lang("reference_no"); ?></label>
                                <?php echo form_input('reference_no', (isset($_GET['reference_no']) ? $_GET['reference_no'] : ""), 'class="form-control tip" id="reference_no"'); ?>
                            </div>
                        </div>
						<?php if($Owner || $Admin){?>
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label" for="user"><?= lang("created_by"); ?></label>
									<?php
									$us[""] = "";
									foreach ($users as $user) {
										$us[$user->id] = $user->first_name . " " . $user->last_name;
									}
									echo form_dropdown('user', $us, (isset($_GET['user']) ? $_GET['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
									?>
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-sm-3" style="display:none;">
								<div class="form-group">
									<label class="control-label" for="user"><?= lang("created_by"); ?></label>
									<?php
									$us[""] = "";
									foreach ($users as $user) {
										$us[$user->id] = $user->first_name . " " . $user->last_name;
									}
									echo form_dropdown('user', $us, (isset($_GET['user']) ? $_GET['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
									?>
								</div>
							</div>    
						<?php } ?>
                        <?php if($Owner || $Admin){ ?>
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label" for="biller"><?= lang("biller"); ?></label>
									<?php
									$bl[""] = "";
									foreach ($billers as $biller) {
										$bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
									}
									echo form_dropdown('biller', $bl, (isset($_GET['biller']) ? $_GET['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
									?>
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-sm-3" style="display:none;">
								<div class="form-group">
									<label class="control-label" for="biller"><?= lang("biller"); ?></label>
									<?php
									$bl[""] = "";
									foreach ($billers as $biller) {
										$bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
									}
									echo form_dropdown('biller', $bl, (isset($_GET['biller']) ? $_GET['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
									?>
								</div>
							</div>
						<?php } ?>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $wh[""] = "";
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_GET['warehouse']) ? $_GET['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>
                        </div>
						<?php if($this->Settings->product_serial) { ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <?= lang('serial_no', 'serial'); ?>
                                    <?= form_input('serial', '', 'class="form-control tip" id="serial"'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_GET['start_date']) ? $_GET['start_date'] :""), 'class="form-control datetime" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_GET['end_date']) ? $_GET['end_date'] : ""), 'class="form-control datetime" id="end_date"'); ?>
                            </div>
                        </div>
					</div>
                    <div class="form-group">
                        <div class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>
			
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-condensed reports-table">
						<thead>
							<tr class="info-head">
								<th style="min-width:30px; width: 30px; text-align: center;">
									<input class="checkbox checkth" type="checkbox" name="check"/>
								</th>
								<th  class="center"><?= lang("item"); ?></th>
								<th  class="center"><?= lang("project"); ?></th>
								<th ><?= lang("warehouse"); ?></th>
								<th ><?= lang("quantity"); ?></th>
							</tr>
						</thead>
                        <tbody>
						<?php 
							
							$warehouses_arr = array();
							$warehouses = $this->db->get("warehouses")->result();
							foreach($warehouses as $warehouse){
								$warehouses_arr[$warehouse->id] = $warehouse->name;
							}
							
							$total_all_quantity			= 0;
							$total_order_discount		= 0;
							$total_shipping				= 0;
					
							
							if(count($purchases) > 0){
								foreach($purchases as $key => $purchase){
								$total_quantity = 0;
								$total_order_discount 	+= $purchase->order_discount;
								$total_shipping			+= $purchase->shipping;
								$table_return_items = "erp_return_purchase_items"; 
								$table_purchase_order_items = "erp_purchase_order_items";
								$sql="SELECT 
										product_name,
										product_code,
										net_unit_cost,
										quantity,
										erp_purchase_order_items.tax,
										erp_companies.name as biller,
										erp_warehouses.id as warehouse_id,
										total,
										order_discount,
										shipping,
										supplier
										FROM erp_purchase_order_items LEFT JOIN erp_purchases_order
										ON erp_purchase_order_items.purchase_id=erp_purchases_order.id
										LEFT JOIN erp_companies ON erp_purchases_order.biller_id=erp_companies.id
										LEFT JOIN erp_warehouses ON erp_purchases_order.warehouse_id=erp_warehouses.id
										
										WHERE purchase_id={$purchase->id}";
								$result = $this->db->query($sql);
								$purchases_detail=$result->result();
							
							?>
								
								<tr class="info-reference_no">
									<td><input type="checkbox" class="checkbox multi-select input-xs" name='val[]' value="<?php echo $purchase->id ?>" /></td>
									<td colspan="12" style="font-size:18px;" class="left">
										<b style="<?php if($purchase->type == 2){ echo "color:red"; } ?>">
											<?= $purchase->reference_no; ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
											<?= $purchase->supplier ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
											<?= date('d/M/Y h:i A',strtotime($purchase->date)); ?>
											
										</b>
									</td>									
								</tr>
								<?php 
									if($purchase->type == 1){
										foreach($purchases_detail as $purchase_detail){										
										
											//$total_discount 		+= $purchase_detail->item_discount;
											$total_quantity 		+= $purchase_detail->quantity;
											$total_all_quantity		+= $purchase_detail->quantity;
											
											
										 
								?>
										<tr>			
											<td></td>
											<td>(<?= $purchase_detail->product_name; ?>) (<?= $purchase_detail->product_code ?>)</td>
											<td><?= $purchase_detail->biller ?></td>
											<td class="center"><?= $warehouses_arr[$purchase_detail->warehouse_id]; ?></td>
											<td class="right"><?= $this->erp->formatMoney($purchase_detail->quantity); ?></td>
										
										</tr>
								<?php  
									}
									
									$html = "";
									
									
									}else{
																			
									}

								?>
									
								<tr style="font-weight:bold;">
									<td colspan="3"></td>
									<td class="right"><?= lang("total_quantity")?> :</td>
									<td class="right"><?= $this->erp->formatMoney($total_quantity); ?></td>
								</tr>
								<!--
								<tr style="font-weight:bold;">
                                    <td colspan="3"></td>
									<td class="info-reference_no right"><?= lang("order_discount")?> :</td>
									<td class="right"><?= "(".$this->erp->formatMoney($purchase->order_discount).")"; ?></td>
								</tr>
								<tr style="font-weight:bold;">
                                    <td colspan="3"></td>
									<td class="info-reference_no right"><?= lang("shipping")?> :</td>
									<td class="right"><?= $this->erp->formatMoney($purchase->shipping); ?></td>
								</tr>
			
								<tr style="font-weight:bold; display:none;">
									<td></td>
									<td colspan="2" class="info-reference_no right"><?= lang("total_amount")?> :</td>
									<td></td>
									<td class="right"><?= $this->erp->formatMoney($sub_total); ?></td>
									<td></td>
								</tr>
								-->
								<?php 		
									echo $html;
									

								}
								 
							}else{ ?>
								<tr>
									<td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
								</tr>
						<?php } ?>
                        </tbody>
                        <tfoot>

							<tr>
                                <th colspan="3"></th>
								<th style="color:#0586ff"class="right info-foot"><?= lang("total_quantity") ?>  : </th>
								<th class="right" style="color:#0586ff"><?= $this->erp->formatMoney($total_all_quantity); ?></th>
							</tr>
							<!--
							<tr>
                                <th colspan="3"></th>
								<th class="right info-foot" style="color:#0586ff"><?= lang("total_order_discount"); ?> : </th>
								<th class="right" style="color:#0586ff"><?= "(".$this->erp->formatMoney($total_order_discount).")"; ?></th>
                            </tr>
							
							<tr>
                                <th colspan="3"></th>
								<th class="right info-foot" style="color:#0586ff"><?= lang("total_shipping"); ?> : </th>
								<th class="right" style="color:#0586ff"><?= $this->erp->formatMoney($total_shipping); ?></th>
							</tr>
							
							-->
						</tfoot>
                    </table>
                </div>
				
				<div class=" text-right">
					<div class="dataTables_paginate paging_bootstrap">
						<?= $pagination; ?>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		
        // $('#pdf').click(function (event) {
            // event.preventDefault();
            // window.location.href = "<?=site_url('reports/getSalesReport/pdf/?v=1'.$v)?>";
            // return false;
        // });
        // $('#xls').click(function (event) {
            // event.preventDefault();
            // window.location.href = "<?=site_url('reports/getSalesReport/0/xls/?v=1'.$v)?>";
            // return false;
        // });
		
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>
