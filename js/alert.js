var timerreset;

function UserAdded(text) {
    $('body').prepend("" +
        "<div id='usernoti'>" +
        "<center>" +
        "<section>" +
        "<img src='../img/misc/complete.png' height='50px'>" +
        "</section>" +
        "<label class='alert-label'>" + text + "</label>" +
        "</center>" +
        "</div>");

    timerreset = setInterval(removeNotification, 2000);
}

function removeNotification() {
    $("#usernoti").remove();
    clearInterval(timerreset);

}

function userEditor(objs, fname, lname, email, phone, username, password, saddress, state, zip) {
    var UId = objs.id.toString().slice(0, -2);
    var TId = objs.id.toString().slice(-2).slice(-2, 1);
    $("body").prepend("<div class='userUpdate' id='updatePanel'>" +
        "<div class='crossbutton'>" +
        "<a href='' class='cross-btn'>" +
        "<i class='fa-solid fa-circle-xmark'></i>" +
        "</a>" +
        "</div>" +
        "<section><h3>User Editor</h3>" +
        "<div><form method='POST' action='../backend/update.php'>" +
        "<input type='hidden' name='uid' value='" + UId + "'>" +
        "<input type='hidden' name='tbl' value='" + TId + "'>" +
        "<p>First name* 	<input type='text' name='fname' class='user-input' value='" + fname + "' required='true'></p>" +
        "<p>Last name*  	<input type='text' name='lname' class='user-input' value='" + lname + "' required='true'></p>" +
        "<p>Email*      	<input type='email' name='email' class='user-input' value='" + email + "' required='true'></p>" +
        "<p>Phone*      	<input type='text' name='phone' class='user-input' value='" + phone + "' required='true'></p>" +
        "<p>Username*   	<input type='text' name='uname' class='user-input' value='" + username + "' required='true'></p>" +
        "<p>Password*   	<input type='text' name='password' class='user-input' value='" + password + "' required='true'></p>" +
        "<p>Street Address* <input type='text' name='saddress' class='user-input' value='" + saddress + "' required='true'></p>" +
        "<p>State* 			<input type='text' name='state' class='user-input' value='" + state + "' required='true'></p>" +
        "<p>ZIP* 			<input type='text' name='zip' class='user-input' value='" + zip + "' required='true'></p>" +
        "<p>Type* <br>		<select class='user-input' disabled style='padding:2px 0px;'><option>Not Changeable</option></select></p>" +
        "<input type='submit' name='submit' class='solid-btn' value='Update' onclick='UserAdded()'>" +

        "</form></div></section></div>'");

}

function snackbar(txt) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    x.innerHTML = txt;

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function() { x.className = x.className.replace("show", ""); }, 3000);
}


function email_popup(email) {
    $("body").prepend("" +
        "<div class='message-panel'>" +
        "<div class='crossbutton'>" +
        "<a href='' class='cross-btn'>" +
        "<i class='fa-solid fa-circle-xmark'></i>" +
        "</a>" +
        "</div>" +
        "<section>" +
        "<h3>Send Email</h3>" +
        "<div>" +

        "<p><textarea name='email-subject' id='e-sub' placeholder='Enter Email Subject'  required='true'></textarea></p>" +
        "<p><textarea name='email-body' id='e-bod' placeholder='Enter Email Body' required='true'></textarea></p>" +

        "<input type='button' name='submit' class='solid-btn' value='Send Mail' onclick=send_email('" + email + "')>" +


        "</div>" +
        "</section>" +
        "</div>");
}

function send_email(email) {
    url = "../backend/message/email.php";
    sub = $("#e-sub").val();
    bod = $("#e-bod").val();

    $.ajax({
        url: url,
        type: 'POST',
        data: { email: email, sub: sub, body: bod },
        success: function(response) {
            console.log(response);
            snackbar("Email Sent Successfully");
            $(".message-panel").remove();
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });
}



function sms_popup(phone) {
    $("body").prepend("" +
        "<div class='message-panel'>" +
        "<div class='crossbutton'>" +
        "<a href='' class='cross-btn'>" +
        "<i class='fa-solid fa-circle-xmark'></i>" +
        "</a>" +
        "</div>" +
        "<section>" +
        "<h3>Send SMS</h3>" +
        "<div>" +

        "<p><textarea name='email-body' id='e-bod' placeholder='Enter SMS Body' required='true'></textarea></p>" +

        "<input type='button' name='submit' class='solid-btn' value='Send SMS' onclick=send_sms('" + phone + "')>" +


        "</div>" +
        "</section>" +
        "</div>");
}

function send_sms(phone) {
    url = "../backend/message/sms.php";

    bod = $("#e-bod").val();

    $.ajax({
        url: url,
        type: 'POST',
        data: { phone: phone, body: bod },
        success: function(response) {
            snackbar("SMS Sent Successfully");
            $(".message-panel").remove();
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });
}