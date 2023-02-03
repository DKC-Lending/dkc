const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

document.onkeydown = keyDownCode;

var today = new Date();
var date = today.getDate() + "/" + (today.getMonth() + 1) + '/' + today.getFullYear();

var shortHeading = monthNames[today.getMonth()] + " " + today.getFullYear().toString().substr(-2);

$(".cell-form").submit(function (event) {

  event.preventDefault();
});

function roundToTwo(num) {
  return +(Math.round(num + "e+2") + "e-2");
}


function sortTable(tbl, r) {
  const table = document.getElementById(tbl);
  const rows = Array.from(table.rows).slice(1, -1);
  const totalRow = table.rows[table.rows.length - 1];
  table.deleteRow(-1)
  const header = table.rows[0].cells[r];
  let ascdsc = true;
  header.ascdsc = header.ascdsc === undefined ? true : !header.ascdsc;
  ascdsc = header.ascdsc;
  const isAmount = (str) => /^\$?\d+(,\d{3})*\.?[0-9]?[0-9]?$/.test(str);
  const isDate = (str) => /^\d{2}-\d{2}-\d{4}$/.test(str);

  rows.sort((a, b) => {
    const cellA = a.cells[r].textContent;
    const cellB = b.cells[r].textContent;

    if (isAmount(cellA)) {
      return ascdsc ? parseFloat(cellA.slice(1)) - parseFloat(cellB.slice(1))
                    : parseFloat(cellB.slice(1)) - parseFloat(cellA.slice(1));
    } else if (isDate(cellA)) {
      return ascdsc ? Date.parse(cellA) - Date.parse(cellB)
                    : Date.parse(cellB) - Date.parse(cellA);
    } else {
      console.log("number")
      return ascdsc ? cellA.localeCompare(cellB)
                    : cellB.localeCompare(cellA);
    }
  });

  rows.forEach(row => table.appendChild(row));
  table.appendChild(totalRow);
}





function goto_find(obj) {
  var id = obj.value;
  document.getElementById("investor-goto").href = "#" + id;
}

function refresh_month() {
  res = confirm(`Do you want to refresh the investor data?`);
  if (res) {
    $.ajax({
      url: '../backend/summary/newmonth.php',
      type: 'POST',
      data: {
        date: shortHeading
      },
      success: function (response) {
        // if(response == "complete"){
        alert("Successfully Refreshed"); window.open("borrower.php", "_self");

        // }
      }
    })
  }

}


function add_month() {

  month = ((today.getMonth() + 1) > 11) ? 0 : today.getMonth() + 1;
  year = ((today.getMonth() + 1) > 11) ? (today.getFullYear() + 1) : today.getFullYear();
  const tempshortHeading = monthNames[month] + " " + year.toString().substr(-2);
  res = confirm(`Do you want to add ${tempshortHeading} to the list`);
  if (res) {

    $.ajax({
      url: '../backend/summary/newmonth.php',
      type: 'POST',
      data: {
        date: tempshortHeading
      },
      success: function (response) {
        // if(response == "complete"){
        alert("Successfully added"); window.open("borrower.php", "_self");

        // }
      }
    })
  }

}



function keyDownCode(evt) {
  console.log(evt.keyCode)

  if (!evt) evt = event;

  if (evt.altKey && evt.keyCode === 190) {
    add_month()

  } else if (evt.altKey && evt.keyCode === 188) {

    refresh_month()

  } else if (evt.keyCode === 18 && evt.keyCode === 69) {
   alert();
    $("#expand").show();
  }
  else if (evt.keyCode === 27) {
    $("#expand").hide();
  }
}
window.onload = () => $("#expand").hide();

const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
    v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

// do the work...
document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
    const table = th.closest('table');
    Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
        .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
        .forEach(tr => table.appendChild(tr) );
})));