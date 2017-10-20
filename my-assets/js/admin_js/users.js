var baseUrl = "http://localhost/bcb/";
$(document).ready(function(){    
	$(".deleteCategory").click(function()
	{	
		var id=$(this).attr('name');
		var dataString = 'cat_id='+ id;
		var x = confirm("Are You Sure ?");	
		if (x==true){
			$.ajax
		   ({
				type: "POST",
				url: baseUrl+"admin/categories/delete_category",
				data: dataString,
				cache: false,
				success: function(datas)
				{
					location.reload();
					//$(".test").html(datas);
				} 
			});
		}
	});
});

	$(document).ready(function(){ 
		$("#user").validate({  
			rules:{
				first_name:{required:true},
				last_name:{required:true},
				designation:{required:true},
				email:{required:true},
				password:{required:true},
				role_id:{required:true}
			},
			messages:{
				first_name:{required:"Enter First Name"},
				last_name:{required:"Enter Last Name"},
				designation:{required:"Enter Designation Name"},
				email:{required:"Enter Email Name"},
				password:{required:"Enter Password"},
				role_id:{required:"Select User Role"}
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