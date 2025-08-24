document.addEventListener('DOMContentLoaded', () => {
    const carroForm = document.getElementById('carroForm');
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

    // Função para buscar e preencher as marcas
    async function loadMarcas() {
        try {
            const response = await fetch('/api.php/marcas', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });
            const marcas = await response.json();

            if (response.ok) {
                marcas.forEach(marca => {
                    const option = document.createElement('option');
                    option.value = marca.id;
                    option.textContent = marca.nome;
                    marcaSelect.appendChild(option);
                });
            } else {
                console.error('Erro ao carregar marcas:', marcas.message);
                messageDiv.textContent = 'Erro ao carregar marcas.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro de conexão ao carregar marcas:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para carregar marcas.';
            messageDiv.style.color = 'red';
        }
    }

    // Função para buscar e preencher os tipos de carro
    async function loadTiposCarro() {
        try {
            const response = await fetch('/api.php/tiposcarro', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });
            const tiposCarro = await response.json();

            if (response.ok) {
                tiposCarro.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.id;
                    option.textContent = tipo.nome;
                    tipoCarroSelect.appendChild(option);
                });
            } else {
                console.error('Erro ao carregar tipos de carro:', tiposCarro.message);
                messageDiv.textContent = 'Erro ao carregar tipos de carro.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro de conexão ao carregar tipos de carro:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor para carregar tipos de carro.';
            messageDiv.style.color = 'red';
        }
    }

    // Carregar dados ao iniciar a página
    loadMarcas();
    loadTiposCarro();

    carroForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = '';

        const modelo = carroForm.modelo.value;
        const ano = carroForm.ano.value;
        const cor = carroForm.cor.value;
        const marc-id = carroForm.marca.value;
        const tipo_carro_id = carroForm.tipo_carro.value;

        try {
            const response = await fetch('/api.php/carros', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwt}`
                },
                body: JSON.stringify({ modelo, ano, cor, marc-id, tipo_carro_id })
            });

            const data = await response.json();

            if (response.ok) {
                messageDiv.textContent = 'Carro cadastrado com sucesso!';
                messageDiv.style.color = 'green';
                carroForm.reset();
                // Recarregar dropdowns para garantir dados atualizados se necessário
                marcaSelect.innerHTML = '<option value="">Selecione uma marca</option>';
                tipoCarroSelect.innerHTML = '<option value="">Selecione um tipo de carro</option>';
                loadMarcas();
                loadTiposCarro();
            } else {
                messageDiv.textContent = data.message || 'Erro ao cadastrar carro.';
                messageDiv.style.color = 'red';
            }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            messageDiv.textContent = 'Não foi possível conectar com o servidor.';
            messageDiv.style.color = 'red';
        }
    });
});
