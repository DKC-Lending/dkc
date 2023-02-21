document.onkeydown = keyDownCode;
const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
var today = new Date();
var date = today.getDate() + "-" + (today.getMonth() + 1) + '-' + today.getFullYear();

var shortHeading = monthNames[today.getMonth()] + " " + today.getFullYear().toString().substr(-2);

function open_form() {
    if ($("#invoice-form").is(":visible")) {
        $("#invoice-form").hide();
    } else {

        $("#invoice-form").show();

    }

}
var invoice_datas;
var page_ind = 0;




function sortTable(tbl, r) {
    const table = document.getElementById(tbl);

    const rows = Array.from(table.rows).slice(2, -1);
    console.log(rows.length)
    const totalRow = table.rows[table.rows.length - 1];
    console.log(totalRow)
    table.deleteRow(-1)
    console.log(table)
    const header = table.rows[1].cells[r];
    let ascdsc = true;
    header.ascdsc = header.ascdsc === undefined ? true : !header.ascdsc;
    ascdsc = header.ascdsc;
    const isAmount = (str) => /^\$\d+(,\d{3})*\.?[0-9]?[0-9]?$/.test(str);
    const isDate = (str) => /^\d{2}-\d{2}-\d{4}$/.test(str);
    const isNumber = (str) => /^[0-9]+$/.test(str);
    count = 0;
    console.log("before", rows.length)
    rows.sort((a, b) => {


        let cellA = a.cells[r].getAttribute("value");
        console.log("value", cellA)

        if (cellA == null) {
            cellA = a.cells[r].textContent;
            console.log("text", cellA);

        }
        let cellB = b.cells[r].getAttribute("value");
        console.log("value", cellB)

        if (cellB == null) {
            cellB = b.cells[r].textContent;
            console.log("text", cellB)

        }
        console.log("helhsdhsd", cellA, cellB)
        if (isAmount(cellA)) {
            console.log("Amount", cellA.slice(1))
            return header.ascdsc ? parseFloat(cellA.slice(1)) - parseFloat(cellB.slice(1))
                : parseFloat(cellB.slice(1)) - parseFloat(cellA.slice(1));
        } else if (isDate(cellA)) {
            console.log("Date", Date.parse(cellA))

            return header.ascdsc ? Date.parse(cellA) - Date.parse(cellB)
                : Date.parse(cellB) - Date.parse(cellA);
        } else if (isNumber(cellA)) {
            console.log("number", "number")
            return header.ascdsc ? cellA - cellB : cellB - cellA;
        } else {
            console.log("string", "string")
            return header.ascdsc ? cellA.localeCompare(cellB)
                : cellB.localeCompare(cellA);
        }
    });
    console.log("after", rows.length)

    rows.forEach(row => table.appendChild(row));
    table.appendChild(totalRow);
}



function refresh_month(invoice_datas) {
    let x = confirm(`Do you want to refresh ${monthNames[today.getMonth()] + " " + today.getFullYear().toString().substr(-2)} Data.`)
    if (x) {
        data = {

            title: monthNames[today.getMonth()] + " " + today.getFullYear().toString().substr(-2),


        }
        console.log(data)
        $.ajax({
            url: "../backend/insurance/addmonth.php",
            type: 'POST',
            data: data,
            success: function (x) { console.log(x); if (x == '1') reload() }

        });
    }
}

function add_month(invoice_datas) {
    month = ((today.getMonth() + 1) > 11) ? 0 : today.getMonth() + 1;
    year = ((today.getMonth() + 1) > 11) ? (today.getFullYear() + 1) : today.getFullYear();
    const tempshortHeading = monthNames[month] + " " + year.toString().substr(-2);
    let x = confirm(`Do you want to add ${tempshortHeading} to the Portal.`)
    if (x) {
        data = {

            title: tempshortHeading,


        }
        console.log(data)
        $.ajax({
            url: "../backend/insurance/addmonth.php",
            type: 'POST',
            data: data,
            success: function (x) { console.log(x); if (x == '1') reload() }

        });
    }

}

function date_dash_div(rdate) {
    if (rdate.search("/") >= 0) return rdate

    const raw = rdate.split("-")
    return `${raw[0]} - ${raw[1]} - ${raw[2]}`.replace(/ /g, '')
}

async function batchPDFSend() {
    var total = 0;
    $("#mass-sending-alert").show();
    var opt = {
        margin: 1,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 0.095 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
    };
    console.log(invoice_datas);
    for (let ind = 0; ind < invoice_datas.length; ind++) {

        $("#send-result").html(`( ${ind + 1} / ${invoice_datas.length})`)
        $("#mtbody").html('');


        $("#mpdfborrower").html(invoice_datas[ind].bllc);
        $("#mpdfaddress").html(invoice_datas[ind].bcoll);
        $("#mpdfodate").html(date_dash_div(invoice_datas[ind].odate));
        $("#mpdfmdate").html(date_dash_div(invoice_datas[ind].mdate));
        $("#mpdflamount").html(`$${invoice_datas[ind].tloan.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
        $("#mpdflpercent").html(`${invoice_datas[ind].irate}%`);
        $("#mpdfpayment").html(`$${invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
        $("#current-page").html(ind + 1 + " / " + invoice_datas.length);
        data = { uid: invoice_datas[ind].sid }
        console.log(data)
        console.log(ind)
        console.log(invoice_datas.length)

        form = $.post('../backend/insurance/get_history.php', data);
        await form.done(function (e) {
            e = JSON.parse(e);
            try {
                e.forEach(function (d, i) {

                    $("#mtbody").append('<tr>' +
                        '<td>' + date_dash_div(d.date) + '</td>' +
                        '<td>' + d.desc + ' Interest' + '</td>' +
                        '<td>' + d.minterest + "%" + '</td>' +
                        '<td>' + (d.latefees).toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                        '<td>' + "$" + d.adue.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                        '<td>' + "$" + d.apaid.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                        '</tr>');
                });
            } catch (error) {
                console.log(error);
            }


            $("#mtbody").append('<tr>' +
                '<td>' + date + '</td>' +
                '<td>' + monthNames[today.getMonth()].toString() + '`s Interest' + '</td>' +
                '<td>' + invoice_datas[ind].irate + "%" + '</td>' +
                '<td>' + " X " + '</td>' +
                '<td>' + "$" + invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '<td>' + "$" + invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '</tr>');
        });
        const pdfFrame = document.getElementById("mpdf-preview");
        var pdff = html2pdf().set(opt).from(pdfFrame).toPdf().output('datauristring');
        await pdff.then(function (e) {
            //console.log(e);
            let data = {
                'uid': invoice_datas[ind].sid,
                'subject': monthNames[today.getMonth()].toString() + '`s Invoice | DKC Lending',
                'email': invoice_datas[ind].bemail,
                'fileDataURI': e,
            };
            $.ajax({
                url: "../backend/insurance/send_to_borrower.php",
                type: 'POST',
                data: data,
                success: async function (response) {
                    console.log(response);
                    if (response == 'true') {
                        let data = {
                            'uid': invoice_datas[ind].sid,
                            'date': date_dash_div(date),
                            'desc': monthNames[today.getMonth()].toString(),
                            'rate': invoice_datas[ind].irate,
                            'fee': "X",
                            'pamount': invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }),
                            'amount': invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }),
                        };
                        console.log(data);

                        $.post("../backend/insurance/addPdfEntry.php", data, function () {
                            $("#save-invoice2").val("Sent");
                            console.log("Successfully Send!");
                            data = {
                                id: invoice_datas[ind].sid,
                                coll: invoice_datas[ind].bcoll,
                                borr: invoice_datas[ind].bllc,
                                title: shortHeading,
                                amt: invoice_datas[ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 })

                            }
                        });
                        //     console.log(data)
                        //     $.ajax({
                        //         url: "../backend/insurance/addmonth.php",
                        //         type: 'POST',
                        //         data: data,
                        //         success: async function (response) { total += 1; if (ind == invoice_datas.length) reload() }

                        //     });
                        // });


                    } else {
                        console.log("Error While Sending!");
                    }

                },
                error: function (request, status, error) {
                    alert(error);
                }
            });

        });

    }



}

function reload() {
    window.open('invoices.php', '_self');

}

function getPdf(data) {

}

function batch_send(datas) {
    $("#batch-preview").show();
    $("#mtbody").html('');
    page_ind = 0;
    invoice_datas = datas;
    $("#mpdfborrower").html(invoice_datas[page_ind].bllc);
    $("#mpdfaddress").html(invoice_datas[page_ind].bcoll);
    $("#mpdfodate").html(date_dash_div(invoice_datas[page_ind].odate));
    $("#mpdfmdate").html(date_dash_div(invoice_datas[page_ind].mdate));
    $("#mpdflamount").html(`$${invoice_datas[page_ind].tloan.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
    $("#mpdflpercent").html(`${invoice_datas[page_ind].irate}%`);
    $("#mpdfpayment").html(`$${invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
    $("#current-page").html(page_ind + 1 + " / " + invoice_datas.length);
    data = { uid: invoice_datas[page_ind].sid }

    form = $.post('../backend/insurance/get_history.php', data);
    form.done(function (e) {

        e = JSON.parse(e);
        // var d = new Date();
        e.forEach(function (d, i) {
            console.log(d);
            $("#mtbody").append('<tr>' +
                '<td>' + date_dash_div(d.date) + '</td>' +
                '<td>' + d.desc + ' Interest' + '</td>' +
                '<td>' + d.minterest + "%" + '</td>' +
                '<td>' + (d.latefees) + '</td>' +
                '<td>' + "$" + d.adue.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '<td>' + "$" + d.apaid.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '</tr>');
        });

        $("#mtbody").append('<tr>' +
            '<td>' + date + '</td>' +
            '<td>' + monthNames[today.getMonth()].toString() + ' Interest' + '</td>' +
            '<td>' + invoice_datas[page_ind].irate + "%" + '</td>' +
            '<td>' + " X " + '</td>' +
            '<td>' + "$" + invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
            '<td>' + "$" + invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
            '</tr>');
        // try {
        //     if (e[e.length - 1].desc == monthNames[d.getMonth()]) {
        //         $("#save-invoice2").prop('disabled', true);
        //         $("#save-invoice2").val("disable");
        //         document.getElementById("save-invoice2").style.background = "grey";

        //     }
        //     alert("Invoice of this month was sent previously");
        // } catch {
        //     console.log("12");
        // }
    });
}

function change_pdf(direction) {
    if (direction == 1 && invoice_datas.length - 1 > page_ind) {
        page_ind++;
    } else if (direction == -1 && page_ind > 0) {
        page_ind--;
    }
    $("#mtbody").html('');

    $("#mpdfborrower").html(invoice_datas[page_ind].bllc);
    $("#mpdfaddress").html(invoice_datas[page_ind].bcoll);
    $("#mpdfodate").html(date_dash_div(invoice_datas[page_ind].odate));
    $("#mpdfmdate").html(date_dash_div(invoice_datas[page_ind].mdate));
    $("#mpdflamount").html(`$${invoice_datas[page_ind].tloan.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
    $("#mpdflpercent").html(`${invoice_datas[page_ind].irate}%`);
    $("#mpdfpayment").html(`$${invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);


    $("#current-page").html(page_ind + 1 + " / " + invoice_datas.length);

    data = { uid: invoice_datas[page_ind].sid }
    console.log(data);
    form = $.post('../backend/insurance/get_history.php', data);
    form.done(function (e) {

        e = JSON.parse(e);
        //var d = new Date();
        e.forEach(function (d, i) {
            // console.log(d.date);
            $("#mtbody").append('<tr>' +
                '<td>' + date_dash_div(d.date) + '</td>' +
                '<td>' + d.desc + ' Interest' + '</td>' +
                '<td>' + d.minterest + "%" + '</td>' +
                '<td>' + (d.latefees.toLocaleString(undefined, { minimumFractionDigits: 2 })) + '</td>' +
                '<td>' + "$" + d.adue.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '<td>' + "$" + d.apaid.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                '</tr>');
        });

        $(" #mtbody").append('<tr>' +
            '<td>' + date + '</td>' +
            '<td>' + monthNames[today.getMonth()].toString() + ' Interest' + '</td>' +
            '<td>' + invoice_datas[page_ind].irate + "%" + '</td>' +
            '<td>' + " X " + '</td>' +
            '<td>' + "$" + invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
            '<td>' + "$" + invoice_datas[page_ind].balance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
            '</tr>');
        // try {
        //     if (e[e.length - 1].desc == monthNames[d.getMonth()]) {
        //         $("#save-invoice2").prop('disabled', true);
        //         $("#save-invoice2").val("disable");
        //         document.getElementById("save-invoice2").style.background = "grey";

        //     }
        //     alert("Invoice of this month was sent previously");
        // } catch {
        //     console.log("12");
        // }
    });
}

function preview_form(datas) {
    console.log(datas);
    if ($("#preview-form").is(":visible")) {
        $("#preview-form").hide();
    } else {

        $("#preview-form").show();
        var data = { uid: datas.sid };
        var lastdate = $.post('../backend/insurance/getlastdate.php', data);
        var ldate = '';
        lastdate.done(function (e) {
            try {
                e = JSON.parse(e);
                ldate = (Object.keys(e).length > 0) ? e.date : "##-##-####";
            } catch (e) {
                ldate = "##-##-####";
            }
            $("#last-invoice-date").html("( Last Sent on: " + ldate + " )");
        });
        month = ((today.getMonth() + 1) > 11) ? 0 : today.getMonth() + 1;
        year = ((today.getMonth() + 1) > 11) ? (today.getFullYear() + 1) : today.getFullYear();
        const tempshortHeading = monthNames[month] + " " + year.toString().substr(-2);
        month = ((month + 1) < 10) ? `0${month + 1}` : month;
        tdate = `${month}-01-${year}`;
        $("#bid").val(datas.sid);
        $("#current-invoice-date").html("Send Invoice for: " + tdate + ' (' + monthNames[today.getMonth()] + ')');
        $("#pbname").val(datas.bllc);
        $("#pbaddress").val(datas.bcoll);
        $("#pbtloan").val(datas.tloan);
        $("#pbrate").val(datas.irate);
        $("#pbodate").val(date_dash_div(datas.odate));
        $("#pbmdate").val(date_dash_div(datas.mdate));
        $("#pbphone").val(datas.bphone);
        $("#pbemail").val(datas.bemail);
        $("#pfiexpire").val(datas.iexpiry);

        $("#pbmpayment").val(datas.balance)




    }

}
// $(document).ready(function () {
//     // Listen to submit event on the <form> itself!
//     $('form').submit(function (e) {

//         e.preventDefault();
//         add_users();
//     });
// });

function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}


function showPdfPreviewer() {

    $("#pdfborrower").html($("#pbname").val());
    $("#pdfaddress").html($("#pbaddress").val());
    $("#pdfodate").html(date_dash_div($("#pbodate").val()));
    $("#pdfmdate").html(date_dash_div($("#pbmdate").val()));
    $("#pdflamount").html("$" + parseInt($("#pbtloan").val()).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#pdflpercent").html($("#pbrate").val() + "%");
    $("#pdfpayment").html("$" + parseInt($("#pbmpayment").val()).toLocaleString(undefined, { minimumFractionDigits: 2 }));

    $("#preview-form").hide();
    $("#pdf-preview-holder").show();
    data = { uid: $("#bid").val() }
    console.log(data);
    form = $.post('../backend/insurance/get_history.php', data);
    form.done(function (e) {
        console.log(e);
        e = JSON.parse(e);
        var d = new Date();


        e.forEach(function (d, i) {
            $("#pdf-table").append('<tr>' +
                '<td>' + date_dash_div(d.date) + '</td>' +
                '<td>' + d.desc + ' Interest' + '</td>' +
                '<td>' + d.minterest + "%" + '</td>' +
                '<td>' + (d.latefees) + '</td>' +
                '<td>' + "$" + parseInt(d.adue).toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
                // '<td>' + "$" + d.apaid + '</td>' +
                '<td>' + "$0.00" + '</td>' +
                '</tr>');
        });


        month = ((today.getMonth() + 1) > 11) ? 0 : today.getMonth() + 1;
        year = ((today.getMonth() + 1) > 11) ? (today.getFullYear() + 1) : today.getFullYear();
        const tempshortHeading = monthNames[month] + " " + year.toString().substr(-2);
        month = ((month + 1) < 10) ? `0${month + 1}` : month;
        tdate = `${month}-01-${year}`;
        $("#pdf-table").append('<tr>' +
            '<td>' + tdate + '</td>' +
            '<td>' + monthNames[today.getMonth()].toString() + ' Interest' + '</td>' +
            '<td>' + $("#pbrate").val() + "%" + '</td>' +
            '<td>' + (($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "X" : "$" + $("#plfee").val()) + '</td>' +
            '<td>' + "$" + eval(parseInt(($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "0.00" : $("#plfee").val()) + parseInt($("#pbmpayment").val())).toLocaleString(undefined, { minimumFractionDigits: 2 }) + '</td>' +
            // '<td>' + "$" + eval(parseInt(($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "0" : $("#plfee").val()) + parseInt($("#pbmpayment").val())).toString() + '</td>' +
            '<td>' + "$0.00" + '</td>' +

            '</tr>');
        try {
            if (e[e.length - 1].desc == monthNames[d.getMonth()]) {
                $("#save-invoice2").prop('disabled', true);
                $("#save-invoice2").val("disable");
                document.getElementById("save-invoice2").style.background = "grey";

            }
            alert("Invoice of this month was sent previously");
        } catch (error) {
            console.log(error);
        }
    });



}

function createPdf() {
    var total = 0;
    $("#save-invoice2").val("Sending..");
    var opt = {
        margin: 1,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 0.095 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
    };
    const pdfFrame = document.getElementById("pdf-preview");
    var pdff = html2pdf().set(opt).from(pdfFrame).toPdf().output('datauristring');
    pdff.then(function (e) {

        let data = {
            'uid': $("#bid").val(),
            'subject': monthNames[today.getMonth()].toString() + ' Invoice | DKC Lending',
            'email': $("#pbemail").val(),
            'fileDataURI': e,
        };


        $.ajax({
            url: "../backend/insurance/send_to_borrower.php",
            type: 'POST',
            data: data,
            success: function (response) {
                if (response == 'true') {
                    let data = {
                        'uid': $("#bid").val(),
                        'date': date,
                        'desc': monthNames[today.getMonth()].toString(),
                        'rate': $("#pbrate").val(),
                        'fee': ($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "X" : "$" + $("#plfee").val(),
                        'pamount': eval(parseFloat(($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "0" : $("#plfee").val()) + parseFloat($("#pbmpayment").val())).toString(),
                        'amount': eval(parseFloat(($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "0" : $("#plfee").val()) + parseFloat($("#pbmpayment").val())).toString(),
                    };

                    $.post("../backend/insurance/addPdfEntry.php", data);
                    data = {
                        id: $("#bid").val(),
                        coll: $("#pbaddress").val(),
                        borr: $("#pbname").val(),
                        title: shortHeading,
                        amt: eval(parseFloat(($("#plfee").val() == "" || $("#plfee").val() == "x" || $("#plfee").val() == "X") ? "0" : $("#plfee").val()) + parseFloat($("#pbmpayment").val())).toString()
                    }
                    // $.ajax({
                    //     url: "../backend/insurance/addmonth.php",
                    //     type: 'POST',
                    //     data: data,
                    //     success: async function (response) { total += 1; if (total == invoice_datas.length) reload() }

                    // });
                    $("#save-invoice2").val("Sent");
                    alert("Successfully Send!");
                } else {
                    alert("Error While Sending!");
                }

            },
            error: function (request, status, error) {
                alert(error);
            }
        });

    });

}


function deleteBorrower(id, name) {
    var conf = confirm("Are you sure want to delete ( " + name + " ) from the table?");
    if (conf) {
        $.ajax({
            url: "../backend/insurance/deleteBorrower.php",
            type: 'POST',
            data: { 'uid': id },
            success: function (response) {
                if (response == 1) {
                    window.open('invoices.php', "_self");
                } else {
                    alert("Error While Sending!");
                }

            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

function showEditPanel(datas) {
    console.log(datas.borrower);
    $("#update-form").show();
    $("#ubid").val(datas.uid);
    $("#ubname").val(datas.borrower);
    $("#ubaddress").val(datas.address);
    $("#ubtloan").val(datas.total);
    $("#ubrate").val(datas.rate);
    $("#ubodate").val(date_dash_div(datas.odate));
    $("#ubmdate").val(date_dash_div(datas.mdate));
    $("#ubphone").val(datas.phone);
    $("#ubemail").val(datas.email);
    $("#ufiexpire").val(datas.insurance);
    $("#ubmpayment").val(datas.mpayment)

}


function editInvoiceBorrower() {
    var id = $("#ubid").val();

    $.ajax({
        url: "../backend/insurance/update_borrower.php",
        type: 'POST',
        data: {
            'uid': id,
            'bor': $("#ubname").val(),
            'phone': $("#ubphone").val(),
            'address': $("#ubaddress").val(),
            'mpayment': $("#ubmpayment").val(),
            'email': $("#ubemail").val(),
            'total': $("#ubtloan").val(),
            'insurance': $("#ufiexpire").val(),
            'rate': $("#ubrate").val(),
            'odate': $("#ubodate").val(),
            'mdate': $("#ubmdate").val(),
        },
        success: function (response) {
            if (response == 1) {
                window.open('invoices.php', "_self");
            } else {
                alert("Preview Error While Viewing!");
            }

        },
        error: function (request, status, error) {
            alert(request.responseText);

        }
    });
}



function delete_pdf(file) {
    console.log(file);
    var url = '../backend/insurance/delete_pdf.php';
    if (confirm("Do you want to delete this file?")) {
        $.ajax({
            url: url,
            type: 'POST',
            data: { 'file': file },
            success: function (response) {

                window.location.reload();


            },
            error: function (request, status, error) {
                console.log(status);
            }

        });
    }

}

function payment_confirm(table, tr, sid) {
    canva = document.getElementById("payment-received");
    console.log(canva.style.display);
    tbl = document.getElementById(table);
    bllc = tbl.rows[tr].cells[1].getElementsByTagName("a")[0].innerHTML;
    bcol = tbl.rows[tr].cells[2].innerHTML;
    schedule = tbl.rows[tr].cells[tbl.rows[tr].cells.length - 1].innerHTML;

    if (canva.style.display == "none" || canva.style.display == "") {
        canva.style.display = "flex";
        $("#confirmsid").val(sid);
        $("#confirmbllc").val(bllc);
        $("#confirmbcoll").val(bcol);

        $("#schedule").val(schedule);



    } else {
        canva.style.display = "none";

    }
}

function check_confirm_balance(obj) {
    act = parseFloat($("#schedule").val().replace("$", "").replace(",", ""));
    paid = parseFloat(obj.value.replace("$", "").replace(",", ""));
    $("#conf_balance").val(`$ ${(act - paid).toLocaleString(undefined, { minimumFractionDigits: 2 })}`);

}

function hoverconfirm(obj, date, paid, notes) {
    canva = '<div id="hoverconfirm" class="hoverconfirm"><section>' + `<label>${paid}</label><p>${date}</p><label>${notes}</label>` + ' </section></div>';
    console.log(canva);
    $("#main-main-container").append(canva);
    console.log("hey");
}
function deleteconfirm() {
    $("#hoverconfirm").remove();
}
function getOffset(el) {
    var _x = 0;
    var _y = 0;
    while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}

function keyDownCode(evt) {
    if (evt.keyCode === 18 && evt.keyCode === 69) {
        alert();
        $("#expand").show();
    }
    else if (evt.keyCode === 27) {
        $("#expand").hide();
    }
}