	// Add input field for new Invoice 
	var count = 2;
	var limits = 60;
	function addPurchaseInputField(divName){
		//var param = "$(this).attr(name)";
		 if (count == limits)  {
			  alert("You have reached the limit of adding " + count + " inputs");
		 }
		 else {
			  var newdiv = document.createElement('tr');
			  newdiv.innerHTML ="<td class='span4'><input type='text' name='product_name' onclick='purchase_productList("+count+");' required class='span12 productSelection' placeholder='Type your Product Name' id='product_name' ><input type='hidden' class='autocomplete_hidden_value product_id_"+count+"' name='product_id[]' id='SchoolHiddenId'/></td><td class='span1 text-right'><span class='model_no_"+count+"' ></span></td></span><td class='span2 text-right'><input type='text' name='purchase_rate[]' placeholder='Purchase Rate' onkeyup='price_calculate("+count+");' id='purchase_rate_"+count+"' class='span12 purchase_rate_"+count+"' /></td><td class='span2 text-right'><input type='text' name='product_quantity[]' onkeyup='price_calculate("+count+"); stockLimit("+count+")' placeholder='Enter Quantity' required  id='product_quantity_"+count+"' class='span12' /></td><td class='span1 text-right'><span class='qntt_type_"+count+"'></span> </td><td class='span2 text-right'><input class='total_price span12 text-right' type='text' name='total_price[]' id='total_price_"+count+"' value='0.00' readonly='readonly' /></td><td class='span1'><span class='closeRow closeRow_"+count+"' onclick='close_table_row("+count+");' >&times;</span></td>";
			  document.getElementById(divName).appendChild(newdiv);
			  count++;
		 }
	}
	function price_calculate(item)
	{
		var quantity = $("#product_quantity_"+item).val();
		var rate = $("#purchase_rate_"+item).val();
		var total_price = quantity * rate;
		$("#total_price_"+item).val(total_price.toFixed(2));
		//alert(quantity);
		calculateSubTotal();
		// stockLimit(item,quantity);
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
	var limit = 1040;
	
	function editPurchaseInputField(divName){
	
		 if (counter == limit)  {
			  alert("You have reached the limit of adding inputs");
		 }
		 else {
			  var newdiv = document.createElement('tr');
			  newdiv.innerHTML ="<td class='span4'><input type='text' name='product_name' onclick='purchase_productList("+counter+");' required class='span12 productSelection' placeholder='Type your Product Name' id='product_name' ><input type='hidden' class='autocomplete_hidden_value product_id_"+counter+"' name='product_id[]' id='SchoolHiddenId'/></td><td class='span1 text-right'><span class='model_no_"+counter+"' ></span></td></span><td class='span2 text-right'><input type='text' name='purchase_rate[]' placeholder='Purchase Rate' onkeyup='price_calculate("+counter+");' id='purchase_rate_"+counter+"' class='span12 purchase_rate_"+counter+"' /></td><td class='span2 text-right'><input type='text' name='product_quantity[]' onkeyup='price_calculate("+counter+"); stockLimit("+counter+")' placeholder='Enter Quantity' required  id='product_quantity_"+counter+"' class='span12' /></td><td class='span1 text-right'><span class='qntt_type_"+counter+"'></span> </td><td class='span2 text-right'><input class='total_price span12 text-right' type='text' name='total_price[]' id='total_price_"+counter+"' value='0.00' readonly='readonly' /></td><td class='span1'><span class='closeRow closeRow_"+counter+"' onclick='close_table_row("+counter+");' >&times;</span></td>";
			  document.getElementById(divName).appendChild(newdiv);
			  counter++;
		 }
	}
	