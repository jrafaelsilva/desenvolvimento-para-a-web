<?php
session_start();
require('includes/connection.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_receita = $_GET['id'];

$sql = "SELECT r.*, 
               c.id as id_chef, c.nome as nome_chef, c.imagem as imagem_chef,
               u.iduser as id_utilizador, u.utilizador as nome_utilizador, dp.avatar as avatar_utilizador
        FROM receitas r 
        LEFT JOIN chefs c ON r.id_chef = c.id 
        LEFT JOIN utilizadores u ON r.id_utilizador = u.iduser
        LEFT JOIN dados_perfil dp ON u.iduser = dp.id_utilizador
        WHERE r.id = ?"; 
$stmt = $dbh->prepare($sql);
$stmt->execute([$id_receita]);
$receita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receita) {
    echo "Receita não encontrada.";
    exit;
}

//  Buscar Ingredientes
$stmtIng = $dbh->prepare("SELECT * FROM ingredientes WHERE id_receita = ?");
$stmtIng->execute([$id_receita]);
$ingredientes = $stmtIng->fetchAll(PDO::FETCH_ASSOC);

//  Buscar Passos de Preparação
$stmtPrep = $dbh->prepare("SELECT * FROM preparacao WHERE id_receita = ? ORDER BY ordem ASC");
$stmtPrep->execute([$id_receita]);
$passos = $stmtPrep->fetchAll(PDO::FETCH_ASSOC);

//  Buscar Comentários
$sqlComentarios = "
    SELECT c.*, u.utilizador, dp.avatar 
    FROM comentarios c 
    JOIN utilizadores u ON c.id_utilizador = u.iduser 
    LEFT JOIN dados_perfil dp ON u.iduser = dp.id_utilizador
    WHERE c.id_receita = ? 
    ORDER BY c.data_comentario DESC
";
$stmtComments = $dbh->prepare($sqlComentarios);
$stmtComments->execute([$id_receita]);
$lista_comentarios = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

//  Verificar Favorito 
$e_favorito = false;
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    $id_user_logado = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];
    
    $checkFav = $dbh->prepare("SELECT id FROM favoritos WHERE id_utilizador = ? AND id_receita = ? AND ativado = 1");
    $checkFav->execute([$id_user_logado, $id_receita]);
    
    if ($checkFav->rowCount() > 0) {
        $e_favorito = true;
    }
}
$classe_coracao = $e_favorito ? "text-danger" : "text-secondary";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($receita['titulo']); ?> </title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php require('includes/nav.php'); ?>

    <div class="ms-3 mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <?php
            // Mapear o URL para o Nome na Base de Dados
                $mapa_slugs = [
                    'Receitas de carne' => 'carne',
                    'Peixe'             => 'peixe',
                    'Sobremesa'         => 'sobremesa',
                    'Sopas e Cremes'    => 'sopa',
                    'Comunidade'        => 'comunidade'
                ];
                
                $catNome = $receita['categoria'];
                $catLink = isset($mapa_slugs[$catNome]) ? "categoria.php?tipo=" . $mapa_slugs[$catNome] : "#";?>
            <li class="breadcrumb-item"><a href="<?php echo $catLink; ?>"><?php echo htmlspecialchars($catNome); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($receita['titulo']); ?></li>
        </ol>
    </div>

<div class="container">
        <div class="fw-bold mb-4 mt-5 fs-2 text-center"><?php echo htmlspecialchars($receita['titulo']); ?></div>
        
        <?php 
            // Determinar se existe um autor (Chef ou Utilizador)
            $temAutor = !empty($receita['id_chef']) || !empty($receita['id_utilizador']);
            
            // Variáveis para preencher o cartão
            $nomeAutor = "";
            $imgAutor = "imgs/avatar/avpadrao.jpg";
            $linkAutor = "#";
            $labelAutor = "";
            $classeLink = "text-decoration-none text-dark d-flex flex-column flex-lg-row align-items-center mt-3 p-2 rounded hover-bg-white transition";

            if ($temAutor) {
                if (!empty($receita['id_chef'])) {
                    // É UM CHEF
                    $nomeAutor = $receita['nome_chef'];
                    $labelAutor = "Receita do Chef:";
                    $linkAutor = "chefs.php#chef-" . $receita['id_chef'];
                    if (!empty($receita['imagem_chef']) && file_exists($receita['imagem_chef'])) {
                        $imgAutor = $receita['imagem_chef'];
                    }
                } else {
                    // É UM UTILIZADOR DA COMUNIDADE
                    $nomeAutor = $receita['nome_utilizador'];
                    $labelAutor = "Receita da Comunidade:";
                    $linkAutor = "#"; 
                    $classeLink = "text-decoration-none text-dark d-flex flex-column flex-lg-row align-items-center mt-3 p-2 rounded"; 

                    $avatar_db = $receita['avatar_utilizador'];
                    if (!empty($avatar_db) && $avatar_db != 'default') {
                        if (file_exists("imgs/avatar/" . $avatar_db)) {
                            $imgAutor = "imgs/avatar/" . $avatar_db;
                        } elseif (file_exists($avatar_db)) {
                            $imgAutor = $avatar_db;
                        }
                    }
                }
            }
        ?>

        <?php if ($temAutor): ?>
            
            <!--  TEM AUTOR  -->
            <div class="row justify-content-center align-items-start mb-3">
                
                <!-- Imagem da Receita -->
                <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                    <img src="<?php echo htmlspecialchars($receita['imagem']); ?>" 
                         class="img-fluid w-100 border border-4 rounded shadow-sm" 
                         style="max-height: 600px; object-fit: cover; "
                         alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                </div>

                <!--  Autor e Temporizador -->
                <div class="col-12 col-lg-4">
                    
                    <div class="row align-items-center">
                        
                        <!--  CARTÃO DO AUTOR  -->
                        <div class="col-12 col-md-6 col-lg-12 mb-3">
                            <div class="card border-0 shadow-sm bg-light rounded-4 p-3 h-100">
                                <div class="card-body text-center text-lg-start">
                                    <small class="text-uppercase text-muted fw-bold ls-1"><?php echo $labelAutor; ?></small>
                                    
                                    <a href="<?php echo $linkAutor; ?>" class="<?php echo $classeLink; ?>">
                                        <img src="<?php echo $imgAutor; ?>" 
                                             class="rounded-circle border border-2 border-white shadow-sm mb-2 mb-lg-0 me-lg-3" 
                                             style="width: 80px; height: 80px; object-fit: cover;" 
                                             alt="<?php echo htmlspecialchars($nomeAutor); ?>">
                                        
                                        <div>
                                            <h5 class="fw-bold mb-0 text-break"><?php echo htmlspecialchars($nomeAutor); ?></h5>
                                            <?php if (!empty($receita['id_chef'])): ?>
                                                <small class="text-primary fw-semibold">Ver perfil <i class="bi bi-arrow-right"></i></small>
                                            <?php else: ?>
                                                <small class="text-success fw-semibold"><i class="bi bi-star-fill"></i> Membro verificado</small>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <!--  TEMPORIZADOR -->
                        <div class="col-12 col-md-6 col-lg-12">
                            <div id="timer-wrapper" class="text-center my-4">
                                <h4 class="fw-bold mb-1">Temporizador</h4>
                                <h2 id="timer" class="display-4 fw-bold text-success mb-4">00:00</h2>
                                <div class="gap-3 timer-controls-original">
                                    <button id="startBtn" class="btn btn-success px-4">Começar</button>
                                </div>
                                <button id="sticky-pause-btn" class="btn btn-warning px-4" disabled>Pausar</button>
                            </div> 
                        </div>

                    </div> 

                </div>
            </div>

        <?php else: ?>

            <!--  SEM AUTOR  -->
            <img src="<?php echo htmlspecialchars($receita['imagem']); ?>" 
                 class="d-flex mx-auto w-100 w-lg-60 border border-4 rounded mb-4 shadow-sm" 
                 alt="<?php echo htmlspecialchars($receita['titulo']); ?>">

            <div id="timer-wrapper" class="text-center mt-4 mb-2">
                <h4 class="fw-bold mb-1">Temporizador</h4>
                <h2 id="timer" class="display-4 fw-bold text-success mb-4">00:00</h2>
                <div class="gap-3 timer-controls-original">
                    <button id="startBtn" class="btn btn-success px-4">Começar</button>
                </div>
                <button id="sticky-pause-btn" class="btn btn-warning px-4" disabled>Pausar</button>
            </div>

        <?php endif; ?>

        <div class="container overflow-hidden">
            <div class="row gx-4 py-1 align-items-start">
                <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                    <div class=" mb-4 mt-1 fs-4 text-center ">Ingredientes</div>
                    <div class="p-3 w-75 mt-2 mx-auto">
                        <ul class="list-group">
                            <?php foreach($ingredientes as $ing): ?>
                                <li class="list-group-item bg-receita"><?php echo htmlspecialchars($ing['nome']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class=" mb-4 mt-1 fs-4 text-center">Modo de Preparação</div>
                    <div class="p-3">
                        <ul class="list-group list-group-flush list-group-numbered">
                            <?php foreach($passos as $passo): ?>
                                <li class="list-group-item"><?php echo htmlspecialchars($passo['passo']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-4 p-3 rounded-3 shadow-sm" style="background-color: white;">
                    <div class="me-3">
                        <button class="btn btn-link p-0 border-0 text-decoration-none" 
                                onclick="toggleFavorito(this, <?php echo $id_receita; ?>, '<?php echo addslashes($receita['titulo']); ?>', '<?php echo $receita['imagem']; ?>', 'receita.php?id=<?php echo $id_receita; ?>')"
                                style="cursor: pointer;">
                            <i class="bi bi-heart-fill fs-3 <?php echo $classe_coracao; ?>"></i>
                        </button>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" id="texto-likes-completo">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> A carregar...
                        </h5>
                        <span id="dados-receita" data-receitaid="<?php echo $id_receita; ?>" style="display:none;"></span>
                        <small id="msg-incentivo" class="text-muted <?php echo $e_favorito ? 'd-none' : ''; ?>">
                            Junta-te a elas e adiciona aos favoritos!
                        </small>
                    </div>
                </div>

                <h3 class="fw-bold mb-4">Comentários (<?php echo count($lista_comentarios); ?>)</h3>
                <div class="mb-4" id="lista-comentarios">
                    <?php if (count($lista_comentarios) > 0): ?>
                        <?php foreach($lista_comentarios as $com): ?>
                            <?php
                                $avatar_final = "imgs/avatar/avpadrao.jpg"; 
                                $avatar_db = $com['avatar'];
                                if (!empty($avatar_db) && $avatar_db != 'default') {
                                    if (file_exists("imgs/avatar/" . $avatar_db)) {
                                        $avatar_final = "imgs/avatar/" . $avatar_db;
                                    } elseif (file_exists($avatar_db)) {
                                        $avatar_final = $avatar_db;
                                    }
                                }
                            ?>
                            <div class="card mb-3 border-0 shadow-sm comentario-item" style="background-color: rgb(253, 249, 243);">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="<?php echo $avatar_final; ?>" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover; border: 2px solid #8B4513;">
                                        <div>
                                            <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($com['utilizador']); ?></h6>
                                            <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($com['data_comentario'])); ?></small>
                                        </div>
                                    </div>
                                    <p class="card-text ps-5"><?php echo nl2br(htmlspecialchars($com['comentario'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center mt-3">
                            <button id="btnVerMais" class="btn btn-outline-secondary btn-sm" style="display: none;">
                                Ver mais comentários <i class="bi bi-chevron-down ms-1"></i>
                            </button>
                        </div>
                    <?php else: ?>
                        <p class="text-muted fst-italic">Ainda não existem comentários. Seja o primeiro!</p>
                    <?php endif; ?>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Deixe o seu comentário</h5>
                        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                        <form id="formComentario">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="comentario" placeholder="Escreva aqui..." id="floatingTextarea2" style="height: 100px" required></textarea>
                                <label for="floatingTextarea2">O que achou desta receita?</label>
                            </div>
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success">Publicar Comentário</button>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0 text-center">
                                <a href="auth/login.php" class="link-underline-success link-underline-opacity-0 link-underline-opacity-100-hover text-success">Faça login</a> para deixar um comentário.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLogin" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center py-4">
            <div class="mb-3">
                <span class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-block">
                    <i class="bi bi-person-lock fs-1"></i>
                </span>
            </div>
            <h5 class="fw-bold mb-2">Login Necessário</h5>
            <p class="text-muted px-4">Para adicionar esta receita aos teus favoritos, precisas de entrar na tua conta primeiro.</p>
          </div>
          <div class="modal-footer border-0 justify-content-center pb-4">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
            <a href="auth/login.php" class="btn btn-success rounded-pill px-4">Fazer Login</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalTimer" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
          
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body text-center py-4">
            <div class="mb-3">
                <span class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block">
                    <i class="bi bi-alarm fs-1"></i>
                </span>
            </div>
            <h4 class="fw-bold mb-2">O tempo terminou!</h4>
            <p class="text-muted px-4">A sua receita deverá estar concluída. Bom apetite!</p>
          </div>

          <div class="modal-footer border-0 justify-content-center pb-4">
            <button type="button" class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">Fechar</button>
          </div>

        </div>
      </div>
    </div>

    <?php require('includes/footer.php'); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    
    <script>
        // TEMPORIZADOR 
        const tempoReceitaMinutos = <?php echo $receita['tempo_preparo']; ?>;
        let tempoRestante = tempoReceitaMinutos * 60; 
        let cronometro = null;
        let aDecorrer = false;
        const timerDisplay = document.getElementById("timer");
        const startBtn = document.getElementById("startBtn");
        const timerWrapper = document.getElementById("timer-wrapper");
        const stickyPauseBtn = document.getElementById("sticky-pause-btn");

        const modalTimerEl = document.getElementById('modalTimer');
        
        if (modalTimerEl) {
            modalTimerEl.addEventListener('hidden.bs.modal', function () {
                if(alarme) {
                    alarme.pause();
                    alarme.currentTime = 0;
                }
            });
        }

        function atualizarDisplay() {
            const min = String(Math.floor(tempoRestante / 60)).padStart(2, '0');
            const sec = String(tempoRestante % 60).padStart(2, '0');
            timerDisplay.textContent = `${min}:${sec}`;
        }

        function runTimer() {
            tempoRestante--;
            atualizarDisplay();
            if (tempoRestante <= 0) {
                clearInterval(cronometro);
                
                const modalTimer = new bootstrap.Modal(document.getElementById('modalTimer'));
                modalTimer.show();

                aDecorrer = false;
                if(timerWrapper) timerWrapper.classList.remove("timer-sticky"); 
                startBtn.disabled = false;                    
                tempoRestante = tempoReceitaMinutos * 60;               
                atualizarDisplay();                                    
            }
        }

        function iniciarCronometro() {
            if (aDecorrer) return;
            aDecorrer = true;
            cronometro = setInterval(runTimer, 1000); 
            startBtn.disabled = true; 
            if(timerWrapper) timerWrapper.classList.add("timer-sticky"); 
            stickyPauseBtn.disabled = false; 
            stickyPauseBtn.textContent = "Pausar";
            stickyPauseBtn.classList.remove("btn-success");
            stickyPauseBtn.classList.add("btn-warning"); 
        }

        function togglePausaResume() {
            if (aDecorrer) {
                clearInterval(cronometro);
                aDecorrer = false;
                stickyPauseBtn.textContent = "Retomar";
                stickyPauseBtn.classList.replace("btn-warning", "btn-success"); 
            } else {
                aDecorrer = true;
                cronometro = setInterval(runTimer, 1000);
                stickyPauseBtn.textContent = "Pausar";
                stickyPauseBtn.classList.replace("btn-success", "btn-warning"); 
            }
        }

        if(startBtn) startBtn.addEventListener("click", iniciarCronometro);
        if(stickyPauseBtn) stickyPauseBtn.addEventListener("click", togglePausaResume); 
        if(timerDisplay) atualizarDisplay();

        document.addEventListener("DOMContentLoaded", function() {
            const comentarios = document.querySelectorAll('.comentario-item');
            const btnVerMais = document.getElementById('btnVerMais');
            const limiteInicial = 5;
            let comentariosVisiveis = limiteInicial;

            // Se houver mais de 5 comentários, esconde os restantes
            if (comentarios.length > limiteInicial) {
                btnVerMais.style.display = 'inline-block';
                for (let i = limiteInicial; i < comentarios.length; i++) {
                    comentarios[i].classList.add('d-none');
                }
            }

            if(btnVerMais) {
                // Ao clicar, revela os próximos 5 com uma animação de FadeIn
                btnVerMais.addEventListener('click', function() {
                    // comentariosVisiveis começa em 5
                const proximoLimite = comentariosVisiveis + 5;// O novo limite passa a ser 10
                    // O ciclo FOR começa no 5 (o primeiro escondido) e vai até ao 10
                    for (let i = comentariosVisiveis; i < proximoLimite && i < comentarios.length; i++) {
                        comentarios[i].classList.remove('d-none'); // Torna-os visíveis
                        comentarios[i].style.animation = "fadeIn 0.5s";// Adiciona o efeito visual
                    }
                    // Atualiza a variável de controlo para que no próximo clique comece no 10
                    comentariosVisiveis = proximoLimite;
                    if (comentariosVisiveis >= comentarios.length) {
                        btnVerMais.style.display = 'none';
                    }
                });
            }
        });

        const isLogado = <?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] === true) ? 'true' : 'false'; ?>;
        const dadosElement = document.getElementById('dados-receita');
        const receitaIdAtual = dadosElement ? dadosElement.dataset.receitaid : 0;
        const textoLikesElement = document.getElementById('texto-likes-completo');

        function atualizarLikes() {
            if(!textoLikesElement) return;
            fetch("ajax/contar_likes.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: receitaIdAtual })
            })
            .then(response => response.json())
            .then(data => {
                const total = parseInt(data.total);
                if (total === 1) {
                    textoLikesElement.innerText = "1 pessoa gostou disto";
                } else {
                    textoLikesElement.innerText = total + " pessoas gostaram disto";
                }
            })
            .catch(err => console.error("Erro ao contar likes:", err));
        }

        function toggleFavorito(btn, id, titulo, imagem, referencia) {
            if (!isLogado) {
                const modalElement = document.getElementById('modalLogin');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                return;
            }
            const icon = btn.querySelector('i');
            const msgIncentivo = document.getElementById('msg-incentivo'); 
            
            fetch('ajax/ajax_favorito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_receita: id,
                    titulo: titulo,
                    imagem: imagem,
                    referencia: referencia
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'adicionado') {
                    icon.classList.remove('text-secondary');
                    icon.classList.add('text-danger');
                    if(msgIncentivo) msgIncentivo.classList.add('d-none');
                    atualizarLikes(); 
                } else if (data.status === 'removido') {
                    icon.classList.remove('text-danger');
                    icon.classList.add('text-secondary');
                    if(msgIncentivo) msgIncentivo.classList.remove('d-none');
                    atualizarLikes();
                }
            })
            .catch(error => console.error('Erro:', error));
        }
        document.addEventListener("DOMContentLoaded", atualizarLikes);
        
    const formComentario = document.getElementById('formComentario');
    
    if (formComentario) {
        formComentario.addEventListener('submit', function(e) {
            e.preventDefault(); // Impede a página de recarregar

            const comentarioTexto = document.getElementById('floatingTextarea2').value;
            const receitaId = <?php echo $id_receita; ?>; // ID da receita vindo do PHP

            fetch('ajax/adicionar_comentario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_receita: receitaId,
                    comentario: comentarioTexto
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'sucesso') {
                    document.getElementById('floatingTextarea2').value = '';

                    const lista = document.getElementById('lista-comentarios');
                    
                    const mensagemVazia = lista.querySelector('p.fst-italic');
                    if (mensagemVazia) mensagemVazia.remove();

                    lista.insertAdjacentHTML('afterbegin', data.html);

                    //  Atualizar o contador de comentários
                    const tituloComentarios = document.querySelector('h3.fw-bold.mb-4');
                    if(tituloComentarios) {
                        let textoAtual = tituloComentarios.innerText;
                        let numeroMatch = textoAtual.match(/\d+/);
                        if(numeroMatch) {
                            let novoNumero = parseInt(numeroMatch[0]) + 1;
                            tituloComentarios.innerText = `Comentários (${novoNumero})`;
                        }
                    }

                } else {
                    alert('Erro: ' + data.mensagem);
                }
            })
            .catch(error => console.error('Erro:', error));
        });
    }
</script>
</body>
</html>