function showMenu() {
    var submenu = document.getElementById( 'repositorySubMenu' );

    if( submenu.style.display == '' ){
	submenu.style.display = 'block';
    }
    else{
	submenu.style.display = '';
    }
}