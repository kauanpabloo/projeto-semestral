// Função para abrir o modal
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Função para fechar o modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Função para confirmar a exclusão
function confirmExclusion() {
    // Lógica para excluir (pode ser chamada aqui)
    // ...

    // Fechar o modal após a confirmação
    closeModal();
}

// Adicionar um ouvinte de eventos ao botão que abre o modal
document.getElementById("openModalBtn").addEventListener("click", openModal);