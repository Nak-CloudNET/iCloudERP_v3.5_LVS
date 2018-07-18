<?php
    //$this->erp->print_arrays($stock_item);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("enter_using_stock") ; ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <style type="text/css">
        html, body {
            height: 100%;
			font-family: Time New Roman;
			font-family: Khmer Os;
            background: #FFF;
        }

        body:before, body:after {
            display: none !important;
        }

        .table th {
            text-align: center;
            padding: 5px;
        }

        .table td {
            padding: 4px;
        }
        hr{
            border-color: #333;
            width:100px;
            margin-top: 70px;
        }
		
		.text-center img {
			width:200px;
			height:200px;
		}
    </style>
</head>

<body>
<div class="print_rec" id="wrap" style="width: 90%; margin: 40px auto;">
    <div class="row">
        <div class="col-lg-12">
            <div class="clearfix"></div>
            <div class="row">           
                <?php if ($Settings->system_management == 'project') { ?>                   
					<div class="text-center" style="margin-bottom:20px;">
                        <img src="<?= base_url() . 'assets/uploads/logos/logo.png'?>">
                    </div>
					<div class="col-sm-6 col-xs-6 text-center">
						<h2><?= $info->company; ?></h2>
						<?= $info->address."<br>";?>
						<?= lang('tel')." : ".$info->phone.",  ".lang('email')." : ".$info->email;?>

					</div>
					<div class="col-sm-6 col-xs-6"></div>
                <?php } else { ?>
					<div class="col-sm-6 col-xs-6">
						<div class="text-right" style="margin-bottom:20px;">
							<!-- <img src="<?= base_url() . 'assets/uploads/logos/'. $biller->logo?>"> -->
						</div>
					</div>
					<div class="col-sm-6 col-xs-6">
						<h2></h2>
					</div>
                    
                <?php } ?>
            </div>
			<div class="col-sm-12 col-xs-12">
					<button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                		<i class="fa fa-print"></i> <?= lang('print'); ?>
            		</button>
				</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12 ">
						<center><img style="width: 165px;margin-top:-18px !important;" src="<?= base_url() ?>assets/uploads/logos/header_logo.png"></center>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12 company_addr" style="margin-top:20px 	!important">
					<center>
						<p style="font-size: 12px;">លេខអត្តសញ្ញាណកម្ម អតប (VAT No):&nbsp;K344509877645</p>
						<p style="margin-top:-10px !important;font-size: 12px;">អាសយដ្ឋាន ៖ &nbsp;Phnom Penh</p>
						<p style="margin-top:-10px !important;font-size: 12px;">ទូរស័ព្ទលេខ (Tel):&nbsp;012 585 569</p>
						<p style="margin-top:-10px !important;font-size: 12px;">សារអេឡិចត្រូនិច (E-mail):&nbsp;icloud@icloud-erp.info</p>
					</center>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12 col-xs-12 ">
					<center>
						<h1 style="font-family:Time New Roman;font-size:25px;"><?=lang('using_stock_return_form')?></h1>
					</center>
				</div>
			</div>
			
            <div class="row padding10">
                <div class="col-lg-4 col-sm-4 col-xs-4" style="float: left;font-size:13px;">
                    <b><p style="font-size: 17px;"><?= lang('information');?></p></b>
                    <table>
                    <tr>
                        <td>Project</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td style="font-size:12px !important;"><b><?=$biller->company;?></b></td>
                    </tr>
                    <tr>
                        <td>Authorize Name</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$authorize->username;?></b></td>
                    </tr>
                    <tr>
                        <td>Employee Name</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->first_name ." ".$using_stock->last_name; ?></b></td>
                    </tr>
					<tr>
                        <td>Project Plan</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->plan; ?></b></td>
                    </tr>
					</table>
                 </div>
                <div class="col-lg-3 col-sm-3 col-xs-3" style="text-align:center;margin-top:-20px">
                </div>
                <div class="col-lg-5 col-sm-5 col-xs-5"  style="float: right;font-size:13px">
                    <b><p style="font-size: 17px;"><?= lang('reference');?></p></b>
                    <table>
                    <tr>
                        <td>Reference No</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->reference_no; ?></b></td>
                    </tr>
					 <tr>
                        <td>From Using Reference</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->using_reference_no; ?></b></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$this->erp->hrsd($using_stock->date); ?></b></td>
                    </tr>
                    <tr>
                        <td>Warehouse</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->name; ?></b></td>
                    </tr>
					<tr>
                        <td>Address</td>
                        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td><b><?=$using_stock->address; ?></b></td>
                    </tr>
					</table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row padding10" style="display:none">
                <div class="col-xs-6" style="float: left;">
                   
                </div>
                <div class="col-xs-5" style="float: right;">
                  
                </div>
            </div>

            <div class="clearfix"></div>
 
            <div class="-table-responsive">
                <table class="table table-bordered table-hover table-striped" style="width: 100%;">
                    <thead  style="font-size: 13px;">
                        <tr>
                            <th><?= lang("no"); ?></th>
                            <th><?= lang("products_code"); ?></th>
                            <th><?= lang("products_name"); ?></th>
							<?php if($Settings->product_expiry){ ?>
								<th><?= lang("expiry_date"); ?></th>
							 <?php }?>
                            <th><?= lang("description"); ?></th>                            
                            <th><?= lang("unit"); ?></th>
                            <th><?= lang("quantity"); ?></th>                              
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        <?php
                        $i=1;
                        $total = 0;
                            foreach($stock_item as $si){ ?>
								<tr>
									<td style="text-align:center;"><?= $i; ?></td>
									<td style="text-align:center;"><?= $si->code ?> </td>
									<td><?= $si->product_name ?></td>
									<?php if($Settings->product_expiry){ ?>
										<td class="text-center"><?= $this->erp->hrsd($si->expiry); ?></td>
									<?php } ?>
									<td class="text-center"><?= $si->description; ?></td>
									<td style="text-align:center;"><?= $si->unit_name; ?></td>
									<td style="text-align:center;"><?= $this->erp->formatQuantity($si->qty_by_unit); ?></td>
                                </tr>
							   
							<?php
								$total += $si->qty_by_unit;
                                $i++;
                            }
							?>
							<?php 
                            echo'
                                    <tr>
                                        <td colspan='."6".'>
                                            <p><b>Note:</b>'.'&nbsp;&nbsp;'.strip_tags($using_stock->note).'</p>
                                        </td>
                                    <tr>
                                ';
                        ?>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4  pull-left" style="text-align:center">
                    <hr/>
                    <p><b><?= lang("Signature Stock Manager"); ?></b></p>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4 " style="text-align:center">
                    <hr/>
                    <p><b><?= lang("Stock"); ?></b></p>
                </div>
				 <div class="col-lg-4 col-sm-4 col-xs-4  pull-left" style="text-align:center">
                    <hr/>
                    <p><b><?= lang("Reciever"); ?></b></p>
                </div>
                
            </div>
        </div>
        <div class="col-md-12">
            
        </div>
    </div>
</div>
<div id="mydiv" style="">
    
<div id="wrap" style="width: 90%; margin: 0 auto;">
    <div class="row">
        <div class="col-lg-12 no-print">
                <button type="button" class="btn btn-primary btn-default  pull-left" onclick="window.print();">
                    <i class="fa fa-print"></i> <?= lang('print'); ?>
                </button>&nbsp;&nbsp;
            <a href="<?= site_url('products/view_enter_using_stock'); ?>"><button class="btn btn-warning " ><i class="fa fa-backward "></i>&nbsp;<?= lang("back"); ?></button></a>

        </div>
    </div>
</div>
</div>

<div id="wrap" style="width: 90%; margin:0px auto;">
<div class="col-md-12" style="margin-bottom:20px;">
</div>
</div>
<div></div>
</script>
</body>
</html>