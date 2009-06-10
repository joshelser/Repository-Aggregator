function showFileChanges( id ) {
	var name = '#filechange' + id;
	var image = '#image' + id;
	if( $(name).css('display') == 'none' ) {
		$(name).css( {'display': ''} );
		$(image).attr( 'src', 'images/minussign.png' );
	}
	else {
		$(name).css( {'display': 'none'} );
		$(image).attr( 'src', 'images/plussign.png' );
	}
}


