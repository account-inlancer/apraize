var is_first_time_load = true;
jQuery(document).ready(function(){

	stock_tbl = jQuery('#stock_tbl').dataTable({
        							"processing": true,
        							"serverSide": true,
									"iDisplayLength": 50,
						         "ajaxSource": APPLICATION_URL+"dashboard/stocks/dt_list",
						         "aoColumns": [
						            { "bSortable": false },
						            { "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
						            { "bSortable": false },						            
						       	],
						       	"order":[['0','desc']],
						      	"sDom": "<'row'<'col-sm-9 col-xs-9'l><'col-sm-3 col-xs-3'f>r>t<'row'<'col-sm-5 hidden-xs paging-class'i><'col-sm-7 col-xs-12 clearfix'p>>",
						       	
						       	'fnDrawCallback' : function(){
						       		jQuery('th:first-child').removeClass('sorting_desc');
						       		jQuery('th:first-child').removeClass('sorting');
						       		if(is_first_time_load){

						       			jQuery('#stock_tbl_length select').addClass("form-control");
						       			jQuery('#stock_tbl_filter input').addClass("form-control");
						       			is_first_time_load = false;
						       		}	
						       	},
    	});

});



 
