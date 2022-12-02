function changeColumn(obj,username){
	var click = $(obj);
	if (click.val() == null ||click.val() == undefined || click.val() == "" || click.val() == " "){
		alert("Empty!");
	}else{
		url = '../backend/showcolumn.php';
		$.ajax({
			url: url,
			type: 'POST',
			data:{'uid':username,'head':click.val()},
			success: function(response) {
				console.log(response);
				window.open('search.php?search_usr='+username+'','_self');
				
			},
			error : function(request, status, error){
				alert(request.responseText);
			}
		});
	}
}