function handlePaginationClick( new_page_index, pagination_container ) {
	var content = '';
	for( var i=new_page_index; i < commits.length; i++ ) {
		content += '<div id="commit' + i + '" class="commit">';
		content += '<h3>'+ commits[i]['commitMessage'] + '</h3>';
		content += '<p><span class="descriptor">Commit:</span>' + commits[i]['commitVal'] + '</p>';
		content += '<p><span class="descriptor">Date:</span>' + commits[i]['commitDateTime'] + '</p>';
		content += '<div id="files' + i + '">';
		content += '<p class="descriptor">Files changed:</p>';
		content += '<table class="filechange">';
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

$(document).ready(function() {
	$("#pagination").pagination( commits.length, {
		items_per_page:25,
		callback:handlePaginationClick } );
});
