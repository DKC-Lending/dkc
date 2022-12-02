$("#signupform").submit(function(event) {

	/* stop form from submitting normally */
	event.preventDefault();
  
	/* get the action attribute from the <form action=""> element */
	var $form = $(this),
	  url = $form.attr('action');
  
	/* Send the data using post with element id name and name2*/
	var form = $.post(url, {

	  	type     : $('#role').val(),
		fname    : $('#fname').val(),
		lname    : $('#lname').val(),
		email    : $('#email').val(),
		phone    : $('#phone').val(),
		uname    : $('#uname').val(),
		password : $('#password').val(),
		saddress : $('#saddress').val(),
		state    : $('#state').val(),
		zip      : $('#zip').val()

	});
  
	/* Alerts the results */
	form.done(function(data) {
		UserAdded('User added successfully'); //Custom alert

		var sn = $('#utable').find('tr').length; // Total count of <tr>

		var tbl = $('#role').val() == "Admin"?"0":($('#role').val() == "Borrower"?"1":"2"); // Selected Index of User Type
		$('#utable')    .append('<tr><td>'+
		sn					  +'</td><td>'+
		$('#uname')		.val()+'</td><td>'+
		$('#fname')		.val()+' '+$('#lname').val()+'</td><td>'+
		$('#password')	.val()+'</td><td>'+
		$('#email')		.val()+'</td><td>'+
		$('#phone')		.val()+'</td><td>'+
		$('#saddress')  .val()+'</td><td>'+
		$('#state')     .val()+'</td><td>'+
		$('#zip')		.val()+'</td><td>'+
		$('#role')		.val()+'</td><td>'+
		'<a href="#" id="'+$('#uname').val()+tbl+'e" class="edit-btn" onclick="userEditor(this)"><i class="fa-solid fa-pen"></i></a>'+
		'<a onclick="delUser(this)"  id="'+$('#uname').val()+tbl+'d" class="del-btn"> <i class="fa-solid fa-trash"></i></a></td>'+'</td></tr>');

	
		});

	form.fail(function() {
	   alert("Failed to add Users");
	});
});


function delUser(objs){
    let ask = confirm("Do you want to delete this column?");
    if (ask) {
    	var UId = objs.id.toString().slice(0,-2);
    	var TId = objs.id.toString().slice(-2).slice(-2,1);
    	var url = "../backend/delete.php";
    
    	var form = $.post(url, {
    	uid  : UId,
    	tbl  : TId
    	});
    	
    	form.done(function(data) {
    		UserAdded('User deleted successfully'); //Custom alert
    		window.open("../admin/users.php","_self");
    		
    	});
    
    	form.fail(function() {
    		alert("Failed to Delete Users");
    	 });
}
}