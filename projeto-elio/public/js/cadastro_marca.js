document.addEventListener('DOMContentLoaded', () => {
    const marcaForm = document.getElementById('marcaForm');
    const messageDiv = document.getElementById('message');

    // Função para verificar o token JWT e redirecionar se não houver
    function checkAuth() {
        const jwt = localStorage.getItem('jwt');
        if (!jwt) {
            window.location.href = 'index.html'; // Redireciona para o login
            return false;
        }
        return jwt;
    }

    const jwt = checkAuth();
    if (!jwt) return; // Interrompe se não houver token

    marcaForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = '';

        const nome = marcaForm.nome.value;

        try {
            const response = await fetch('../api.php/marcas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwt}`
                },
                body: JSON.stringify({ nome })
            });

            const data = await response.json();

            if (response.ok) {
                messageDiv.textContent = 'Marca cadastrada com sucesso!';
                messageDiv.style.color = 'green';
                marcaForm.reset(); // Limpa o formulário
            } else {
                messageDiv.textContent = data.message || 'Erro ao cadastrar marca.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor.';
            messageDiv.style.color = 'red';
        }
    });
});
