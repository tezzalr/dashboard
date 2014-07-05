$(document).ready(function(){
	//$('.file-inputs').bootstrapFileInput();
	
	$("#formblog").validate({
		rules: {			
			name: "required",
		}
	});
		
	$("#formblog").ajaxForm({	
    	success: function(resp) 
    	{
        	if(resp.status){
        		$("#dataprimblog").html(resp.dtprim);
        		$("#uploadfotoblog").html(resp.foto);
        		$('#photo_profil').bootstrapFileInput();
        		$('#photoblog').bootstrapFileInput();
        		$("#submitblogbtn").hide();
        		$("#submitmsg").html(resp.msg);
        		$(".datablog").prop('disabled', true);
        		$("#tableblogdiv").hide();
        		$("#finishaddblog").show();
        		$("#btntmbhblog").hide();
        	}
    	},
	});     
});

function edit_blog(id){
	$.ajax({
    	type: "GET",
        url: "edit_blog",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#editblogdiv").html(resp.html);
                $("#dataprimblog").html(resp.dtprim);
        		$("#uploadfotoblog").html(resp.foto);
        		$('#photo_profil').bootstrapFileInput();
        		$('#photoblog').bootstrapFileInput();
                $("#btntmbhblog").hide();
                $("#tableblogdiv").hide();
                $("#formaddBlog").hide();
            }else{
                $("#editlookbookdiv").html(resp.html);
            }
        }
    });
}


function closeeditblog(){
	$("#btntmbhblog").show();
	$("#tableblogdiv").load('load_table_blog', function(){
		$("#tableblogdiv").show();
		succeedMessage('Data Blog disimpan');
	});
	$("#editblogdiv").html('');
	$(".message").html("");
	$(".datablog").removeClass("valid");
	$(".datablog").prop('disabled', false);
    $("#formblog")[0].reset();
    $("#submitblogbtn").show();
    $("#dataprimblog").html('');
    $("#uploadfotoblog").html('');
}

function closeaddblog(){
    $("#btntmbhblog").show();
	$("#tableblogdiv").load('load_table_blog', function(){
		$("#tableblogdiv").show();
		succeedMessage('Data Blog disimpan');
	});
    $(".datablog").prop('disabled', false);
    $(".message").html("");
    $(".datablog").removeClass("valid");
    $("#formblog")[0].reset();
    $("#finishaddblog").hide();
    $("#submitblogbtn").show();
    $("#formaddBlog").hide();
    $("#dataprimblog").html('');
    $("#uploadfotoblog").html('');               
}

function delete_blog(id, event){
	bootbox.confirm("Apa anda yakin?", function(confirmed) {
        if(confirmed===true){
            $.ajax({
        		url: "delete_blog",
        		data: {id: id},
        		dataType: 'json',
        		type: "POST",
        		success: function (resp) {
            		if(resp.status == 1){
            			$('#eachblog_'+id).animate({'opacity':'toggle'});
            			//succeedMessage('Blog berhasil dihapus');
            		}
        		}
    		});
        }
    });
}

function show_not_show(id){
	var show;
	if ($('#show_'+id).is(":checked"))
	{show=1;}
	else{show=0;}
	$("#formshow_"+id).ajaxForm({
        dataType: 'json',
        data:{show: show},
        cache: false,
    	success: function(resp) 
    	{
    	}
	}).submit();
}
