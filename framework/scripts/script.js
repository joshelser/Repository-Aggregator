function handlePaginationClick( new_page_index, pagination_container ) {
	var items_per_page = 10;
	var max_elem = Math.min( ( new_page_index + 1 ) * items_per_page, commits.length );
	var content = '';
	for( var i=new_page_index*items_per_page; i < max_elem; i++ ) {
		content += '<div id="commit' + i + '" class="commit">';
		content += '<h3>'+ commits[i]['commitMessage'] + '</h3>';
		content += '<p><span class="descriptor">Commit:</span>' + commits[i]['commitVal'] + '</p>';
		content += '<p><span class="descriptor">Date:</span>' + commits[i]['commitDateTime'] + '</p>';
		content += '<div id="files' + i + '">';
		content += '<p class="descriptor" onclick="showFileChanges( ' + i + ' )">Files changed:</p>';
		content += '<table id="filechange' + i + '" class="filechange" style="display:none">';
		content += '<tr>';
		content += '<th>Filename:</th><th>Insertions:</th><th>Deletions:</th>';
		content += '</tr>';

		for( var j = 0; j < commits[i]['filechanges'].length; j++ ) {
			content += '<tr>';
			content += '<td>' + commits[i]['filechanges'][j]['file'] + '</td>';
			content += '<td>' + commits[i]['filechanges'][j]['insertions'] + '</td>';
			content += '<td>' + commits[i]['filechanges'][j]['deletions'] + '</td>';
			content += '</tr>';
		}

		content += '</table>';
		content += '</div>';
		content += '</div><br />';

		if( i != commits.length -1 ) {
			content += "\n<br />\n";
		}
	}

	$('#commits').html( content );

	return false;
}

function showFileChanges( id ) {
	var name = '#filechange' + id;
	if( $(name).css('display') == 'none' ) {
		$(name).css( {'display': ''} );
	}
	else {
		$(name).css( {'display': 'none'} );
	}
}

$(document).ready(function() {
	$("#pagination").pagination( commits.length, {
		items_per_page:10,
		num_display_entries:10,
		num_edge_entries:2,
		callback:handlePaginationClick } );


	$("#paginationbottom").pagination( commits.length, {
		items_per_page:10,
		num_display_entries:10,
		num_edge_entries:2,
		callback:handlePaginationClick } );
	}
);


