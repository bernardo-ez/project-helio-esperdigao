document.addEventListener('DOMContentLoaded', () => {
    const marcasTableBody = document.querySelector('#marcasTable tbody');
    const tiposCarroTableBody = document.querySelector('#tiposCarroTable tbody');
    const carrosTableBody = document.querySelector('#carrosTable tbody');

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

    async function fetchData(url) {
        try {
            const response = await fetch(`../api.php${url}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('jwt')}`
                }
            });
            if (!response.ok) {
                if (response.status === 401) {
                    // Token inválido ou expirado, redirecionar para login
                    localStorage.removeItem('jwt');
                    window.location.href = 'index.html';
                }
                const errorData = await response.json();
                throw new Error(errorData.message || `Erro na requisição: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar dados:', error);
            alert(`Erro ao carregar dados: ${error.message}`);
            return [];
        }
    }

    async function deleteEntity(type, id) {
        const confirmed = confirm(`Tem certeza que deseja excluir este ${type} (ID: ${id})?`);
        if (!confirmed) return;

        try {
            const response = await fetch(`../api.php/${type}s/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${jwt}`
                }
            });

            if (response.ok) {
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} excluído(a) com sucesso!`);
                // Recarregar a lista correspondente
                if (type === 'marca') await loadMarcas();
                else if (type === 'tipocarro') await loadTiposCarro();
                else if (type === 'carro') await loadCarros();
            } else {
                const errorData = await response.json();
                alert(`Erro ao excluir ${type}: ${errorData.message || response.statusText}`);
            }
        } catch (error) {
            console.error(`Erro ao conectar com a API para exclusão de ${type}:`, error);
            alert(`Não foi possível conectar com o servidor para excluir ${type}.`);
        }
    }

    async function loadMarcas() {
        marcasTableBody.innerHTML = '';
        const marcas = await fetchData('/marcas');
        marcas.forEach(marca => {
            const row = marcasTableBody.insertRow();
            row.insertCell().textContent = marca.id;
            row.insertCell().textContent = marca.nome;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <button class="edit-btn" data-id="${marca.id}" data-type="marca">Editar</button>
                <button class="delete-btn" data-id="${marca.id}" data-type="marca">Excluir</button>
            `;
        });
    }

    async function loadTiposCarro() {
        tiposCarroTableBody.innerHTML = '';
        const tiposCarro = await fetchData('/tiposcarro');
        tiposCarro.forEach(tipo => {
            const row = tiposCarroTableBody.insertRow();
            row.insertCell().textContent = tipo.id;
            row.insertCell().textContent = tipo.nome;
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <button class="edit-btn" data-id="${tipo.id}" data-type="tipocarro">Editar</button>
                <button class="delete-btn" data-id="${tipo.id}" data-type="tipocarro">Excluir</button>
            `;
        });
    }

    async function loadCarros() {
        carrosTableBody.innerHTML = '';
        const carros = await fetchData('/carros');
        carros.forEach(carro => {
            const row = carrosTableBody.insertRow();
            row.insertCell().textContent = carro.id;
            row.insertCell().textContent = carro.modelo;
            row.insertCell().textContent = carro.ano;
            row.insertCell().textContent = carro.cor;
            row.insertCell().textContent = carro.marca_nome; // Assumindo que a API retorna o nome da marca
            row.insertCell().textContent = carro.tipo_carro_nome; // Assumindo que a API retorna o nome do tipo de carro
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <button class="edit-btn" data-id="${carro.id}" data-type="carro">Editar</button>
                <button class="delete-btn" data-id="${carro.id}" data-type="carro">Excluir</button>
            `;
        });
    }

    // Carregar todas as listas ao carregar a página
    loadMarcas();
    loadTiposCarro();
    loadCarros();

    document.addEventListener('click', async (e) => {
        if (e.target.classList.contains('edit-btn')) {
            const id = e.target.dataset.id;
            const type = e.target.dataset.type;
            
            if (type === 'marca') {
                window.location.href = `editar_marca.html?id=${id}`;
            } else if (type === 'tipocarro') {
                window.location.href = `editar_tipocarro.html?id=${id}`;
            } else if (type === 'carro') {
                window.location.href = `editar_carro.html?id=${id}`;
            }
        } else if (e.target.classList.contains('delete-btn')) {
            const id = e.target.dataset.id;
            const type = e.target.dataset.type;
            await deleteEntity(type, id);
        }
    });
});
