const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
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
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(`${tbl}`);
  ascdsc = true;
  switching = true;
  console.log(table)
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
  } else if (x.innerHTML.match(/^\d{2}-\d{2}-\d{4}$/) != null) {
    tempx = Date.parse(x.innerHTML);
    tempy = Date.parse(y.innerHTML);
   
    if (tempx - tempy<0) {
      ascdsc = false;
    }
  }
  else {
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
      } else if (x.innerHTML.match(/^\d{2}-\d{2}-\d{4}$/) != null) {
        tempx = Date.parse(x.innerHTML);
        tempy = Date.parse(y.innerHTML);
console.log(tempx,tempy)
        if (ascdsc) {
          if (tempx -tempy >0) {
            shouldSwitch = true;
            break;
          }
        } else {
          if (tempx - tempy < 0) {
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




function goto_find(obj) {
  var id = obj.value;
  document.getElementById("investor-goto").href = "#" + id;
}




function add_month() {
  res = confirm(`Do you want to add ${shortHeading} to the list`);
  if (res) {
    $.ajax({
      url: '../backend/summary/newmonth.php',
      type: 'POST',
      data: {
        date: shortHeading
      },
      success: function (response) {
        // if(response == "complete"){
        alert("Successfully added"); window.open("borrower.php", "_self");

        // }
      }
    })
  }

}