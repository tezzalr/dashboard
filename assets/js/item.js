$(document).ready(function(){
		var response;
        $.validator.addMethod("notexistcode", function(value, element) {
      		$.ajax({
            	type: "POST",
            	url: config.base+"admin/check_existing_code",
            	data: "code="+value,
            	dataType:"json",
            	async: false,
            	success: function(result)
            	{
                	if(result.value===true){response = true;}else if(result.value===false){response=false;}
            	}
            })
      		return response;
      	}, "The Code has already been used");
      	
		itemvalidate('#formbarang');
		
		$("#formbarang").ajaxForm({	
    		success: function(resp) 
    		{
        		$("#uploadfotobarang").show();
        		$("#submitbarangbtn").hide();
        		$(".hiddencode").val($("#code").val());
        		$(".hiddenid").val(resp.id_item);
        		$("#submitmsg").html(resp.msg);
        		$(".databarang").prop('disabled', true);
    		},
		});       
		     
	});

function closeedit(){
	$('#editbarang').html('');
	$("#coltabbarang").removeClass("col-md-8");
    $("#coltabbarang").addClass("col-md-12");
    
}
	
function itemvalidate(form){
	$(form).validate({
		rules: {			
			code: {
				required: true,
				notexistcode: true
			},
			name: "required",
			price: {
				required: true,
				number: true
			},
			size_1: "number",size_2: "number",size_3: "number",size_4: "number",size_5: "number",size_6: "number",size_7: "number",size_8: "number",size_9: "number",size_10: "number",size_11: "number"
		}
	});
}

function changesizeinput(form){
	var kind = $('#kind_'+form).val();
	$.ajax({
    type: "GET",
    url: config.base+"admin/change_size_input",
    data: {kind: kind},
    dataType: 'json',
    cache: false,
    success: function(resp){
        if(resp.status==1){
            $("#sizeinput_"+form).html(resp.html);
        }else{
            $("#sizeinput_"+form).html(resp.html);
        }
    }
    });
}
	
function uploadimageajax(formid){
	$("#imageform_"+formid).ajaxForm({ 
		beforeSend: function() {
        	$("#progress_"+formid).show();
        	//clear everything
        	$("#bar_"+formid).width('0%');
        	$("#message_"+formid).html("");
        	$("#percent_"+formid).html("0%");
    	},
    	uploadProgress: function(event, position, total, percentComplete) 
    	{
        	$("#bar_"+formid).width(percentComplete+'%');
        	$("#percent_"+formid).html(percentComplete+'%');
 			if(percentComplete==100){
 				$("#message_"+formid).html("Menyimpan gambar ...");
 			}
    	},
    	success: function(resp) 
    	{
        	$("#progress_"+formid).hide();
        	$("#message_"+formid).html("<img src="+resp.tny+">");
    	},
    	error: function()
    	{
        	$("#message_"+formid).html("<font color='red'> ERROR: unable to upload files</font>");
 
    	}
	}).submit();
}


	
function resetformitem(){
	$("#formbarang")[0].reset();
	resetinputfile("photoimg_dpn");
	resetinputfile("photoimg_blk");
	resetinputfile("photoimg_smp");
	$("#uploadfotobarang").hide();
    $("#submitbarangbtn").show();
    $(".hiddencode").val('');
    $(".databarang").prop('disabled', false);
    $(".message").html("");
    $(".databarang").removeClass("valid");
    $("#formaddItem").hide();
    changesizeinput('add');
    succeedMessage('Data berhasil ditambahkan');
	load_all_barang();
}
	
function resetinputfile(id){
	var oldInput = document.getElementById(id); 
     
    var newInput = document.createElement("input"); 
     
    newInput.type = "file"; 
    newInput.id = oldInput.id; 
    newInput.name = oldInput.name; 
    newInput.className = oldInput.className; 
    newInput.style.cssText = oldInput.style.cssText; 
    	// copy any other relevant attributes 
     
    oldInput.parentNode.replaceChild(newInput, oldInput); 
}
	
function load_all_barang(){
	var gender = $("#filter_gender").val();
	var kind = $("#filter_kind").val();
	$('#tablebarangtddiv').load(config.base+'admin/load_all_barang/'+gender+"/"+kind);
}
	
function order_by(atr){
	var gender = $("#filter_gender").val();
	var kind = $("#filter_kind").val();
	var how = $('#nameheadtable').attr('class');
	$('#tablebarangtddiv').load(config.base+'admin/order_by/'+gender+'/'+kind+'/'+atr+'/'+how);
	if (how == 'asc'){
		$("#nameheadtable").removeClass("asc");
		$("#nameheadtable").addClass("desc");
	}else{
		$("#nameheadtable").removeClass("desc");
		$("#nameheadtable").addClass("asc");
	}
}
	
function edit_barang(id,kind){
	$.ajax({
    	type: "GET",
        url: config.base+"admin/edit_barang",
        data: {id: id, kind: kind},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
            	$("#coltabbarang").removeClass("col-md-12");
                $("#coltabbarang").addClass("col-md-8");
                $("#editbarang").html(resp.html);
            }else{
                $("#editbarang").html(resp.html);
            }
        }
    });
}

function uploadimageajaxedit(formid){
	$("#imageformedit_"+formid).ajaxForm({ 
    	beforeSend: function() 
    	{
        	$("#progressedit_"+formid).show();
        	//clear everything
        	$("#baredit_"+formid).width('0%');
        	$("#messageedit_"+formid).html("");
        	$("#percentedit_"+formid).html("0%");
    	},
    	uploadProgress: function(event, position, total, percentComplete) 
    	{
        	$("#baredit_"+formid).width(percentComplete+'%');
        	$("#percentedit_"+formid).html(percentComplete+'%');
 			if(percentComplete==100){
 				$("#messageedit_"+formid).html("Menyimpan gambar ...");
 			}
    	},
    	success: function(resp) 
    	{
        	$("#progressedit_"+formid).hide();
        	$("#messageedit_"+formid).html("<img src="+resp.tny+">");
        	$("#"+formid+"_shw").html("<img width='30%' src="+resp.med+">");
    	},
    	error: function()
    	{
        	$("#messageedit_"+formid).html("<font color='red'> ERROR: unable to upload files</font>");
 
    	}
	}).submit();
}
	
function delete_barang(id, event){
	bootbox.confirm("Apa anda yakin ?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: config.base+"admin/delete_barang",
        		data: {item_id: id},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#eachitemtr_'+id).animate({'opacity':'toggle'});
            			//succeedMessage('Data berhasil dihapus');
            			$("#editbarang").html('');
            			$("#coltabbarang").removeClass("col-md-8");
   	 					$("#coltabbarang").addClass("col-md-12");
            			//$('#eachitemtr_'+id).remove();
            		}
        		}
    		});
        }
    });
}
	
function search_by(){
	var searchbox = $('#search_barang').val();
	var gender = $("#filter_gender").val();
	var kind = $("#filter_kind").val();
	var dataString = searchbox;
	if(searchbox!=''){
		$.ajax({
            type: "GET",
            url: config.base+"admin/search_barang/"+gender+"/"+kind,
            data: {query: dataString},
        	dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $("#tablebarangtddiv").html(resp.html);
                }else{
                    $("#tablebarangtddiv").html('');
                }
            }});
	}else{
		load_all_barang();
	}
		
}

function item_filter(){
	load_all_barang();
	var gender = $("#filter_gender").val();
	var kind = $("#filter_kind").val();
	$("#spanfiltergender").html('Gender: '+gender);
	$("#spanfilterkind").html('Jenis: '+kind);
}