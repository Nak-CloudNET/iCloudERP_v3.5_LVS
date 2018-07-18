/* ---------------------- 
 * On Edit 
 * ---------------------- */

if (localStorage.getItem('adcitems')) {
    loadItems();
}

/* ---------------------- 
 * Delete Row Method 
 * ---------------------- */

$(document).on('click', '.addel', function () {
    var parent = $(this).parent().parent();
	parent.remove();
});
var delete_pro_id = "";
$(document).on('click', '.btn_delete', function () {
   delete_pro_id += ($(this).attr("id")+"_");
   $('#store_del_pro_id').val(delete_pro_id);
});

/* ---------------------- 
 * Keep Warehouse when reload
 * ---------------------- */

$('#project').change(function (e) {
	localStorage.setItem('project', $(this).val());
});

if (project = localStorage.getItem('project')) {
	$('#project').val(project);
} 

$('#warehouse').change(function (e) {
	localStorage.setItem('warehouse', $(this).val());
});

if (warehouse = localStorage.getItem('warehouse')) {
	$('#warehouse').val(warehouse);
} 

$('#adjust').change(function (e) {
	localStorage.setItem('adjust', $(this).val());
});

if (adjust = localStorage.getItem('adjust')) {
	$('#adjust').val(adjust);
}   

$('#start_date').change(function (e){
	localStorage.setItem('start_date', $(this).val());
});

if (start_date = localStorage.getItem('start_date')) {
	$('#start_date').val(start_date);
}

$('#end_date').change(function (e){
	localStorage.setItem('end_date', $(this).val());
});

if (end_date = localStorage.getItem('end_date')) {
	$('#end_date').val(end_date);
}

/* ---------------------- 
 * Clear LocalStorage 
 * ---------------------- */

$('#reset').click(function (e) {
	bootbox.confirm(lang.r_u_sure, function (result) {
		if (result) {
			
			if (localStorage.getItem('adcitems')) {
				localStorage.removeItem('adcitems');
			}
			if (localStorage.getItem('warehouse')) {
				localStorage.removeItem('warehouse');
			}
			if (localStorage.getItem('project')) {
				localStorage.removeItem('project');
			}
			if (localStorage.getItem('adjust')) {
				localStorage.removeItem('adjust');
			}
			if (localStorage.getItem('start_date')) {
				localStorage.removeItem('start_date');
			}
			if (localStorage.getItem('end_date')) {
				localStorage.removeItem('end_date');
			}
			$('#modal-loading').show();
			location.reload();
		}
	});
});

function loadItems() {
    if (localStorage.getItem('adcitems')) {
		//============ Return From View ==============//
        count 	= 1;
		//=================== End ====================//
        //$("#UsData tbody").empty();
        adcitems = JSON.parse(localStorage.getItem('adcitems'));
		var no_ = 1;
		$('#warehouse').select2("readonly", true);
		$('#project').select2("readonly", true);
		item_description = '';
		item_reason      = '';
		item_qty_use     = '';
		item_qty_by_unit     = '';
        $.each(adcitems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            adcitems[item_id] = item;
			var product_id = item.item_id, item_code = item.code, item_name = item.name, item_label = item.label, item_cost = item.cost;
			
			var row_no = (new Date).getTime();
			
			var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
			
			
			tr_html = '<td><input type="hidden" value="'+ product_id +'" name="product_id[]"/><input type="hidden" value="'+ item_code +'" name="item_code[]"/><input type="hidden" value="'+ item_name +'" name="name[]"/><input type="hidden" value="'+ item_cost +'" name="cost[]"/>'+ item_label +'</td>';
			
			tr_html += '<td>'+formatMoney(item_cost)+'</td>';
			
			tr_html += '<td><input type="text" class="form-control" name="new_cost[]"/></td>';
			
			tr_html += '<td><input type="text" class="form-control" name="reason[]"/></td>';
			
			tr_html += '<td class="text-center"><i class="fa fa-times tip addel btn_delete" id="' + product_id + '" title="Remove" style="cursor:pointer;"></i></td>';
			
			newTr.html(tr_html);
            newTr.appendTo("#UsData");
			
        });
    }
}

/* -----------------------------
 * Add Using Stock Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
function add_adjust_item(item) {
	
    if (count == 1) {
        adcitems = {};
        if ($('#warehouse').val() ) {
            $('#warehouse').select2("readonly", true);
			$('#project').select2("readonly", true);
        } else {
            bootbox.alert("Please select supplier and warehouse.");
            item = null;
            return;
        }
    }
    if (item == null) {
        return;
    }
    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    if (adcitems[item_id]) {
        adcitems[item_id].row.qty = parseFloat(adcitems[item_id].row.qty) + 1;
    } else {
        adcitems[item_id] = item;
    }
    
    localStorage.setItem('adcitems', JSON.stringify(adcitems));
    loadItems();
    return true;

}


