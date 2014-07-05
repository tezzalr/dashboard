$(document).ready(function(){
	
});

function delete_purchase(id, cart_id, event){
	bootbox.confirm("Apa anda yakin?", function(confirmed) {
		if(confirmed===true){
			$.ajax({
				url: "delete_purchase",
				data: {id: id, cart_id: cart_id},
				dataType: 'json',
				type: "POST",
				success: function (resp) {
					if(resp.status == 1){
						$('#eachpurchasetr_'+id).animate({'opacity':'toggle'});
						succeedMessage('Pesanan berhasil dihapus');
					}
				}
			});
		}
	});
}

function delete_confirmation(id, prc_id, event){
	bootbox.confirm("Apa anda yakin?", function(confirmed) {
		if(confirmed===true){
			$.ajax({
				url: "delete_confirmation",
				data: {id: id},
				dataType: 'json',
				type: "POST",
				success: function (resp) {
					if(resp.status == 1){
						$('#confrm_info_'+prc_id).animate({'opacity':'toggle'});
						$('#conf_stat_td').html('');
						//succeedMessage('Konfirmasi berhasil dihapus');
						$("#eachpurchasetr_"+prc_id).addClass('success');
    					window.setTimeout( function(){$("#eachpurchasetr_"+prc_id).removeClass('success');}, 2500);
					}
				}
			});
		}
	});
}
	
function search_by(){
	var searchbox = $('#search_purchase').val();
	var status = $("#filter_status").val();
	var dataString = searchbox;
	if(searchbox!=''){
		$.ajax({
            type: "GET",
            url: config.base+"admin/search_purchase/"+status,
            data: {query: dataString},
        	dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $("#tablepurchasetddiv").html(resp.html);
                }else{
                    $("#tablepurchasetddiv").html('');
                }
            }});
	}else{
		load_all_prc();
	}
		
}

function order_by(atr){
	var kind = $('#nameheadtable').attr('class');
	var status = $("#filter_status").val();
	$('#tablepurchasetddiv').load(config.base+'admin/order_purchase_by/'+status+'/'+atr+'/'+kind);
	if (kind == 'asc'){
		$("#nameheadtable").removeClass("asc");
		$("#nameheadtable").addClass("desc");
	}else{
		$("#nameheadtable").removeClass("desc");
		$("#nameheadtable").addClass("asc");
	}
}

function load_all_prc(){
	var status = $("#filter_status").val();
	$('#tablepurchasetddiv').load(config.base+'admin/load_all_purchase/'+status+'/');
}

function load_all_prc_uid(uid,id){
	var status = $("#filter_status").val();
	$('#tablepurchasetddiv').load(config.base+'admin/load_all_purchase/'+status+'/'+uid, function(){
		$("#eachpurchasetr_"+id).addClass('success');
    	window.setTimeout( function(){$("#eachpurchasetr_"+id).removeClass('success');}, 2500);
	});
}

function prc_filter(){
	load_all_prc();
	var status = $("#filter_status").val(); if(status=="JthTmp"){status="Jatuh Tempo";}else if(status=="SdhKnfrm"){status="Sudah Konfirmasi";}
	else if(status=="BlmKrm"){status="Barang Belum Dikirim";}
	$("#spanfilterstatus").html('Status: '+status);
}