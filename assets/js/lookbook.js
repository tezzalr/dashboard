$(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	//$('.file-inputs').bootstrapFileInput();
	
	$("#formlookbook").validate({
		rules: {			
			name: "required",
		}
	});
		
	$("#formlookbook").ajaxForm({	
    	success: function(resp) 
    	{
        	if(resp.status){
        		$("#uploadfotolookbook").show();
        		$("#submitlookbookbtn").hide();
        		$("#lb_hidden_id_new").val(resp.id_lb);
        		$("#submitmsg").html(resp.msg);
        		$(".datalookbook").prop('disabled', true);
        		$("#tablelookbookdiv").hide();
        		$("#finishaddlb").show();
        		$("#btntmbhlb").hide();
        	}
    	},
	});       	     
});

function uploadimagelookbook(form){
	$("#newphoto_lb_"+form).ajaxForm({
        dataType: 'json',
        cache: false,
		beforeSend: function() {
        	$("#progress_"+form).show();
        	//clear everything
        	$("#bar_"+form).width('0%');
        	$("#message_"+form).html("");
        	$("#percent_"+form).html("0%");
    	},
    	uploadProgress: function(event, position, total, percentComplete) 
    	{
        	$("#bar_"+form).width(percentComplete+'%');
        	$("#percent_"+form).html(percentComplete+'%');
 			if(percentComplete==100){
 				$("#message_"+form).html("Menyimpan gambar ...");
 			}
    	},
    	success: function(resp) 
    	{
        	$("#progress_"+form).hide();
        	$("#message_"+form).html("");
        	$("#table_photolb_"+form).prepend(resp.newphotolb);
        	//$('#change_plb_'+resp.newplbid).bootstrapFileInput();
    	},
    	error: function()
    	{
        	$("#message_"+form).html("<font color='red'> ERROR: unable to upload files</font>");
 
    	}
	}).submit();
}

function edit_lookbook(id){
	$.ajax({
    	type: "GET",
        url: "../edit_lookbook",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#editlookbookdiv").html(resp.html);
                $('#photolb_edit').bootstrapFileInput();
                $("#btntmbhlb").hide();
                $("#tablelookbookdiv").hide();
                $("#formaddLookbook").hide();
            }else{
                $("#editlookbookdiv").html(resp.html);
            }
        }
    });
}

function photo_lb_up(id,lb_id){
	$.ajax({
    	type: "GET",
        url: "../photo_lb_up",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                if($("#table_photolb_edit").is(":visible")){
                	$("#table_photolb_edit").load('../load_photo_lb/'+lb_id);
                }else{
                	$("#table_photolb_new").load('../load_photo_lb/'+lb_id);
                }
            }else{
                $("#editlookbookdiv").html(resp.html);
            }
        }
    });
}

function photo_lb_down(id,lb_id){
	$.ajax({
    	type: "GET",
        url: "../photo_lb_down",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                if($("#table_photolb_edit").is(":visible")){
                	$("#table_photolb_edit").load('../load_photo_lb/'+lb_id);
                }else{
                	$("#table_photolb_new").load('../load_photo_lb/'+lb_id);
                }
            }else{
                $("#editlookbookdiv").html(resp.html);
            }
        }
    });
}

function closeeditlb(gender){
	$("#btntmbhlb").show();
	$("#tablelookbookdiv").load('../load_table_lookbook/'+gender, function(){
		$("#tablelookbookdiv").show();
	});
	$("#editlookbookdiv").html('');
	$(".message").html("");
	$(".datalookbook").removeClass("valid");
	$(".datalookbook").prop('disabled', false);
	$("#uploadfotolookbook").load('../load_form_addfotolb/'+gender, function(){
    	$('#photolb_new').bootstrapFileInput();
    	$("#uploadfotolookbook").hide();
    	succeedMessage('Data Lookbook disimpan');
    });
    $("#formlookbook")[0].reset();
    $("#submitlookbookbtn").show();
}

function closeaddlb(gender){
	
    $("#btntmbhlb").show();
	$("#tablelookbookdiv").load('../load_table_lookbook/'+gender, function(){
		$("#tablelookbookdiv").show();
	});
    $(".datalookbook").prop('disabled', false);
    $(".message").html("");
    $(".datalookbook").removeClass("valid");
    $("#uploadfotolookbook").load('../load_form_addfotolb/'+gender, function(){
    	$('#photolb_new').bootstrapFileInput();
    	$("#uploadfotolookbook").hide();
    	succeedMessage('Data Lookbook disimpan');
    });
    $("#formlookbook")[0].reset();
    $("#finishaddlb").hide();
    $("#submitlookbookbtn").show();
    $("#formaddLookbook").hide();
                
}

function delete_lookbook(id, event, gender){
	bootbox.confirm("Apa anda yakin?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: "../delete_lookbook",
        		data: {id: id, gender: gender},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#eachlb_'+id).animate({'opacity':'toggle'});
            			//succeedMessage('Lookbook berhasil dihapus');
            		}
        		}
    		});
        }
    });
}

function delete_lookbook_photo(id, event){
	bootbox.confirm("Apa anda yakin?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: "../delete_lookbook_photo",
        		data: {id: id},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#phtlb_'+id).animate({'opacity':'toggle'});
            			succeedMessage('Foto berhasil dihapus');
            		}
        		}
    		});
        }
    });
}
