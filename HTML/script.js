const telefoneInput = document.getElementById("telefone");

IMask(telefoneInput, {
    mask: "(00) 00000-0000",
    lazy: false, 
    placeholderChar: "_" 
});
//icones para requisição  
function exibirMensagem(tipo, texto) {
    const mensagemPopup = document.getElementById("mensagem-popup");
    const icone = document.getElementById("icone");
    const mensagemTexto = document.getElementById("mensagem-texto");

   
    mensagemTexto.textContent = texto;
    if (tipo === "sucesso") {
        mensagemPopup.className = "sucesso ativo";
        icone.textContent = "✔️"; 
    } else if (tipo === "erro") {
        mensagemPopup.className = "erro ativo";
        icone.textContent = "❌"; 
    }

    setTimeout(() => {
        mensagemPopup.classList.remove("ativo");
        setTimeout(() => {
            mensagemPopup.style.display = "none";
        }, 500); 
    }, 3000);
}
//resposta para a solicitação 
document.getElementById("formulario").addEventListener("submit", function (e) {
    e.preventDefault(); 

    const formData = new FormData(this); 

    fetch("processar-formulario.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.text()) 
        .then((data) => {
            if (data.includes("sucesso")) {
                exibirMensagem("sucesso", "Solicitação enviada com sucesso!");
            } else {
                exibirMensagem("erro", "Erro ao enviar a solicitação: " + data);
            }
        })
        .catch((error) => {
            exibirMensagem("erro", "Erro ao enviar os dados: " + error.message);
        });
});
