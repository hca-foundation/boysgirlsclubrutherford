/* PAGINATION *********************************************************/

////////////////////////////////////////////////////////////////////////
/////// PAGINATION CODE ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

var pagination_html_container_selector = "";
var pagination_selector = "";
var pagination_per_page = 10;

function showPages(items, selected_page, per_page) {
	// Using the per page, hide all elements not in the current page
	var number_of_items = items.length;
	var last_page = Math.ceil(number_of_items / per_page);

	// Only have pages if there are more items than the number per page
	if(number_of_items > per_page) {
		var current_page = 1;
		var current_item = 0;
		while(current_item < items.length) {
			if(current_page === selected_page) {
				items[current_item].style.display = "table-row";
			} else {
				items[current_item].style.display = "none";
			}
			// Check if on a new page
			if((current_item % per_page) === per_page - 1) {
				current_page++;
			}
			// Increment current item before looping
			current_item++;
		}
	} else {
		// There are fewer items than the number per page, reset so ALL items are visible
		for(var i = 0; i < items.length; i++) {
			items[i].style.display = "table-row";
		}
	}
}

// Calculates the pagination navigation
// - selected_page - the page to select in the navigation
// - number_of_items - the total number of items
// - per_page - items per page
// RETURNS - HTML for the pagination
function setupPaginationNavigation(selected_page, number_of_items, per_page) {

	var pagination_html = '';
	
	// Only add pagination if more items than the per page
	if(number_of_items > per_page) {
		// pagination variables
		var total_pages_shown = 2; // total extra pages to show in the navigation around the current page
		var last_page = Math.ceil(number_of_items / per_page);
		var selected_page = parseInt(selected_page);
		var go_to_first = '<li><a onclick="changePage(1);return false;"><span>&lt;&lt;</span></a></li>';
		var go_to_last = '<li><a onclick="changePage(' + last_page + ');return false;"><span>&gt;&gt;</span></a></li>';
		var go_to_previous = "";
		var go_to_next = "";

		// build the pagination
		pagination_html = '<li class="active"><a onclick="return false;"><span>' + selected_page + '</span></a></li>';
		if(last_page >= selected_page) {
			// This is good, it means that the selected page isn't greater than our last page
			if (selected_page === 1 && selected_page !== last_page) {
				// first page
				var page_count = 0;
				var page_item = 2;
				// Add next page
				if(page_item <= last_page && page_count < total_pages_shown) {
					go_to_next = '<li><a onclick="changePage(' + page_item + ');return false;"><span>&gt;</span></a></li>';
				}
				while(page_item <= last_page && page_count < total_pages_shown) {
					var pagination_html = pagination_html + '<li><a onclick="changePage(' + page_item + ');return false;"><span>' + page_item + '</span></a></li>';
					page_count++;
					page_item++;
				}
				// Create the pagination html
				pagination_html = pagination_html + go_to_next + go_to_last;
			} else if (selected_page === last_page) {
				// last page
				var page_count = 0;
				var page_item = last_page - 1;
				// Add previous page
				if(page_item > 0 && page_count < total_pages_shown) {
					go_to_previous = '<li><a onclick="changePage(' + page_item + ');return false;"><span>&lt;</span></a></li>';
				}
				while(page_item > 0 && page_count < total_pages_shown) {
					var pagination_html = '<li><a onclick="changePage(' + page_item + ');return false;"><span>' + page_item + '</span></a></li>' + pagination_html;
					page_count++;
					page_item--;
				}
				pagination_html = go_to_first + go_to_previous + pagination_html;
			} else {
				// somewhere in the middle, show 1-2 on both end
				var pre_page_count = 0;
				var post_page_count = 0;
			
				// add pages before current page
				var page_item = selected_page - 1;
				// Add previous page
				if(page_item > 0 && pre_page_count < total_pages_shown) {
					go_to_previous = '<li><a onclick="changePage(' + page_item + ');return false;"><span>&lt;</span></a></li>';					
				}
				while(page_item > 0 && pre_page_count < total_pages_shown) {
					var pagination_html = '<li><a onclick="changePage(' + page_item + ');return false;"><span>' + page_item + '</span></a></li>' + pagination_html;
					pre_page_count++;
					page_item--;
				}
			
				// add pages after current page
				var page_item = selected_page + 1;
				// Add next page
				if(page_item <= last_page && post_page_count < total_pages_shown) {
					go_to_next = '<li><a onclick="changePage(' + page_item + ');return false;"><span>&gt;</span></a></li>';					
				}
				while(page_item <= last_page && post_page_count < total_pages_shown) {
					var pagination_html = pagination_html + '<li><a onclick="changePage(' + page_item + ');return false;"><span>' + page_item + '</span></a></li>';
					post_page_count++;
					page_item++;
				}
				pagination_html = go_to_first + go_to_previous + pagination_html + go_to_next + go_to_last;
			}
		}
	} else {
		pagination_html = '<li><span>1</span></li>';
	}

	// Add pagination HTML to sections
	var pagination_sections = jQuery(pagination_html_container_selector);
	for(var i = 0; i < pagination_sections.length; i++) {
		pagination_sections[i].innerHTML = pagination_html;
	}
}

/////////////////////////////////////////////////
/////////////////////////////////////////////////
//
// PRIMARY PAGINATION FUNCTION
//
// Initially used to setup pages and pagination
// - item_selector - CSS/jQuery selector to select all items needing pagination
// - pagination_html_container_selector - CSS/jQuery selector to select container
//					for where pagination HTML will be placed
// - selected_page - currently selected page
// - per_page - number of items per page
function setupPagination(item_selector, pagination_html_selector,
		 									selected_page, per_page) {
	// Show pages and setup pagination
	var items = jQuery(item_selector);
	pagination_selector = item_selector;
	pagination_html_container_selector = pagination_html_selector;
	pagination_per_page = per_page;
	showPages(items,1,per_page);
	
	// Fire Event passing active items
	var active_items = jQuery(item_selector+":visible");
	var status = {
		status: "Success",
		items: active_items
	};
	jQuery(document).trigger("setupPaginationComplete", status);

	// Return items
	return setupPaginationNavigation(1,items.length,per_page);
}

// Used to change the page - Generally used when you change the 'order' and need to sort new items
// calls shows the selected page and recalculates the pagination navigation
// - page_number - the page that is now selected
function changePage(page_number) {
	var page_number = parseInt(page_number);
	var items = jQuery(pagination_selector);
	var number_of_items = items.length;
	var per_page = pagination_per_page;
	var display_pagination = true;
	
	// Only need to worry about pagination if there are more items than the per_page value
	if(number_of_items <= per_page) {
		per_page = number_of_items;
		display_pagination = false;
	}
	if(number_of_items >= per_page) {
		showPages(items, page_number, per_page);
		setupPaginationNavigation(page_number, number_of_items, per_page);
	}
	// Fire Event passing active items
	var active_items = jQuery(pagination_selector+":visible");
	var status = {
		status: "Success",
		items: active_items,
		page: page_number,
		show_pagination: display_pagination
	};
	jQuery(document).trigger("changePageComplete", status);
}

// Used to change the results per page - results back to page 1, sets the global per page
// - per_page - the new number of items per page
function changeNumberPerPage(per_page) {
	pagination_per_page = parseInt(per_page);
	// This will fire the change page event
	changePage(1);
}

/* END PAGINATION *********************************************************/