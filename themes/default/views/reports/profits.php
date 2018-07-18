<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
			<a href="#" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="sendEmail();">
				<i class="fa fa-send"></i> <?= lang('Send'); ?>
			</a>
            <h4 class="modal-title" id="myModalLabel"><?= lang('day_profit').' ('.$this->erp->hrsd($date).')'; ?></h4>
        </div>
        <div class="modal-body">
            <p><?= lang('unit_and_net_tip'); ?></p>
            <div class="table-responsive">
            <table width="100%" class="stable">
                <tr>
                    <td style="border-bottom: 1px solid #EEE;">
						<h4><?= lang('sales_revenue'); ?>:</h4>
					</td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;">
						<h4><span>(<?= $this->erp->formatQuantity($revenues->total_items); ?>)<?= $this->erp->formatMoney($revenues->total); ?></span></h4>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;">
						<h4><?= lang('order_discount'); ?>:</h4>
					</td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;">
						<h4>
                            <span><?php $discount = $refunds ? $discount : 0; echo '('.$this->erp->formatQuantity($count_dis->count_id).')'.$this->erp->formatMoney($discount); ?></span>
                        </h4>
					</td>
                </tr>
				<tr>
                    <td style="border-bottom: 1px solid #DDD;">
						<h4><?= lang('shipping'); ?>:</h4>
					</td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;">
						<h4>
                            <span><?= '('.$this->erp->formatMoney($count_ship->count_id).')';?><?=$this->erp->formatMoney($shipping); ?></span>
                        </h4>
					</td>
                </tr>
				<tr style="display:none;">
                    <td>
						<h4><?= lang('order_tax'); ?>:</h4>
					</td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;">
						<h4>
                            <span><?= $this->erp->formatMoney($order_tax); ?></span>
                        </h4>
					</td>
                </tr>
				<tr>
                    <td style="border-bottom: 1px solid #DDD;"><strong><h4><?= lang('sales_refund'); ?>:</h4></strong></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
						<span>(<?= $this->erp->formatQuantity($refunds->quantity); ?>)<?= $this->erp->formatMoney($refunds->paid); ?></span></h4>
                    </td>
                </tr>
				
				
				<?php if($Admin || $Owner){ ?>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('products_cost'); ?>:</h4></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h4>
                        <span>(<?= $this->erp->formatQuantity($costing->total_items); ?>)<?= $this->erp->formatMoney($costing->cost); ?></span>
                    </h4></td>
                </tr>
                <!--
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('products_return'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                            <span><?php $expense = $expenses ? $expenses->total : 0; echo $this->erp->formatMoney($expense); ?></span>
                        </h4></td>
                </tr>
                -->
				<tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('expenses'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                            <span><?php echo '('.$this->erp->formatQuantity($expenses->count_ex).')'. $expense = $expenses ? $this->erp->formatMoney($expenses->total) : 0; ?></span>
                        </h4></td>
                </tr>
                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><strong><?= lang('profit'); ?></strong>:</h4>
                    </td>
                    <td style="text-align:right;"><h4>
                        <span><strong><?= $this->erp->formatMoney($revenues->total - $costing->cost - $discount + $shipping + $order_tax - $expense); ?></strong></span>
                        </h4></td>
                </tr>
				<?php } ?>
            </table>
            </div>
        </div>
    </div>

</div>

<script>

	function sendEmail(){
	var email = prompt("<?= lang("email_address"); ?>", "<?= isset($customer->email)?$customer->email:''; ?>");
	if (email != null) {
		$.ajax({
			type: "post",
			url: "<?= site_url('reports/email_receipt') ?>",
			data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email},
			dataType: "json",
			success: function (data) {
				alert(data.msg);
			},
			error: function () {
				alert('<?= lang('ajax_request_failed'); ?>');
				return false;
			}
		});
	}
	return false;
	}
</script>
