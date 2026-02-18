document.addEventListener('DOMContentLoaded', () => {
	const userButton = document.getElementById('user-button');
	const dropdown = document.getElementById('user-dropdown');

	if (!userButton || !dropdown) return;

	userButton.addEventListener('click', (e) => {
		e.preventDefault();
		const isShown = dropdown.classList.toggle('show');
		dropdown.setAttribute('aria-hidden', (!isShown).toString());
	});

	// Close when clicking outside
	document.addEventListener('click', (e) => {
		if (!e.target.closest('.user-menu')) {
			dropdown.classList.remove('show');
			dropdown.setAttribute('aria-hidden', 'true');
		}
	});

	// Close on Escape
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			dropdown.classList.remove('show');
			dropdown.setAttribute('aria-hidden', 'true');
		}
	});

	// Placeholder handlers for menu actions
	const logout = document.getElementById('logout');
	const editProfile = document.getElementById('edit-profile');

	if (logout) {
		logout.addEventListener('click', (e) => {
			e.preventDefault();
			dropdown.classList.remove('show');
			alert('Sair — implementar lógica de logout aqui.');
		});
	}

	if (editProfile) {
		editProfile.addEventListener('click', (e) => {
			e.preventDefault();
			dropdown.classList.remove('show');
			alert('Editar perfil — abrir formulário de edição aqui.');
		});
	}
});

