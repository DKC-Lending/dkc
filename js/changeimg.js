function changeimg(event,dest){
        // $(dest).html("");
        var desst = document.getElementById(dest);
        desst.src = URL.createObjectURL(event.target.files[0]);
        // free memory
        // var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        // if (regex.test($(btn).val().toLowerCase())) {
        //     if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
        //         $(dest).show();
        //         $(dest)[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(btn).val();
        //     }
        //     else {
        //         if (typeof (FileReader) != "undefined") {
        //             $(dest).show();
        //             $(dest).append("<img />");
        //             var reader = new FileReader();
        //             reader.onload = function (e) {
        //                 $(dest).attr("src", e.target.result);
        //             }
        //             reader.readAsDataURL($(btn)[0].files[0]);
        //         } else {
        //             alert("This browser does not support FileReader.");
        //         }
        //     }
        // } else {
        //     alert("Please upload a valid image file.");
        // }
   
}