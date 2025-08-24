document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logoutButton');

    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            localStorage.removeItem('jwt'); // Remove o token JWT do localStorage
            window.location.href = 'index.html'; // Redireciona para a página de login
        });
    }

    // Opcional: Verificar se o token JWT existe ao carregar a página
    // para evitar acesso direto ao dashboard sem login.
    const jwt = localStorage.getItem('jwt');
    if (!jwt) {
        window.location.href = 'index.html';
    }
});
