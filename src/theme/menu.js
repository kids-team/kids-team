function menu() {
   document.addEventListener('DOMContentLoaded', function() {
	  const submenus = document.querySelectorAll('.ctx-menu__item--has-children');
	  if(!submenus) return;
	  const menuToggle = document.querySelectorAll('.ctx-menu__item-arrow');

	  menuToggles.forEach((toggle) => {
	         toggle.addEventListener('click', function (event) {
	            submenus.forEach((submenu) => {
	               submenu.classList.remove('ctx-menu__item--has-children--open');
	            });
	
	            const parentMenu = event.target.closest('.ctx-menu__item--has-children');
	            if (parentMenu) {
	               parentMenu.classList.toggle('ctx-menu__item--has-children--open');
	            }
	         });
          });
   });
}

export default menu;
