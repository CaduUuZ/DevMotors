// Função para alternar o estado da barra lateral (abrir/fechar)
function toggleSidebar() {
    // Seleciona o elemento com a classe 'sidebar'
    let sidebar = document.querySelector('.sidebar');
    // Alterna a classe 'closed' no elemento selecionado
    // Isso é usado para abrir ou fechar a barra lateral, dependendo do estado atual
    sidebar.classList.toggle('closed');
}
