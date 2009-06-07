function showFileChanges( id ) {
	var name = '#filechange' + id;
	if( $(name).css('display') == 'none' ) {
		$(name).css( {'display': ''} );
	}
	else {
		$(name).css( {'display': 'none'} );
	}
}


