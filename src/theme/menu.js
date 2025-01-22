function menu() {
   document.addEventListener('DOMContentLoaded', function() {
	  const submenus = document.querySelectorAll('.ctx-menu__item--has-children');
	  if(!submenus) return;
	  const menuToggles = document.querySelectorAll('.ctx-menu__item-arrow');

	  menuToggles.forEach((toggle) => {
	         toggle.addEventListener('click', function (event) {
	            submenus.forEach((submenu) => {
	               submenu.classList.remove('active');
	            });
	
	            const parentMenu = event.target.closest('.ctx-menu__item--has-children');
	            if (parentMenu) {
	               parentMenu.classList.toggle('active');
	            }
	         });
          });
   });
}

export default menu;
