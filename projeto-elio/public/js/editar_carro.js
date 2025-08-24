document.addEventListener('DOMContentLoaded', () => {
    const editCarroForm = document.getElementById('editCarroForm');
    const carroIdInput = document.getElementById('carroId');
    const modeloInput = document.getElementById('modelo');
    const anoInput = document.getElementById('ano');
    const corInput = document.getElementById('cor');
    const marcaSelect = document.getElementById('marca');
    const tipoCarroSelect = document.getElementById('tipo_carro');
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

    function getCarroIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    const carroId = getCarroIdFromUrl();
    if (!carroId) {
        messageDiv.textContent = 'ID do carro não fornecido.';
        messageDiv.style.color = 'red';
        return;
    }

    async function fetchData(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });
            if (!response.ok) {
                if (response.status === 401) {
                    localStorage.removeItem('jwt');
                    window.location.href = 'index.html';
                }
                const errorData = await response.json();
                throw new Error(errorData.message || `Erro na requisição: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar dados:', error);
            messageDiv.textContent = `Não foi possível conectar com o servidor para carregar dados: ${error.message}`;
            messageDiv.style.color = 'red';
            return [];
        }
    }

    let allMarcas = [];
    let allTiposCarro = [];

    async function loadDropdowns() {
        allMarcas = await fetchData('../api.php/marcas');
        allTiposCarro = await fetchData('../api.php/tiposcarro');

        marcaSelect.innerHTML = '<option value="">Selecione uma marca</option>';
        allMarcas.forEach(marca => {
            const option = document.createElement('option');
            option.value = marca.id;
            option.textContent = marca.nome;
            if (selectedMarcaId == marca.id) {
                option.selected = true;
            }
            marcaSelect.appendChild(option);
        });

        tipoCarroSelect.innerHTML = '<option value="">Selecione um tipo de carro</option>';
        allTiposCarro.forEach(tipo => {
            const option = document.createElement('option');
            option.value = tipo.id;
            option.textContent = tipo.nome;
            if (selectedTipoCarroId == tipo.id) {
                option.selected = true;
            }
            tipoCarroSelect.appendChild(option);
        });
    }

    async function loadCarroData() {
        try {
            const carro = await fetchData(`../api.php/carros/${carroId}`);

            if (carro && Object.keys(carro).length > 0) { // Verifica se o objeto carro não está vazio
                carroIdInput.value = carro.id;
                modeloInput.value = carro.modelo;
                anoInput.value = carro.ano;
                corInput.value = carro.cor;
                await loadDropdowns(carro.marc_id, carro.tipo_carro_id);
            } else {
                messageDiv.textContent = 'Carro não encontrado ou erro ao carregar dados.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao carregar dados do carro:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para carregar o carro.';
            messageDiv.style.color = 'red';
        }
    }

    loadCarroData();

    editCarroForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = '';

        const modelo = modeloInput.value;
        const ano = anoInput.value;
        const cor = corInput.value;
        const marc_id = marcaSelect.value;
        const tipo_carro_id = tipoCarroSelect.value;

        try {
            const response = await fetch(`../api.php/carros/${carroId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwt}`
                },
                body: JSON.stringify({ modelo, ano, cor, marc_id, tipo_carro_id })
            });

            const data = await response.json();

            if (response.ok) {
                messageDiv.textContent = 'Carro atualizado com sucesso!';
                messageDiv.style.color = 'green';
            } else {
                messageDiv.textContent = data.message || 'Erro ao atualizar carro.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para atualizar o carro.';
            messageDiv.style.color = 'red';
        }
    });
});
