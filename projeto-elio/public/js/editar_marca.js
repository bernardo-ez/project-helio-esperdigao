document.addEventListener('DOMContentLoaded', () => {
    const editMarcaForm = document.getElementById('editMarcaForm');
    const marcaIdInput = document.getElementById('marcaId');
    const nomeInput = document.getElementById('nome');
    const messageDiv = document.getElementById('message');

    function checkAuth() {
        const jwt = localStorage.getItem('jwt');
        if (!jwt) {
            window.location.href = 'index.html';
            return false;
        }
        return jwt;
    }

    const jwt = checkAuth();
    if (!jwt) return;

    // Função para obter o ID da URL
    function getMarcaIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    const marcaId = getMarcaIdFromUrl();
    if (!marcaId) {
        messageDiv.textContent = 'ID da marca não fornecido.';
        messageDiv.style.color = 'red';
        return;
    }

    // Função para carregar os dados da marca
    async function loadMarcaData() {
        try {
            const response = await fetch(`../api.php/marcas/${marcaId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });

            const data = await response.json();

            if (response.ok) {
                marcaIdInput.value = data.id;
                nomeInput.value = data.nome;
            } else {
                messageDiv.textContent = data.message || 'Erro ao carregar dados da marca.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para carregar a marca.';
            messageDiv.style.color = 'red';
        }
    }

    loadMarcaData();

    editMarcaForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = '';

        const nome = nomeInput.value;

        try {
            const response = await fetch(`../api.php/marcas/${marcaId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwt}`
                },
                body: JSON.stringify({ nome })
            });

            const data = await response.json();

            if (response.ok) {
                messageDiv.textContent = 'Marca atualizada com sucesso!';
                messageDiv.style.color = 'green';
            } else {
                messageDiv.textContent = data.message || 'Erro ao atualizar marca.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para atualizar a marca.';
            messageDiv.style.color = 'red';
        }
    });
});
