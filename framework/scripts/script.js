function showMenu( basename) {
    var submenu = document.getElementById( basename + 'SubMenu' );

    if( submenu.style.display == '' ){
	submenu.style.display = 'block';
    }
    else{
	submenu.style.display = '';
    }
}