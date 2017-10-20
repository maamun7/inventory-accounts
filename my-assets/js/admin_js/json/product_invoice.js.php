<?php

$cache_file = "product.json";
    header('Content-Type: text/javascript; charset=utf8');
?>
var productList = <?php echo file_get_contents($cache_file); ?> ; 

APchange = function(event, ui){
	$(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
}
    function invoice_productList(cName) {
	
		var model_no_class = 'model_no_'+cName;
		var qntt_type_class = 'qntt_type_'+cName;
		var customer_rate_class = 'customer_rate_'+cName;
		
		var customer_name = $(".customerSelection").val();
		if(customer_name.length ==0){
			alert("You have to select Customer Name First");
			$(this).val("");
		}
		
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
				
				var product_id=ui.item.value;
				var customer_id = $(".customer_hidden_value").val();
				var dataString = 'all_ids='+ product_id +'='+customer_id;
				var base_url = $('.baseUrl').val();
				//alert(dataString);
				$.ajax
				   ({
						type: "POST",
						url: base_url+"cinvoice/retrieve_product_data",
						data: dataString,
						cache: false,
						beforeSend: function(){
							$('.addItemButtonVisibility').prop('disabled', true);
							$('.saveItemButtonVisibility').prop('disabled', true);
						},
						complete: function(){
							$('.addItemButtonVisibility').prop('disabled', false);
							$('.saveItemButtonVisibility').prop('disabled', false);
						},
						success: function(data)
						{
							var obj = jQuery.parseJSON(data);
							$('.'+model_no_class).val(obj.product_model);
							$('.'+qntt_type_class).html(obj.quantity_type);
							$('.'+customer_rate_class).val(obj.product_price);
							$("#product_quantity_"+cName).val("");
							//This Function Stay on others.js page
							//quantity_calculate(cName);
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


