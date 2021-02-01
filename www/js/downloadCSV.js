// opt col length is for when there are edit columns at the end (i.e. don't save edit columns)
function downloadCSV(elementId, opt_col_length) {
    var table = document.getElementById(elementId); 
    var rows = table.rows; 
    var resultArray = []; 
    var rowArray = []; 
    var cellValue; 

    var cell_length = 0;
    if (rows.length > 0) {
        cell_length = rows[0].cells.length;
    }
    if (opt_col_length) {
        cell_length = opt_col_length;
    }

    for (var i = 0; i < rows.length; i++){
        for (var j = 0; j < cell_length; j++){
            cellValue = rows[i].cells[j].textContent
            rowArray.push(cellValue);
        }
        resultArray.push(rowArray);
        rowArray = [] // set it back to initial value. 
    }

    var csvContent = "data:text/csv;charset=utf-8,";

    resultArray.forEach(function(rowArray) {
        var row = rowArray.join(",");
        csvContent += row + "\r\n";
    });

	var encodedUri = encodeURI(csvContent);
	var link = document.createElement("a");
	link.setAttribute("href", encodedUri);
	link.setAttribute("download", "data.csv");
	document.body.appendChild(link); // Required for FF
	link.click(); // This will download the data file named "my_data.csv".
	
}