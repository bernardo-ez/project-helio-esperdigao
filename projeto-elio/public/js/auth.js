document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorMessage.textContent = ''; // Limpa mensagens de erro anteriores

            const username = loginForm.username.value;
            const password = loginForm.password.value;

            try {
                const response = await fetch('../api.php/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ username, password }),
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('jwt', data.jwt);
                    alert('Login bem-sucedido!');
                    // Redirecionar para a página principal ou dashboard
                    window.location.href = 'dashboard.html'; // Precisaremos criar esta página
                } else {
                    errorMessage.textContent = data.message || 'Erro no login.';
                }
            } catch (error) {
                console.error('Erro ao conectar com a API:', error);
                errorMessage.textContent = 'Não foi possível conectar com o servidor.';
            }
        });
    }
});
