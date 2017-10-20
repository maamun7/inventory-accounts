<?php

$cache_file = "product.json";
    header('Content-Type: text/javascript; charset=utf8');
?>
var productList = <?php echo file_get_contents($cache_file); ?> ; 

APchange = function(event, ui){
	$(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
}
    function purchase_productList(cName) {
		var model_no_class = 'model_no_'+cName;
		var qntt_type_class = 'qntt_type_'+cName;
		var purchase_rate_class = 'purchase_rate_'+cName;
        $( ".productSelection" ).autocomplete(
		{
            source: productList,
			delay:300,
			focus: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				
				var id=ui.item.value;
				var dataString = 'product_id='+ id;
				var base_url = $('.baseUrl').val();
				//alert(dataString);
				$.ajax
				   ({
						type: "POST",
						url: base_url+"cpurchase/get_product_data",
						data: dataString,
						cache: false,
						success: function(data)
						{
							var obj = jQuery.parseJSON(data);
							$('.'+model_no_class).html(obj.product_model);
							$('.'+qntt_type_class).html(obj.quantity_type);
							$('.'+purchase_rate_class).val(obj.product_price);
							$("#product_quantity_"+cName).val("");	
							//$(".test").html(data);
						} 
					});
				
				$(this).unbind("change");
				return false;
			}
		});
		$( ".productSelection" ).focus(function(){
			$(this).change(APchange);
		
		});
    }


