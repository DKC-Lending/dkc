function deleteNotification(id){
	$.ajax({
		url:  "../backend/notification/deletenotification.php",
		type: 'POST',
		data:{'uid':id},
		success: function(response) {
			if (response == '1'){
				window.open('notification.php',"_self");
			}else{
				alert("Error While Sending!");
			}
			
		},
		error : function(request, status, error){
			alert(request.responseText);
		}
	});
}