$(document).ready(function(){
	//var sc = ship_cost();
	//$('#tablecocarttddiv').load('load_co_cart/'+sc, function(){});
});

function delete_co_cart_item(id, event){
	bootbox.confirm("Apa anda yakin ?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: config.base+"user/delete_cart_item",
        		data: {cart_item_id: id},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#eachcocartitemtr_'+id).animate({'opacity':'toggle'});
            			var sc = $('#adr_ship').val();
            			$('#tablecocarttddiv').load('load_co_cart/'+sc, function(){
        				});
            		}
        		}
    		});
        }
    });
}

function change_ship_cost(id){
	//var sc = ship_cost();
	$('#tablecocarttddiv').load(config.base+'cart/load_co_cart/'+id, function(){				
    });
}

function ship_cost(){
	var selectedVal = "";
	var selected = $("input[type='radio'][name='pengiriman']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.data('cost');
	}
	return selectedVal
}

function edt_adr(form,action){
	var adr_id = $('#adr_'+form).val();
	$.ajax({
    	type: "GET",
        url: "edit_address",
        data: {form: form, action: action, adr_id: adr_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#edit_address").html(resp.html);
            }else{
                $("#edit_address").html(resp.html);
            }
        }
    });
}

function closeeditadr(){
	$("#edit_address").html('');
}