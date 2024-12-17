function menu() {
   document.addEventListener('DOMContentLoaded', function() {
	  const submenus = document.querySelector('.ctx-menu__item--has-children');
	  if(!submenus) return;
	  const menuToggle = document.querySelector('.ctx-menu__item-arrow');

	  menuToggle.addEventListener('click', function(event) {
		 for (let i = 0; i < submenus.length; i++) {
			submenus[i].classList.remove('ctx-menu__item--has-children--open');
		 }

		 event.target.closest('.ctx-menu__item--has-children').classList.toggle('active');
	  });
   });
}

export default menu;