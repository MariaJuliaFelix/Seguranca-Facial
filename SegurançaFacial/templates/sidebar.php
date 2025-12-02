<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<button id="sidebarToggleBtn" class="sidebar-toggle">☰</button>

<button id="themeToggle" class="btn-theme-toggle">
    <div class="bolaa"></div>
</button>

<div class="sidebar">

    <div class="sidebar-header">
        <div class="logo-wrapper">
            <img src="../assets/logo-claro.svg" alt="Logo" class="sidebar-logo logo-light">
            <img src="../assets/logo-escuro.svg" alt="Logo" class="sidebar-logo logo-dark">
        </div>
        <h2>Segurança Facial</h2>
    </div>

    <p>Bem-vinda, <?php echo htmlspecialchars($nome_instituicao ?? 'Usuário'); ?></p>

    <ul>
        <li>
            <a href="../pages/painel.php">
                <img src="../assets/inicio.svg" class="sidebar-icon icon-original" alt="Ícone Início">
                <img src="../assets/inicio-branco.svg" class="sidebar-icon icon-branco" alt="Início">
                Início
            </a>
        </li>
        <li>
            <a href="../pages/cadastro_aluno.php">
                <img src="../assets/cadastrar-aluno.svg" class="sidebar-icon icon-original" alt="icone cadastrar aluno">
                <img src="../assets/cadastrar-aluno-branco.svg" class="sidebar-icon icon-branco" alt="cadastrar aluno">
                Cadastrar aluno
            </a>
        </li>
        <li>
            <a href="../pages/gerenciar_alunos.php">
                <img src="../assets/gerenciar-alunos.svg" class="sidebar-icon icon-original" alt="icone gerenciar alunos">
                <img src="../assets/gerenciar-alunos-branco.svg" class="sidebar-icon icon-branco" alt="gerenciar alunos">
                Gerenciar alunos
            </a>
        </li>
        <li>
            <a href="../pages/cadastro_responsavel.php">
                <img src="../assets/cadastrar-responsaveis.svg" class="sidebar-icon icon-original" alt="icone cadastrar responsaveis">
                <img src="../assets/cadastrar-responsaveis-branco.svg" class="sidebar-icon icon-branco" alt="cadastrar responsaveis">
                Cadastrar responsável
            </a>
        </li>
        <li>
            <a href="../pages/gerenciar_responsaveis.php">
                <img src="../assets/gerenciar-responsaveis.svg" class="sidebar-icon icon-original" alt="icone gerenciar responsaveis">
                <img src="../assets/gerenciar-responsaveis-branco.svg" class="sidebar-icon icon-branco" alt="gerenciar responsaveis">
                Gerenciar responsáveis
            </a>
        </li>
        <li>
            <a href="../pages/reconhecimento.php">
                <img src="../assets/reconhecimento.svg" class="sidebar-icon icon-original" alt="icone reconhecimento">
                <img src="../assets/reconhecimento-branco.svg" class="sidebar-icon icon-branco" alt="reconhecimento">
                Realizar reconhecimento
            </a>
        </li>
        <li>
            <a href="../pages/historico.php">
                <img src="../assets/historico-saida.svg" class="sidebar-icon icon-original" alt="icone historico-saida">
                <img src="../assets/historico-saida-branco.svg" class="sidebar-icon icon-branco" alt="historico saida">
                Histórico de saídas
            </a>
        </li>
        <li>
            <a href="../logout.php">
                <img src="../assets/sair.svg" class="sidebar-icon icon-original" alt="icone sair">
                <img src="../assets/sair-branco.svg" class="sidebar-icon icon-branco" alt="sair">
                Sair
            </a>
        </li>
    </ul>
    
</div>