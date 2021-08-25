/*
 Template Name: Stexo - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable(
    	{
        "order": [[ 1, "desc" ]],
        "columnDefs" : [
        //hide the second & fourth column
        	{ 'visible': false, 'targets': [1] }
    	]
    	}
    	);

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );