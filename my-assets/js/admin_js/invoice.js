
	// Add input field for new Invoice 
	var count = 2;
	var limits = 31;
	function addInputField(divName){
		//var param = "$(this).attr(name)";
		 if (count == limits)  {
			  alert("You have reached the limit of adding " + count + " inputs");
		 }
		 else {
			  var newdiv = document.createElement('tr');
			  newdiv.innerHTML ="<td class='span3'><input type='text' name='product_name' onclick='invoice_productList("+count+");' required class='span12 productSelection' placeholder='Type your Product Name' id='product_name' ><input type='hidden' class='autocomplete_hidden_value product_id_"+count+"' name='product_id[]' id='SchoolHiddenId'/></td><td class='span2 text-right'><input type='text' name='model_no[]' id='model_no' class='model_no_"+count+" span12' readonly='readonly'  /></td><td class='span2'><input type='text' name='rate[]' value='0.00' id='product_rate_"+count+"' onkeyup='price_calculate("+count+");' class='customer_rate_"+count+" span12'/></td><td class='span2 text-right'><input type='text' name='quantity[]' onkeyup='price_calculate("+count+"); stockLimit("+count+");'  onchange='stockLimit("+count+")' id='product_quantity_"+count+"' class='span12 product_quantity_"+count+"' /></td><td class='span1 text-right'><span class='span12 qntt_type_"+count+"'></span></td><td class='span2 text-right'><input class='total_price span12 text-right' type='text' name='total_price[]' id='total_price_"+count+"' value='0.00' tabindex='-1' readonly='readonly' /></td><td class='span1'><span class='closeRow closeRow_"+count+"' onclick='close_table_row("+count+");' >&times;</span></td>";
			  document.getElementById(divName).appendChild(newdiv);
			  count++;
		 }
	}

	//Calcucate Invoice Price
	
	function price_calculate(item)
	{
		var quantity = $("#product_quantity_"+item).val();
		var rate = $("#product_rate_"+item).val();
		var total_price = quantity * rate;
		$("#total_price_"+item).val(total_price.toFixed(2));
		//alert(quantity);
		calculateSubTotal();
		//stockLimit(item,quantity);
	}	
		
	function close_table_row(classPortion)
	{
	  $(".closeRow_"+classPortion).parent().parent().remove();
	  calculateSubTotal();
	}
		
	function calculateSubTotal() {
        var sub_total = 0;
        //iterate through each textboxes and add the values
        $(".total_price").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sub_total += parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
		$("#total_amount").val(sub_total.toFixed(2));
		var discount = $("#discount").val();
		var adjustment = $("#adjustment").val();
		var grand_total = (sub_total-((sub_total*discount)/100))-adjustment;
        $("#grandTotal").val(grand_total.toFixed(2));
    }
		
	function calculate_discount()
	{
	  calculateSubTotal();
	}
	
	function calculate_adjustment()
	{
	  calculateSubTotal();
	}
		
	function close_table_row(classPortion)
	{
	  $(".closeRow_"+classPortion).parent().parent().remove();
	  calculateSubTotal();
	}
	
	counter = 1000;
	var limit = 1100;
	
	function editPurchaseInputField(divName){
	
		 if (counter == limit)  {
			  alert("You have reached the limit of adding inputs");
		 }
		 else {
			  var newdiv = document.createElement('tr');
			  newdiv.innerHTML ="<tr><td class='span3'><input type='text' name='product_name' onclick='invoice_productList("+counter+");' required class='span12 productSelection' placeholder='Type your Product Name' id='product_name' ><input type='hidden' class='autocomplete_hidden_value product_id_"+counter+"' name='product_id[]' value='{product_id}' id='SchoolHiddenId'/></td><td class='span2 text-right'> <input type='text' name='model_no[]' id='model_no' class='model_no_"+counter+" span12' readonly='readonly' /></td> <td class='span2'> <input type='text' name='rate[]' id='product_rate_"+counter+"' onkeyup='price_calculate("+counter+");' class='customer_rate_"+counter+" span12' /></td><td class='span1 text-right'><input type='text' name='quantity[]' onkeyup='price_calculate("+counter+");stockLimit("+counter+")' id='product_quantity_"+counter+"' class='span12 product_quantity_"+counter+"' /></td><td class='span2 text-right'><span class='span9 qntt_type_"+counter+"'></span></td><td class='span2 text-right'><input class='total_price span12 text-right' type='text' name='total_price[]' id='total_price_"+counter+"' readonly='readonly' /></td> <td class='span1'> <span class='closeRow closeRow_"+counter+"' onclick='close_table_row("+counter+");' >&times;</span></td> </tr>";
			  document.getElementById(divName).appendChild(newdiv);
			  counter++;
		 }
	}
	// FIND STOCK LIMITs
	function stockLimit(item)
	{
		var quantity = $("#product_quantity_"+item).val();
		var id =$(".product_id_"+item).val();
		var dataString = 'product_id='+ id;
		var base_url = $('.baseUrl').val();
		//alert(id);
		$.ajax
	   ({
			type: "POST",
			url: base_url+"cinvoice/product_stock_check",
			data: dataString,
			cache: false,
			success: function(response)
			{				
				if(quantity > Number(response)){
					var message ="You can Sell maximum "+ response + " Items";
					alert(message);
					$("#product_quantity_"+item).val("");
					
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("Error"+errorThrown);
            }
		});
	}
	// FIND STOCK LIMITs
	function stockLimitForInvoiceEdit(item)
	{
		var exist_qntty= $("#existing_quantity_"+item).val();
		var quantity = $("#product_quantity_"+item).val();
		var id =$(".product_id_"+item).val();
		var dataString = 'product_id='+ id;
		var base_url = $('.baseUrl').val();
		if(quantity > exist_qntty){
		var reqrd_qntty = quantity-exist_qntty;
		//alert(reqrd_qntty);
			$.ajax
		   ({
				type: "POST",
				url: base_url+"cinvoice/product_stock_check",
				data: dataString,
				cache: false,
				success: function(data)
				{
					if(reqrd_qntty > Number(data)){
						var message ="You can Sell maximum "+ data + " Items more";
						alert(message);
						$("#product_quantity_"+item).val(exist_qntty);
					}
				} 
			});
		}
	}
