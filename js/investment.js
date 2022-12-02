window.onload = switchLoad;

function switchLoad(){
	var emailsw = document.getElementById("email-start");
	var smssw = document.getElementById("sms-start");
	if (emailsw.value.toString()=="1"){
	 emailsw.click();
	}
	if (smssw.value.toString()=="1"){
	   smssw.click();
	}

	emailsw.id = "email-switch";
	smssw.id = "sms-switch";
}

function updatetxtlive(obj){

	if (obj.name == "fileurl"){
		document.getElementById(obj.name).href=obj.value;
	}else{
		if (obj.value.replaceAll(/\s/g,'') != ""){
			var prev = document.getElementById(obj.name).innerHTML = obj.value;
		}else{
			document.getElementById(obj.name).innerHTML = "New Investment Opportunity";
		}
	}
	
}

function minmax(main,target){

	var mwin = document.getElementById(main);
	var win = document.getElementById(target);

	if (win.style.height != "480px"){
		mwin.style.height = "500px";
		win.style.height="480px";
	}
	else{
		mwin.style.height="auto";
		win.style.height="100%";
	}

}

function email_sms_toogle(btn,username){
	var url = "../backend/usercontrol.php"
	if (btn.id.toString() == "email-switch"){
		if (btn.value.toString() == "0"){
				btn.value="1";
		}else{
				btn.value="0";
		}
	$.ajax({
	type: "POST",
	url: url,
	data: {user:username,value:btn.value.toString(),type:0},   /* Passing the text data */
	success:  function(response){
			console.log(response);
		}
	});
	}

	if (btn.id.toString() == "sms-switch"){
		if (btn.value.toString() == "0"){
			btn.value="1";
		}else{
			btn.value="0";
		}

	$.ajax({
	type: "POST",
	url: url,
	data: {user:username,value:btn.value.toString(),type:1},   /* Passing the text data */
	success:  function(response){
			console.log(response);
		}
	});
			}


 }


function changepage(obj,btn){

	if(btn == "edit"){
		document.getElementById("invest-editor").style.display = "grid";
		document.getElementById("invest-viewor").style.display = "none";
		obj.style.background = "var(--primary)";
		obj.style.color = "white";
		obj.style.boxShadow = "none";
		document.getElementsByClassName("preview")[0].style.backgroundColor = "white";
		document.getElementsByClassName("preview")[0].style.color = "var(--primary)";
		document.getElementsByClassName("preview")[0].style.boxShadow = "var(--shadow1)";
	}else{
		document.getElementById("invest-editor").style.display = "none";
		document.getElementById("invest-viewor").style.display = "grid";
		obj.style.background = "var(--primary)";
		obj.style.color = "white";		
		obj.style.boxShadow = "none";
		document.getElementsByClassName("edit")[0].style.backgroundColor = "white";
		document.getElementsByClassName("edit")[0].style.color = "var(--primary)";
		document.getElementsByClassName("edit")[0].style.boxShadow = "var(--shadow1)";
	}

}

function soldPost(obj){
	url = "../backend/post/postControl.php";
	$.ajax({
			url: url,
			type: 'POST',
			data:{pid:obj.id.toString(),soldFunc:'0'},
			success: function(response) {
				snackbar("Post Updated!");
				var myEle = document.getElementById('watermark-'+obj.id);
				
				if(myEle){
					$('#watermark-'+obj.id).remove();
				}else{
					$('#holder-'+obj.id+'').append("<div class='sold-watermark' id='watermark-"+obj.id+"'></div>");
				}
				
			},
			error : function(request, status, error){
				alert(request.responseText);
			}
		  });

}


function deletePost(obj){
	url = "../backend/post/postControl.php";
	$.ajax({
			url: url,
			type: 'POST',
			data:{pid:obj.id.toString(),delfunc:'0'},
			success: function(response) {
				snackbar("Post successfully deleted");
				$('#prev-hold'+obj.id).remove();
			},
			error : function(request, status, error){
				alert(request.responseText);
			}
		  });

}


function add_offer(pid,username,offer){
	url = "../backend/post/postControl.php";
	var offs=offer==0?"50%":(offer==1?"75%":"99%");
	$.confirm({
		title: 'Investment Confirmation',
		boxWidth: '30%',
    	useBootstrap: false,
		content: 'You have selected '+offs+' in this Investment Opportunity!',
		type: 'blue',
		typeAnimated: true,
		buttons: {
			Procced: {
				text: 'Procced',
				btnClass: 'btn-blue',
				action: function(){
					link = $("#img-holder"+pid+"").find('a:first').attr('href');
					$.ajax({
						url: url,
						type: 'POST',
						data:{pid:pid,user:username,offer:offer,plink:link,addoff:0},
						success: function(response) {
							var off=offer==0?"50%":(offer==1?"75%":"99%");
							$("#ibutton-holder"+pid+"").remove();
							$("#img-holder"+pid+"").append('<div align="center" id="iselected-holder'+pid+'" class="iselected-holder">'+
								'<label>You have selected '+off+'</label>'+
								'<button class="cross-btn" onclick=remove_offer("'+pid+'","'+username+'")>'+
								'<i class="fa-solid fa-x"></i>'+
								'</button>'+
							'</div>'+'');
						},
						error : function(request, status, error){
							var off=offer==0?"50%":(offer==1?"75%":"99%");
							$("#ibutton-holder"+pid+"").remove();
							$("#img-holder"+pid+"").append('<div align="center" id="iselected-holder'+pid+'" class="iselected-holder">'+
								'<label>You have selected '+off+'</label>'+
								'<button class="cross-btn" onclick=remove_offer("'+pid+'","'+username+'")>'+
								'<i class="fa-solid fa-x"></i>'+
								'</button>'+
							'</div>'+'');
						}
					  });
				}
			},
			close: function () {
			}
		}
	});
	
}

function remove_offer(pid,username){
	url = "../backend/post/postControl.php?";
	$.ajax({
			url: url,
			type: 'POST',
			data:{deloffer:0,tpid:pid,user:username},
			success: function(response) {
				$("#iselected-holder"+pid+"").remove();
				$("#img-holder"+pid+"").append(''+
				'<div class="ibutton-holder" id="ibutton-holder'+pid+'" align="center">'+
					'<button class="interest-btn" onclick=add_offer("'+pid+'","'+username+'",0)>50%</button>'+
					'<button class="interest-btn" onclick=add_offer("'+pid+'","'+username+'",1)>75%</button>'+
					'<button class="interest-btn" onclick=add_offer("'+pid+'","'+username+'",2)>99%</button>'+
				'</div>')
			},
			error : function(request, status, error){
				alert(error);
			}
		  });
}