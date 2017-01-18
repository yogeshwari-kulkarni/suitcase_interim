
/* --------------------- 
First, check the table 
structure and assign classes.
--------------------- */

jQuery(document).ready(function($) {
	
	// Just tables in content
	var table = $('.content table');
	
/* --------------------- 
First, check the table 
structure and assign classes.
--------------------- */
	
	/* ----- None ----- */
	table.addClass('table-none');
	
	/* ----- Row ----- */
	// Find the second th in the first row, if it exists.
	var rowsHeader = $('.content table tr:first-of-type th:nth-of-type(2)');
	// If it does, it's a Row Headers table, so...
	// Add .row to its parent table!
	rowsHeader.closest('table').addClass('table-row');
		
	/* ----- Col ----- */
	// Find the first th in the second row, if it exists...
	var colHeader = $('.content table tr:nth-of-type(2) th:nth-of-type(1)');
	// If it does, it's a Col Headers table, so...
	// Add .col to its parent table!
	colHeader.closest('table').addClass('table-col');
	
	/* ----- BOTH ----- */
	// Find a table with BOTH a th in the first row
	// AND a th in the second row
	var both = $('.content table.table-row.table-col');
	// Then add .both to that table!
	both.addClass('table-both');

/* --------------------- 
Now apply any jQuery needed
to make the tables responsive
--------------------- */

	/* ----- Row ----- */
	// Wrap cell content in a span for flexbox.
	$('.table-row td').wrapInner('<span></span>');

	// Cycle through each row...
	$('.table-row tr').each(function() {
		// And cycle through each td in that row...
	 $(this).find('td').each(function(i) {
			// And create an attribute with the value
			// of the th in its closest parent row.
			$(this).attr('data-header', $(this).closest('.table-row').find('tr th')[i].innerHTML);
		});
	});

	/* ----- BOTH ----- */
	// Wrap cell content in a span for flexbox.
	$('.table-both td').wrapInner('<span></span>');

	// Cycle through each row...
	$('.table-both tr').each(function() {
		// And cycle through each td in that row...
		$(this).find('td').each(function(i) {
			// And create an attribute with the value
			// of the th in its closest parent row
			// Except the first one, which is that
			// One in the corner.
			$(this).attr('data-header', $(this).closest('.table-both').find('tr th:not(:first-of-type)')[i].innerHTML);
		});
	});
	
});

