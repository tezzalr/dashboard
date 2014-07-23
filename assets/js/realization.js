function change_table_view(id){
	$.ajax({
    	type: "GET",
        url: config.base+"anchor/realization_table_view",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#content_realisasi").html(resp.html);
            }else{}
        }
    });
}

function change_graph_view(id){
	$.ajax({
    	type: "GET",
        url: config.base+"anchor/realization_graph_view",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#content_realisasi").html(resp.html);
            }else{}
        }
    });
}