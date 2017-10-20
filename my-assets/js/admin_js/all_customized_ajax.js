$(document).ready(function(){ 
	
	var baseUrl = "http://inventory.logic-thought.com/";
	//Delete Product 
	$(".deleteProduct").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'product_id='+ id;
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: baseUrl+"cproduct/product_delete",
			data: dataString,
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
	//Delete Supplier 
	$(".deleteSupplier").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'supplier_id='+ id;
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: baseUrl+"csupplier/supplier_delete",
			data: dataString,
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
	//Delete Customer 
	$(".deleteCustomer").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'customer_id='+ id;
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: baseUrl+"ccustomer/customer_delete",
			data: dataString,
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
	//Delete Purchase Item 
	$(".deletePurchase").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'purchase_id='+ id;
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: baseUrl+"cpurchase/purchase_delete",
			data: dataString,
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
	//Delete Invoice Item 
	$(".deleteInvoice").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'invoice_id='+ id;
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: baseUrl+"cinvoice/invoice_delete",
			data: dataString,
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
	//
}); 
	
	function delete_single_row(purchase_dtl_id){
		var baseUrl =$(".baseUrl").val();
		var details_id = 'detail_id='+ purchase_dtl_id;
		var x = confirm("Are You Sure ? After delete,your Software may produce 'DEVIOUS' result");
		if (x==true){
			$.ajax
		   ({
				type: "POST",
				url: baseUrl+"cpurchase/delete_details_single_row",
				data: details_id,
				cache: false,
				success: function(datas)
				{
					location.reload();
				} 
			});
		}
	}
	
	function delete_invoice_single_row(invoice_dtl_id){
		var baseUrl =$(".baseUrl").val();
		var details_id = 'detail_id='+ invoice_dtl_id;
		var x = confirm("Are You Sure ?After delete,your Software may produce 'DEVIOUS' result");
		if (x==true){
			$.ajax
		   ({
				type: "POST",
				url: baseUrl+"cinvoice/invoice_single_row_delete",
				data: details_id,
				cache: false,
				success: function(datas)
				{
					location.reload();
				} 
			});
		}
	}