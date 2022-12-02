var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var year = dateObj.getUTCFullYear();
var days = dateObj.getDate();
var jsonPaidoff;
function add_multi_collateral(obj) {
    obj.preventDefault()

    let bcollbody = $("#multi-coll");
    let mcount = document.querySelectorAll("#multi-coll div").length;
    if (mcount < 5) {
        bcollbody.append(' <div>'
            + '<input type="text" class="mulcol"  id="mcoll' + mcount + '" name="mcoll' + mcount + '" placeholder="Collateral Address"/>'
            + '<input type="text" class="mulcol"  id="mexpiry' + mcount + '" name="mexpiry' + mcount + '" placeholder="Exp date (mm-dd-YYYY)"/>'
            + '</div>')
    }

}
$("#cross-btn").click(function (e) {
    e.preventDefault();
    alert();
})

function cutloan(x) {
    jsonPaidoff = x;
    $("#paidsid").val(x.sid);
    $(".payoff-holder").removeClass("hide");
    $("#payoff-coll").val(x.bcoll);
    $("#hiddenrate").val(x.irate);
    $("#llcname").val(x.bllc);
    $("#payoff-exdate").val(month + "-" + days + "-" + year);
    $("#payoff-pbalance").val(x.tloan);
    $("#payoff-lxtension").val('0.00');
    $("#payoff-adminfee").val('500.00');
    $("#payoff-rfee").val('10.00');
    $("#payoff-afee").val('350.00');
    $("#paid_lender").text(x.dkc);
    $("#paid_p1").text(x.p1);
    $("#paid_p2").text(x.p2);
    $("#paid_p3").text(x.p3);
    $("#paid_p4").text(x.p4);
    $("#beforedkcpaidoff_").text("$" + parseFloat(x.dkcregular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforep1paidoff_").text("$" + parseFloat(x.p1regular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforep2paidoff_").text("$" + parseFloat(x.p2regular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforep3paidoff_").text("$" + parseFloat(x.p3regular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforep4paidoff_").text("$" + parseFloat(x.p4regular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforeservicingpaidoff_").text("$" + parseFloat(x.servicingregular).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#beforeyieldpaidoff_").text("$" + parseFloat(x.yieldregular).toLocaleString(undefined, { minimumFractionDigits: 2 }));

    tempdkc = paidoffinvestor(x.dkcamt, x.dkcrate);
    tempp1 = paidoffinvestor(x.p1amt, x.p1rate);
    tempp2 = paidoffinvestor(x.p2amt, x.p2rate);
    tempp3 = paidoffinvestor(x.p3amt, x.p3rate);
    tempp4 = paidoffinvestor(x.p4amt, x.p4rate);
    tempservice = paidoffinvestor(x.servicingamt, x.servicingrate);
    tempyield = paidoffinvestor(x.yieldamt, x.yieldrate)
    $("#dkcpaidoff").val(tempdkc)
    $("#p1paidoff").val(tempp1)
    $("#p2paidoff").val(tempp2)
    $("#p3paidoff").val(tempp3)
    $("#p4paidoff").val(tempp4)
    $("#servicingpaidoff").val(tempservice)
    $("#yieldpaidoff").val(tempyield)
    $("#dkcpaidoff_").text("$" + parseFloat(tempdkc).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p1paidoff_").text("$" + parseFloat(tempp1).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p2paidoff_").text("$" + parseFloat(tempp2).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p3paidoff_").text("$" + parseFloat(tempp3).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p4paidoff_").text("$" + parseFloat(tempp4).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#servicingpaidoff_").text("$" + parseFloat(tempservice).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#yieldpaidoff_").text("$" + parseFloat(tempyield).toLocaleString(undefined, { minimumFractionDigits: 2 }))

    payoffprorated()


}

function reupdatepaidoff() {
    x = jsonPaidoff;

    tempdkc = paidoffinvestor(x.dkcamt, x.dkcrate);
    tempp1 = paidoffinvestor(x.p1amt, x.p1rate);
    tempp2 = paidoffinvestor(x.p2amt, x.p2rate);
    tempp3 = paidoffinvestor(x.p3amt, x.p3rate);
    tempp4 = paidoffinvestor(x.p4amt, x.p4rate);
    tempservice = paidoffinvestor(x.servicingamt, x.servicingrate);
    tempyield = paidoffinvestor(x.yieldamt, x.yieldrate)
    let acint = paidoffinvestor(x.tloan, x.irate);
    const pdays = $("#payoff-exdate").val().split("-")[1];
    console.log("pdays", pdays)
    $("#payoff-ainterest").val(acint)
    $("#payoff-perdiem").val((acint / pdays).toLocaleString(undefined, { minimumFractionDigits: 4 }))

    $("#dkcpaidoff").val(tempdkc)
    $("#p1paidoff").val(tempp1)
    $("#p2paidoff").val(tempp2)
    $("#p3paidoff").val(tempp3)
    $("#p4paidoff").val(tempp4)
    $("#servicingpaidoff").val(tempservice)
    $("#yieldpaidoff").val(tempyield)

    $("#dkcpaidoff_").text("$" + parseFloat(tempdkc).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p1paidoff_").text("$" + parseFloat(tempp1).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p2paidoff_").text("$" + parseFloat(tempp2).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p3paidoff_").text("$" + parseFloat(tempp3).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#p4paidoff_").text("$" + parseFloat(tempp4).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#servicingpaidoff_").text("$" + parseFloat(tempservice).toLocaleString(undefined, { minimumFractionDigits: 2 }))
    $("#yieldpaidoff_").text("$" + parseFloat(tempyield).toLocaleString(undefined, { minimumFractionDigits: 2 }))

    payoffprorated();
}

function paidoffinvestor(balance, rate) {
    // balance = $("#payoff-pbalance").val();
    // rate = $("#hiddenrate").val();
    const pdays = $("#payoff-exdate").val().split("-")[1];
    console.log("balance, rate, pdays ", balance, rate, pdays)
    const prorated = ((((rate / 100) * balance) / 365) * (parseInt(pdays))).toFixed(2);
    console.log("prorated", prorated)
    return prorated;
}
function payoffprorated() {
    balance = $("#payoff-pbalance").val();
    rate = $("#hiddenrate").val();
    const pdays = $("#payoff-exdate").val().split("-")[1];
    console.log("balance, rate, pdays ", balance, rate, pdays)
    const prorated = ((((rate / 100) * balance) / 365) * (parseInt(pdays))).toFixed(2);
    $("#payoff-ainterest").val(prorated);

    $("#payoff-perdiem").val((prorated / pdays).toLocaleString(undefined, { minimumFractionDigits: 4 }))
    totalpayoff();
}
function totalpayoff() {
    var t = 0;
    t += parseFloat($("#payoff-pbalance").val());
    t += parseFloat($("#payoff-lxtension").val());
    t += parseFloat($("#payoff-adminfee").val());
    t += parseFloat($("#payoff-rfee").val());
    t += parseFloat($("#payoff-afee").val());
    $("#totalpaidoff").val(t);


}

function maximize_window() {
    let win = document.getElementById("max-window");
    win.style.display = "flex";
}
function minimize_window() {
    let win = document.getElementById("max-window");
    win.style.display = "none";
}
function sortTable(tbl, r) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(`${tbl}`);
    ascdsc = true;
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    x = table.rows[1].getElementsByTagName("TD")[r];
    y = table.rows[table.rows.length - 2].getElementsByTagName("TD")[r];
    console.log(x.innerHTML.replace("$", ""), y.innerHTML, r)
    if (x.innerHTML.startsWith("$")) {

        tempx = x.innerHTML.replace("$", "").replaceAll(",", "");
        tempy = y.innerHTML.replace("$", "").replaceAll(",", "");
        if (parseFloat(tempx) < parseFloat(tempy)) {
            ascdsc = false;
        }
    } else {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            ascdsc = false;
        }
    }

    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/

        for (i = 1; i < (rows.length - 2); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[r];
            y = rows[i + 1].getElementsByTagName("TD")[r];
            //check if the two rows should switch place:
            if (x.innerHTML.startsWith("$")) {

                tempx = x.innerHTML.replace("$", "").replaceAll(",", "");
                tempy = y.innerHTML.replace("$", "").replaceAll(",", "");
                if (ascdsc) {
                    if (parseFloat(tempx) > parseFloat(tempy)) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (parseFloat(tempx) < parseFloat(tempy)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            } else {

                if (ascdsc) {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }




        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function editSummary(list, mul, exp) {
    document.getElementById("main-form").action = "../backend/summary/update_summary.php";
    $("#sum-id").val(list.sid);
    $("#bllc").val(list.bllc);
    $("#fname").val(list.fname);
    $("#lname").val(list.lname);
    $("#caddress").val(list.bcoll);
    $("#clink").val(list.link);
    $("#tloan").val(list.tloan);
    $("#irate").val(list.irate);
    $("#odate").val(list.odate);
    $("#mdate").val(list.mdate);
    $("#bnum").val(list.bphone);
    $("#bemail").val(list.bemail);
    $("#bexpiry").val(list.iexpiry);
    $("#taxurl").val(list.taxurl);
    $("#taxurl").val(list.taxurl);
    console.log("ok");
    if (Object.keys(mul).length > 0) {
        colm = mul;
        expirym = exp;
        let cnt = 0;
        colm.forEach(element => {

            $("#multi-col-btn").click();
            $(`#mcoll${cnt}`).val(element)
            cnt++;
        });
        let cnt1 = 0;
        expirym.forEach(element => {
            console.log(element);

            $(`#mexpiry${cnt1}`).val(element)
            cnt1++;
        });
    }
    if (list.ach == "on") {
        document.getElementById("ach").checked = true;
    } else {
        document.getElementById("ach").checked = false;
    }
    $("#loans").val(list.loan);
    document.getElementById('business').value = list.service;
    document.getElementById('dkc').value = list.dkc;

    $("#dkcamnt").val(list.dkcamt);
    $("#dkcrate").val(list.dkcrate);
    $("#dkcprorated").val(list.dkcprorated);
    $("#dkcregular").val(list.dkcregular);
    document.getElementById('p1').value = list.p1;
    $("#p1amnt").val(list.p1amt);
    $("#p1rate").val(list.p1rate);
    $("#p1prorated").val(list.p1prorated);
    $("#p1regular").val(list.p1regular);
    document.getElementById('p2').value = list.p2;
    $("#p2amnt").val(list.p2amt);
    $("#p2rate").val(list.p2rate);
    $("#p2prorated").val(list.p2prorated);
    $("#p2regular").val(list.p2regular);
    document.getElementById('p3').value = list.p3;
    $("#p3amnt").val(list.p3amt);
    $("#p3rate").val(list.p3rate);
    $("#p3prorated").val(list.p3prorated);
    $("#p3regular").val(list.p3regular);
    document.getElementById('p4').value = list.p4;
    $("#p4amnt").val(list.p4amt);
    $("#p4rate").val(list.p4rate);
    $("#p4prorated").val(list.p4prorated);
    $("#p4regular").val(list.p4regular);
    $("#servicingamnt").val(list.servicingamt);
    $("#servicingrate").val(list.servicingrate);
    $("#servicingprorated").val(list.servicingprorated);
    $("#servicingregular").val(list.servicingregular);

    $("#yieldamnt").val(list.yieldamt);
    $("#yieldrate").val(list.yieldrate);
    $("#yieldprorated").val(list.yieldprorated);
    $("#yieldregular").val(list.yieldregular);
    $("#check").val(list.balance);
    document.getElementById('iszero').value = list.iszero;

    calculateTotal();
    jQuery("html,body").animate({ scrollTop: 100 }, 1000);
}

function deleteSummary(id) {
    let ask = confirm("Do you want to delete this column?");
    if (ask) {
        $.ajax({
            url: '../backend/summary/delete_summary.php',
            type: 'post',
            data: {
                sid: id
            },
            success: function (data) {
                window.open("summary.php", "_SELF");
            }
        });
    }
}

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

function calculateYield() {
    trate = $("#irate").val();

    dkc = $("#dkcrate").val();
    p1 = $("#p1rate").val();
    p2 = $("#p2rate").val();
    p3 = $("#p3rate").val();
    service = $("#servicingrate").val();
    $("#yieldamnt").val("");
    rate = 0;
    yamnt = 0;
    if (parseFloat(p1) == (parseFloat(trate) - parseFloat(service))) {
        yamnt += 0;
    } else {
        if (parseFloat(p1) > 0) {
            rate = parseFloat(trate) - (parseFloat(p1) + parseFloat(service));
            console.log(rate, 1);
            yamnt += parseFloat($("#p1amnt").val());
        }

    }
    if (parseFloat(p2) == (parseFloat(trate) - parseFloat(service))) {
        yamnt += 0;
    } else {
        if (parseFloat(p2) > 0) {
            rate = parseFloat(trate) - (parseFloat(p2) + parseFloat(service));
            console.log(rate, 2);
            yamnt += parseFloat($("#p2amnt").val());
        }
    }
    if (parseFloat(p3) == (parseFloat(trate) - parseFloat(service))) {

        yamnt += 0;
    } else {
        if (parseFloat(p3) > 0) {
            rate = parseFloat(trate) - (parseFloat(p3) + parseFloat(service));

            console.log(rate, 3);
            yamnt += parseFloat($("#p3amnt").val());
        }
    }

    $("#yieldamnt").val(yamnt);
    $("#yieldrate").val(rate);
    calculatePayment(document.getElementById("yieldrate"), 'yield')
    calculateTotal()
}

function calculatePayment(obj, whos) {
    const pdays = $("#odate").val().split("-")[1];
    const amt = $(`#${whos}amnt`).val();
    const rate = obj.value;
    days = daysInMonth($("#odate").val().split("-")[0], $("#odate").val().split("-")[2])
    console.log(days, pdays);
    const prorated = ((((rate / 100) * amt) / 365) * (parseInt(days - pdays) + 1)).toFixed(2);
    const regular = (((rate / 100) * amt) / 12).toFixed(2);
    $(`#${whos}prorated`).val(prorated);
    $(`#${whos}regular`).val(regular);
    checkBalance();

}

function checkBalance() {
    const dkc = $("#dkcregular").val() != '' ? parseFloat($('#dkcregular').val()) : 0;
    const p1 = $("#p1regular").val() != '' ? parseFloat($('#p1regular').val()) : 0;
    const p2 = $("#p2regular").val() != '' ? parseFloat($('#p2regular').val()) : 0;
    const p3 = $("#p3regular").val() != '' ? parseFloat($('#p3regular').val()) : 0;
    const p4 = $("#p4regular").val() != '' ? parseFloat($('#p4regular').val()) : 0;

    const servicingreg = $("#servicingregular").val() != '' ? parseFloat($('#servicingregular').val()) : 0;
    const yieldvreg = $("#yieldregular").val() != '' ? parseFloat($('#yieldregular').val()) : 0;
    document.getElementById("check").value = eval(dkc + p1 + p2 + p3 + p4 + servicingreg + yieldvreg).toFixed(2);
}

function calculateTotal() {
    dkcamnt = $("#dkcamnt").val() != '' ? parseFloat($('#dkcamnt').val()) : 0;
    p1amnt = $("#p1amnt").val() != '' ? parseFloat($('#p1amnt').val()) : 0;
    p2amnt = $("#p2amnt").val() != '' ? parseFloat($('#p2amnt').val()) : 0;
    p3amnt = $("#p3amnt").val() != '' ? parseFloat($('#p3amnt').val()) : 0;
    p4amnt = $("#p4amnt").val() != '' ? parseFloat($('#p4amnt').val()) : 0;

    amount = dkcamnt + p1amnt + p2amnt + p3amnt + p4amnt;
    amount = parseFloat(amount.toFixed(2));

    dkcprorated = $("#dkcprorated").val() != '' ? parseFloat($('#dkcprorated').val()) : 0;
    p1prorated = $("#p1prorated").val() != '' ? parseFloat($('#p1prorated').val()) : 0;
    p2prorated = $("#p2prorated").val() != '' ? parseFloat($('#p2prorated').val()) : 0;
    p3prorated = $("#p3prorated").val() != '' ? parseFloat($('#p3prorated').val()) : 0;
    p4prorated = $("#p4prorated").val() != '' ? parseFloat($('#p4prorated').val()) : 0;

    servicingprorated = $("#servicingprorated").val() != '' ? parseFloat($('#servicingprorated').val()) : 0;
    yieldprorated = $("#yieldprorated").val() != '' ? parseFloat($('#yieldprorated').val()) : 0;
    prorated = dkcprorated + p1prorated + p2prorated + p3prorated + p4prorated + servicingprorated + yieldprorated;
    prorated = parseFloat(prorated.toFixed(2));

    dkcreg = $("#dkcregular").val() != '' ? parseFloat($('#dkcregular').val()) : 0;
    p1reg = $("#p1regular").val() != '' ? parseFloat($('#p1regular').val()) : 0;
    p2reg = $("#p2regular").val() != '' ? parseFloat($('#p2regular').val()) : 0;
    p3reg = $("#p3regular").val() != '' ? parseFloat($('#p3regular').val()) : 0;
    p4reg = $("#p4regular").val() != '' ? parseFloat($('#p4regular').val()) : 0;

    servicingreg = $("#servicingregular").val() != '' ? parseFloat($('#servicingregular').val()) : 0;

    yieldregular = $("#yieldregular").val() != '' ? parseFloat($('#yieldregular').val()) : 0;

    regular = dkcreg + p1reg + p2reg + p3reg + p4reg + servicingreg + yieldregular;
    regular = parseFloat(regular.toFixed(2));

    $("#total_amount_add").html('$' + amount.toLocaleString());
    $("#total_prorated_add").html('$' + prorated.toLocaleString());
    $("#total_regular_add").html('$' + regular.toLocaleString());
    checkBalance();
}


function search() {
    var item = $('#searchItem').val();
    $('.tablerow td').each(function () {
        if ($(this).text().toLowerCase().includes(item.toLowerCase())) {
            this.style.backgroundColor = "rgba(221, 73, 73, 0.555)";
            this.scrollIntoView();
            var onj = this;
            setInterval(function () {
                onj.style.backgroundColor = "transparent";
            }, 1500);
        }
    })


};

function cardhover(obj) {
    $(obj).children($("p")).show();
}

function cardout(obj) {
    $(obj).children($("p")).hide();
}


function updateDrawn(obj) {
    console.log(obj.value);
    $.ajax({
        type: 'post',
        url: '../backend/summary/updateDrawn.php',
        data: {
            uid: 3,
            data: obj.value
        },
        success: function () {
            alert("Successfully Updated");
            window.open("summary.php", "_self");
        }

    })
}
let prel = 0;

function preloan_toggle() {
    if (prel == 0) {
        $("#preloans").removeClass(" hide")
        $("#preloans").addClass(" show")
        prel = 1;
    } else {
        $("#preloans").removeClass(" show")
        $("#preloans").addClass(" hide")
        prel = 0;
    }

}
function hoverconfirm(collaterals) {
    canvas = '<div id="hoverconfirm" class="hoverconfirm"><section>';
    canvas += "<b>Investors</b><br>"

    for (i = 0; i < collaterals.length; i++) {
        canvas += `<label>${i + 1}) ${collaterals[i]}</label><br>`;
    }

    canvas += ' </section></div>';
    console.log(canvas);
    $("#main-main-data-table").append(canvas);


    console.log("hey");
}
function deleteconfirm() {
    $("#hoverconfirm").remove();
}


// making pdf
$("#main-payoff-holder").ready(function () {
    $("#payForm").submit(function (event) {
        event.preventDefault();
        $("#pdfwrapper").show();
        fillPdf();
        $("#whole-body-wrapper").hide();
    })
})

function fillPdf() {
    const llc = $("#llcname").val()
    const bcol = $("#payoff-coll").val()
    const tloan = $("#payoff-pbalance").val()
    const accrued = parseFloat($("#payoff-ainterest").val())
    const penalty = parseFloat($("#payoff-lxtension").val())
    const late = parseFloat($("#payoff-latefee").val())
    const extra = parseFloat($("#payoff-extra").val())
    const admin = parseFloat($("#payoff-adminfee").val())
    const record = parseFloat($("#payoff-rfee").val())
    const attorney = parseFloat($("#payoff-afee").val())
    const ndate = $("#payoff-exdate").val()
    const day = ndate.split("-")[1]
    const date = new Date(ndate.split("-")[2], ndate.split("-")[0] - 1, ndate.split("-")[1])
    const diem = parseFloat(accrued) / parseFloat(day)
    const grand = parseFloat(accrued) + parseFloat(penalty) + parseFloat(admin) + parseFloat(record) + parseFloat(attorney)
    const fdate = date.toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' });
    const details = {
        fct: {
            send: "Fifth Third Bank\n4105 Gulf Boulevard\nSt.Pete Beach, FL 33706\nABA No. 042000314",
            receive: "First Capital Trusts LLC\n4506 Gulf Boulevard\nSt. Pete Beach, FL 33706\nAccount No. 7924312866"
        },
        dkcfl: {
            send: "PNC Bank, N.A.\n249 Fifth Avenue, Pittsburgh, PA, 15222\nABA No. 043000096",
            receive: "DKC Lending FL LLC\n2110 Park St\nJacksonville, FL 32204\nAccount No. 124122XXXX (Call to Verify Last 4 #s)"
        },
        dkc: {
            send: "Valley National Bank\n113 E Whiting St, Tampa , FL 33602\nABA No. 021201383",
            receive: "DKC Lending LLC\n2541 N. Dale Mabry Highway, #126\nTampa, FL 33615\nAccount No. 4253XXXX (Call to Verify Last 4 #s)"
        },
        austamerica: {
            send: "Bank of America\n18350 NW 2nd Ave, Miami, FL 33619\nABA No. 063100277",
            receive: "AustAmerica LLC\nP.O. Box 680\n1703 McMullen Booth Rd, Safety Harbor, FL 34695\nAccount No. 89811946XXXX (Call to verify last 4 digits)"
        }
    }
    const detail = details[$("#bankdetails").val()]
    console.log(detail)

    $("#sender-detail").text(detail.send);
    $("#receiver-detail").text(detail.receive);
    $("#month1").text(ndate.split("-")[0] + "/01/" + ndate.split("-")[2]);
    $("#month2").text(ndate.replaceAll("-", "/"));
    $("#llc").text(llc);
    $("#llc-address").text(bcol);
    $("#amount").text(parseFloat(tloan).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#llcname").text(llc);
    $("#property_id").text(bcol);
    $("#tloanpdf").text(parseFloat(tloan).toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#accrued").text(accrued.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#penalty").text(penalty.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#latefee").text(late.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#extrafee").text(extra.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#admin").text(admin.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#recording").text(record.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#attorney").text(attorney.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#exdate").text(fdate);
    $("#grand").text(grand.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    $("#fdate").text(fdate);
    $("#diem").text(diem.toLocaleString(undefined, { minimumFractionDigits: 4 }));
    if (penalty <= 0) {
        $("#penalty-wrapper").hide()
    }
    if (late <= 0) {
        $("#latefee-wrapper").hide()
    }
    if (extra <= 0) {
        $("#extra-wrapper").hide()
    }
}


function createPdf() {
    var opt = {
        margin: 1,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 2 },
        html2canvas: { scale: 1 },
        jsPDF: { unit: 'in', format: 'Letter', orientation: 'portrait' }
    };
    let pdfFrame = document.getElementById("pdfFrame");
    var docs = html2pdf().set(opt).from(pdfFrame).toPdf()
    var pdff = docs.output('datauristring');

    pdff.then(function (e) {
        console.log(e)
        $("#pdfuri").val(e)
        $("#payForm")[0].submit();
    });
}