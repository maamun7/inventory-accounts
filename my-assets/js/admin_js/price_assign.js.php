<?php

$cache_file = "json/product.json";
    header('Content-Type: text/javascript; charset=utf8');
?>
var productList = <?php echo file_get_contents($cache_file); ?> ; 

	APchange = function(event, ui){
		$(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
	}
    function price_assign_productList() {
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
			//	alert(dataString);
				$.ajax
				   ({
						type: "POST",
						url: base_url+"cprice_assign/retrieve_product_data",
						data: dataString,
						cache: false,
						success: function(data)
						{
							var obj = jQuery.parseJSON(data);
							$(".model_no").val(obj.product_model);
							$(".purchase_price").val(obj.purchase_price);
							$(".price").val(obj.product_price);
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
	
	
	