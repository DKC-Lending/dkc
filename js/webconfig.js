function monthController(obj) {
    if (obj.checked) {
        const c = confirm(`Do you want to enable ${obj.name} from the table`);
        if (c) {
            $.ajax({
                type: 'post',
                url: '../backend/config/settingController.php',
                data: {
                    month: obj.name,
                    type: 'on'
                },
                success: function () {
                    alert("Successfully Updated");
                }

            })
        }
    } else {
        const c = confirm(`Do you want to disable ${obj.name} from the table`);
        if (c) {
            $.ajax({
                type: 'post',
                url: '../backend/config/settingController.php',
                data: {
                    month: obj.name,
                    type: 'off'
                },
                success: function () {
                    alert("Successfully Updated");
                }

            })
        }
    }
}

function updateMonth() {
    $.ajax({
        type: 'GET',
        url: '../backend/config/getcheckedmonth.php',
        success: function (data) {
            const months = JSON.parse(data);
            if (months.length > 0) {
                const elems = document.getElementsByClassName("monthBox");
                for (let i = 0; i < elems.length; i++) {
                    if(months.includes(elems[i].name)){
                        elems[i].checked = true;
                    }
                }
            }
        }

    })
}

window.onload = () => updateMonth();