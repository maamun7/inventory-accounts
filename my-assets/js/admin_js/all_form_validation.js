$(document).ready(function(){    
	$("#purchase").validate({  
		rules:{
			supplier_name:{required:true},
			job_description:{required:true},
			ship_to:{required:true},
			purchase_date:{required:true},
			authorised_by_id:{required:true},
			requested_by_id:{required:true},
			terms_and_condi:{required:true},
			product_name:{required:true},
			product_model:{required:true},
			purchase_rate:{required:true},
			product_quantity:{required:true}
		},
		messages:{
			supplier_name:{required:"Supplier Name required"},
			job_description:{required:"Job_description Required"},
			ship_to:{required:"Ship to Required"},
			purchase_date:{required:"Date Required"},
			authorised_by_id:{required:"Authorised by Required"},
			requested_by_id:{required:"Requested by Required"},
			terms_and_condi:{required:"Terms and Conditions Required"},
			product_name:{required:"Product Name Required"},
			product_model:{required:"Product Model Required"},
			purchase_rate:{required:"Unit Price Required"},
			product_quantity:{required:"Quantity Required"}
		},
		invalidHandler: function(form, validator) { 
			var errors = validator.numberOfInvalids();
			if (errors){  
				var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';    
				$("div.error span").html(message); 
				$("div.error").show();        
			}else {
				$("div.error").hide();
			}
		}           
	});
}); 

$(document).ready(function(){    
	$("#supplier").validate({  
		rules:{
			supplier_name:{required:true},
			mobile:{required:true},
			address:{required:true}
		},
		messages:{
			supplier_name:{required:"Supplier Name required"},
			mobile:{required:"Supplier Mobile Required"},
			address:{required:"Supplier Address Required"}
		},
		invalidHandler: function(form, validator) { 
			var errors = validator.numberOfInvalids();
			if (errors){  
				var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';    
				$("div.error span").html(message); 
				$("div.error").show();        
			}else {
				$("div.error").hide();
			}
		}           
	});
});
 $(document).ready(function(){    
	$("#auth_person").validate({  
		rules:{
			name:{required:true},
			designation:{required:true},
			mobile_no:{required:true}
		},
		messages:{
			name:{required:"Name is Required"},
			designation:{required:"Designation is Required"},
			mobile_no:{required:"Mobile Number is Required"}
		},
		invalidHandler: function(form, validator) { 
			var errors = validator.numberOfInvalids();
			if (errors){  
				var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';    
				$("div.error span").html(message); 
				$("div.error").show();        
			}else {
				$("div.error").hide();
			}
		}           
	});
}); 

$(document).ready(function(){    
	$("#invoice").validate({  
		rules:{
			created_on:{required:true},
			authorised_by_id:{required:true},
			customer_name:{required:true},
			terms_and_condi:{required:true},
			product_name:{required:true},
			rate:{required:true},
			quantity:{required:true}
		},
		messages:{
			created_on:{required:"Date is Required"},
			authorised_by_id:{required:"Authorised by Required"},
			customer_name:{required:"Customer Name Required"},
			terms_and_condi:{required:"Terms and Conditions Required"},
			product_name:{required:"Product Name Required"},
			rate:{required:"Unit Price Required"},
			quantity:{required:"Quantity Required"}
		},
		invalidHandler: function(form, validator) { 
			var errors = validator.numberOfInvalids();
			if (errors){  
				var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';    
				$("div.error span").html(message); 
				$("div.error").show();        
			}else {
				$("div.error").hide();
			}
		}           
	});
}); 