document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("cpf");
    const telefoneInput = document.getElementById("telefoneCelular");
    const senhaInput = document.getElementById("senha");
    const senhaConfirmacaoInput = document.getElementById("senha_confirmacao");
    const formulario = document.getElementById("forms");

    // Função para validar o CPF
    function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    return resto === parseInt(cpf.charAt(10));
    }
    
    // Evento de validação do CPF
    document.getElementById('cpf').addEventListener('blur', function () {
    const cpfInput = this;
    const errorMessage = document.getElementById('cpf-error-message');

    if (!validarCPF(cpfInput.value)) {
        errorMessage.textContent = 'CPF inválido! Por favor, insira um CPF válido.';
        cpfInput.classList.add('input-error'); // Adiciona uma classe de erro para destacar o campo
    } else {
        errorMessage.textContent = '';
        cpfInput.classList.remove('input-error'); // Remove a classe de erro se o CPF for válido
    }
    });

    // Impede o envio do formulário com CPF inválido
    document.getElementById('forms').addEventListener('submit', function (event) {
    const cpfInput = document.getElementById('cpf');
    const errorMessage = document.getElementById('cpf-error-message');

    if (!validarCPF(cpfInput.value)) {
        errorMessage.textContent = 'CPF inválido! Por favor, insira um CPF válido.';
        cpfInput.classList.add('input-error');
        event.preventDefault(); // Impede o envio do formulário
        }
    });


    // Formatar CPF no formato 000.000.000-00
    cpfInput.addEventListener("input", function () {
        let cpf = cpfInput.value.replace(/[^\d]/g, ""); // Remove caracteres não numéricos
        if (cpf.length > 11) cpf = cpf.slice(0, 11);

        cpfInput.value = cpf
            .replace(/(\d{3})(\d)/, "$1.$2")
            .replace(/(\d{3})(\d)/, "$1.$2")
            .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    });

    // Verificar se o CPF é válido ao sair do campo
    cpfInput.addEventListener("blur", function () {
        const mensagem = document.getElementById("cpf-validation-message");
        if (!validarCPF(cpfInput.value)) {
            mensagem.textContent = "CPF inválido!";
            mensagem.style.color = "red";
            cpfInput.style.borderColor = "red";
        } else {
            mensagem.textContent = "";
            cpfInput.style.borderColor = "";
        }
    });
    
    
    // Confirmação de senhas
    // Criar elemento para mensagem de erro
    const mensagemErro = document.createElement("p");
    mensagemErro.id = "senha-erro";
    mensagemErro.style.color = "red";
    mensagemErro.style.fontSize = "0.9em";
    mensagemErro.style.marginTop = "5px";
    senhaConfirmacaoInput.parentNode.appendChild(mensagemErro);

    // Função para verificar se as senhas coincidem
    function validarSenhas() {
        const senha = senhaInput.value.trim();
        const senhaConfirmacao = senhaConfirmacaoInput.value.trim();

        if (senha !== senhaConfirmacao) {
            mensagemErro.textContent = "As senhas não coincidem.";
            return false;
        } else {
            mensagemErro.textContent = "";
            return true;
        }
    }

    // Validar ao digitar no campo de confirmação
    senhaConfirmacaoInput.addEventListener("input", validarSenhas);

    // Bloquear envio do formulário se as senhas não coincidirem
    formulario.addEventListener("submit", function (event) {
        if (!validarSenhas()) {
            event.preventDefault(); // Impede o envio do formulário
        }
    });
    


    //Formata Telefone celular
    telefoneInput.addEventListener("input", function () {
        let telefone = telefoneInput.value.replace(/[^\d]/g, ""); // Remove caracteres não numéricos

        if (telefone.length > 13) {
            telefone = telefone.slice(0, 13); // Limita o número máximo de caracteres numéricos
        }

        // Adiciona o formato +00(00)00000-0000
        if (telefone.length <= 2) {
            telefoneInput.value = `+${telefone}`;
        } else if (telefone.length <= 4) {
            telefoneInput.value = `+${telefone.slice(0, 2)}(${telefone.slice(2)}`;
        } else if (telefone.length <= 9) {
            telefoneInput.value = `+${telefone.slice(0, 2)}(${telefone.slice(2, 4)})${telefone.slice(4)}`;
        } else {
            telefoneInput.value = `+${telefone.slice(0, 2)}(${telefone.slice(2, 4)})${telefone.slice(4, 9)}-${telefone.slice(9)}`;
        }
    });
});
