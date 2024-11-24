<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="CSS/Cadastro.css">
    <link rel="shortcut icon" href="Favicon/Anel pintado.png" type="image/x-icon">
    <style>
        @font-face {
            font-family: poppins;
            src: url('Fonts/poppins-light-webfont.woff2') format('woff2');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: poppins;
            src: url('Fonts/poppins-regular-webfont.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>
<body>
    <!-- Fundo da página -->
    <div class="fundo">
        <img src="Imagem/Background-Banner-Desktop.webp" alt="Imagem de fundo">
    </div>
    
    <div class="container">
        <h2>Criar conta</h2>
        <form id="forms" method="POST" action="PHP/processa_cadastro.php">
            <!-- Nome -->
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>

            <!-- Nome Materno -->
            <div class="form-group">
                <label for="nome_materno">Nome Materno:</label>
                <input type="text" id="nome_materno" name="nome_materno" placeholder="Nome da sua mãe" required>
            </div>

            <!-- CPF -->
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="000.000.000-00" required>
                <!-- <p id="cpf-validation-message" aria-live="polite"></p> -->
                <p id="cpf-error-message" class="error-message"></p>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">E-mail (Login):</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <!-- Senha -->
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Crie uma senha forte" required>
            </div>

            <!-- Confirmação de Senha -->
            <div class="form-group">
                <label for="senha_confirmacao">Confirme sua senha:</label>
                <input type="password" id="senha_confirmacao" name="senha_confirmacao" placeholder="Repita sua senha" required>
            </div>

            <!-- CEP -->
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" maxlength="9"  required>
            </div>

            <!-- Endereço -->
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, avenida, etc." required>
            </div>

            <!-- Complemento -->
            <div class="form-group">
                <label for="complemento">complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Casa 1, etc." required>
            </div>

            <!-- Bairro -->
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro" required>
            </div>

            <!-- Cidade -->
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">Você mora em:</label>
                <select id="estado" name="estado" required>
                    <option value="">Selecione</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ" SELECTED>Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                    <option value="EX">Estrangeiro</option>
                </select>
            </div>


            <!-- Data de Casamento -->
            <div class="form-group">
                <label for="data">Data de Nascimento:</label>
                <input type="date" id="data" name="data" required>
            </div>

            <!-- Telefone Celular -->
            <div class="form-group">
                <label for="telefoneCelular">Telefone Celular:</label>
                <input type="tel" id="telefoneCelular" name="telefoneCelular" placeholder="+xx(xx) xxxxx-xxxx" maxlength="20" required>
            </div>

            <!-- Sexo -->
            <div class="form-group-full">
                <label>Sexo:</label>
                <select name="genero" id="genero" required>
                    <option value="Masculino" selected>Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>

            <!-- Aceitação de Termos -->
            <div class="form-group-full checkbox-container">
                <input type="checkbox" id="termos" name="termos" required>
                <label for="termos">Aceito as condições de uso e de <a href="#">Privacidade</a>.</label>
            </div>

            <!-- Botões -->
            <button type="submit">Criar conta</button>
            <button type="reset">Limpar Campos</button>
        </form>

        <div class="login-link">
            Já tem uma conta? <a href="login.php">Entrar</a>
        </div>
        <div id="mensagemErro" style="color:red; display:none;"></div>
        
        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'duplicidade'): ?>
            <p style="color: red;">Email ou CPF já cadastrado!</p>
        <?php endif; ?>
    
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'true'): ?>
            <p style="color: green;">Cadastro realizado com sucesso!</p>
        <?php endif; ?>

    </div>

   <script src="JS/script_cadastro.js"></script> 
</body>
</html>
