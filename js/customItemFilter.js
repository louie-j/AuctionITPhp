$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var unassigned = document.getElementById('unassigned').checked
        var one = document.getElementById('one').checked;
        var two = document.getElementById('two').checked;
        var three = document.getElementById('three').checked;
        var six = document.getElementById('six').checked;
        var splitPath = window.location.pathname.split( '/' );
        var id = splitPath[splitPath.length-1] == 'ItemManagement.php' ?
            parseInt( data[1] ) : 
            parseInt( data[0] );
        if (unassigned && isNaN(id))
            return true;
        else if (one && !isNaN(id) && id >= 100 && id < 200)
            return true;
        else if (two && !isNaN(id) && id >= 200 && id < 300)
            return true;   
        else if (three && !isNaN(id) && id >= 300 && id < 400)
            return true;         
        else if (six && !isNaN(id) && id >= 600 && id < 700)
            return true;    
        return false;
    }
);