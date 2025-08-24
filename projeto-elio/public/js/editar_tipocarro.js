document.addEventListener('DOMContentLoaded', () => {
    const editTipoCarroForm = document.getElementById('editTipoCarroForm');
    const tipoCarroIdInput = document.getElementById('tipoCarroId');
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
    function getTipoCarroIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    const tipoCarroId = getTipoCarroIdFromUrl();
    if (!tipoCarroId) {
        messageDiv.textContent = 'ID do tipo de carro não fornecido.';
        messageDiv.style.color = 'red';
        return;
    }

    // Função para carregar os dados do tipo de carro
    async function loadTipoCarroData() {
        try {
            const response = await fetch(`../api.php/tiposcarro/${tipoCarroId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });

            const data = await response.json();

            if (response.ok) {
                tipoCarroIdInput.value = data.id;
                nomeInput.value = data.nome;
            } else {
                messageDiv.textContent = data.message || 'Erro ao carregar dados do tipo de carro.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para carregar o tipo de carro.';
            messageDiv.style.color = 'red';
        }
    }

    loadTipoCarroData();

    editTipoCarroForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = '';

        const nome = nomeInput.value;

        try {
            const response = await fetch(`../api.php/tiposcarro/${tipoCarroId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwt}`
                },
                body: JSON.stringify({ nome })
            });

            const data = await response.json();

            if (response.ok) {
                messageDiv.textContent = 'Tipo de Carro atualizado com sucesso!';
                messageDiv.style.color = 'green';
            } else {
                messageDiv.textContent = data.message || 'Erro ao atualizar tipo de carro.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para atualizar o tipo de carro.';
            messageDiv.style.color = 'red';
        }
    });
});
