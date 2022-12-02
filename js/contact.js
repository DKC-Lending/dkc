$("#contactform").submit(function(event) {
	console.log({
		'user'   : $('#sessionuser').val(),
		'name'   : $('#name').val(),
		'email'  : $('#email').val(),
		'msg'    : $('#message').val()
});
	/* stop form from submitting normally */
	event.preventDefault();
  

	$.ajax({
		url:  "../backend/contact/contactHandler.php",
		type: 'POST',
		data:{
			'user'   : $('#sessionuser').val(),
			'name'   : $('#name').val(),
			'email'  : $('#email').val(),
			'msg'    : $('#message').val()
	},
		success: function(response) {
			if (response == '1'){
				UserAdded('Response send to DKC Lending');
				$("#contactform").trigger("reset");
			}else{
				alert("Error While Sending!");
			}
			
		},
		error : function(request, status, error){
			alert(request.responseText);
		}
	});
});


function deleteResponse(uid){
	if(confirm("Are you sure want to delete?")){
		$.ajax({
			url:  "../backend/contact/deleteResponse.php",
			type: 'POST',
			data:{'uid':uid},
			success: function(response) {
				if (response == '1'){
					window.open('contact.php',"_self");
				}else{
					alert("Error While Sending!");
				}
				
			},
			error : function(request, status, error){
				alert(request.responseText);
			}
		});
	}
	
}