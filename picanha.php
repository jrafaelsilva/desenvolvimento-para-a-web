<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Picanha</title>

  <!-- Bootstrap local -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ícones do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <audio id="alarme" src="https://actions.google.com/sounds/v1/alarms/bugle_tune.ogg" preload="auto"></audio>

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgb(245, 240, 214);">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="imgs/pitada.logo.png" alt="Logótipo" width="100" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Página Inicial</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Receitas
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="receitasdecarne.php">Carne</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="receitasdepeixe.php">Peixe</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="receitasdesobremesa.php">Sobremesa</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="receitasdesopas.php">Sopas e Cremes</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Minhas Receitas</a>
            </li>
          </ul>

          <form class="d-flex align-items-center position-relative" role="search" style="width: 250px;">
            <i class="bi bi-search position-absolute ms-2 text-success"></i>
            <input 
              class="form-control ps-5 border-success" 
              type="search" 
              placeholder="Pesquise por conteúdos ..." 
              aria-label="Search" 
              style="border-radius: 8px;"
            />
          </form>

          <li class="nav-item d-flex align-items-center ms-3">
            <a href="login.php" class="nav-link p-0">
              <i class="bi bi-person-circle fs-4"></i>
            </a>
          </li>
        </div>
      </div>
    </nav>
  </header>

  <nav aria-label="breadcrumb" class="ms-3 mt-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="receitasdecarne.php">Receitas de carne</a></li>
      <li class="breadcrumb-item active" aria-current="page">Picanha</li>
    </ol>
  </nav>

    <div class="container">
      <div class="fw-bold mb-4 mt-5 fs-4 text-start">Picanha</div>
      <img src="imgs/picanha" class="d-flex mx-auto w-75 w-md-75 w-lg-50 border border-4 rounded">
      <div id="timer-wrapper" class="text-center my-2">
        <h4 class="fw-bold mb-1">Temporizador</h4>
        <h2 id="timer" class="display-4 fw-bold text-success mb-4">00:00</h2>
        <div class="d-flex justify-content-center gap-3 timer-controls-original">
          <button id="startBtn" class="btn btn-success px-4">Começar</button>
        </div>
        <button id="sticky-pause-btn" class="btn btn-warning px-4" disabled>Pausar</button>
      </div>        
      <div class="container overflow-hidden">
          <div class="row gx-4 py-1 align-items-start">
              <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                  <div class=" mb-4 mt-3 fs-4 text-center ">Ingredientes</div>
                  <div class="p-3 w-75 mt-2 mx-auto">
                    <ul class="list-group">
                      <li class="list-group-item bg-receita">Picanha</li>
                      <li class="list-group-item bg-receita">Sal q.b.</li>
                  </ul></div>
              </div>
            <div class="col-12 col-md-6">
              <div class=" mb-4 mt-5 fs-4 text-center">Modo de Preparação</div>
                <div class="p-3">
                    <ul class="list-group list-group-flush list-group-numbered">
                      <li class="list-group-item">Escolha uma picanha com gordura entremeada e com gordura firme de 1 dedo de altura.</li>
                      <li class="list-group-item">Sele a picanha, de ambos os lados, em lume alto. E, de seguida, deixe repousar a picanha durante 5 minutos.</li>
                      <li class="list-group-item">Após este tempo, corte a picanha em pedaços, com dois dedos de espessura. Grelhe novamente a picanha de ambos os lados em lume alto.</li>
                      <li class="list-group-item">Assim que a picanha estiver no ponto que deseja, deixe repousar durante 2 a 3 minutos. E corte, de novo, em fatias pequenas, e tempere a picanha com flor de sal.</li>
                      </ul>
                </div>
            </div>
          </div>
        </div>
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 60px"></textarea>
          <label for="floatingTextarea2 ">Comentários</label>
        </div>
    </div>

 

  <footer class="text-center text-lg-start mt-5" style="background-color: rgb(245, 240, 214); color: rgb(51, 51, 51);">
  <div class="container p-4">
    <div class="row">
      <!-- Sobre -->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Pitada na Mesa</h5>
        <p>
          Partilhamos receitas simples, saborosas e cheias de amor.
          Da cozinha tradicional às novas tendências gastronómicas,
          inspira-te e traz mais sabor ao teu dia!
        </p>
      </div>

      <!-- Links úteis -->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Links úteis</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="#" class="text-decoration-none text-dark">Página Inicial</a></li>
          <li><a href="#" class="text-decoration-none text-dark">Contactos</a></li>
        </ul>
      </div>

      <!-- Redes sociais -->
      <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Segue-nos</h5>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/_.diogo11._" class="text-dark me-3 fs-4"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-youtube"></i></a>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-pinterest"></i></a>
      </div>
    </div>
  </div>

    <!-- Direitos -->
    <div class="text-center p-3" style="background-color: rgb(236, 230, 198);">
    © 2025 Pitada na Mesa — Todos os direitos reservados.
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
  // --- VARIÁVEIS GLOBAIS ---
  let tempoRestante = 35 * 60; // 35 minutos em segundos (2100)
  let cronometro = null;
  let aDecorrer = false;

  const timerDisplay = document.getElementById("timer");
  const startBtn = document.getElementById("startBtn");
  // Os botões "pauseBtn" e "resetBtn" originais foram removidos
  const alarme = document.getElementById("alarme");
  const timerWrapper = document.getElementById("timer-wrapper");
  const stickyPauseBtn = document.getElementById("sticky-pause-btn"); // O nosso botão "sticky"

  // --- FUNÇÃO PARA ATUALIZAR O DISPLAY ---
  function atualizarDisplay() {
    const min = String(Math.floor(tempoRestante / 60)).padStart(2, '0');
    const sec = String(tempoRestante % 60).padStart(2, '0');
    timerDisplay.textContent = `${min}:${sec}`;
  }

  // --- FUNÇÃO CENTRAL DO CRONÓMETRO ---
  // Esta função é chamada a cada segundo
  function runTimer() {
    tempoRestante--;
    atualizarDisplay();

    if (tempoRestante <= 0) {
      clearInterval(cronometro);
      alarme.play();
      alert("O tempo terminou!");
      aDecorrer = false;
      
      // Reiniciar o estado quando o tempo acaba
      timerWrapper.classList.remove("timer-sticky"); // Esconde o timer sticky
      stickyPauseBtn.disabled = true;                // Desativa o botão sticky
      startBtn.disabled = false;                     // Re-ativa o botão "Começar" original
      tempoRestante = 35 * 60;                       // Repõe o tempo
      atualizarDisplay();                            // Mostra 35:00
    }
  }

  // --- FUNÇÃO PARA INICIAR (Chamada pelo "Começar") ---
  function iniciarCronometro() {
    if (aDecorrer) return;
    aDecorrer = true;
    cronometro = setInterval(runTimer, 1000); // Inicia a contagem

    startBtn.disabled = true; // Desativa o botão "Começar"
    timerWrapper.classList.add("timer-sticky"); // Mostra o timer "sticky"
    stickyPauseBtn.disabled = false; // Ativa o botão "sticky"
    
    // Configura o botão "sticky" para o estado "Pausar"
    stickyPauseBtn.textContent = "Pausar";
    stickyPauseBtn.classList.remove("btn-success"); // Remove a cor "Retomar" (azul)
    stickyPauseBtn.classList.add("btn-warning"); // Adiciona a cor "Pausar" (amarelo)
  }

  // --- FUNÇÃO PARA PAUSAR/RETOMAR (Chamada pelo botão "sticky") ---
  function togglePausaResume() {
    if (aDecorrer) {
      // Se está a decorrer -> PAUSAR
      clearInterval(cronometro);
      aDecorrer = false;
      stickyPauseBtn.textContent = "Retomar";
      stickyPauseBtn.classList.replace("btn-warning", "btn-success"); // Muda para a cor "Retomar" (azul)
    } else {
      // Se está pausado -> RETOMAR
      aDecorrer = true;
      cronometro = setInterval(runTimer, 1000); // Retoma a contagem
      stickyPauseBtn.textContent = "Pausar";
      stickyPauseBtn.classList.replace("btn-success", "btn-warning"); // Volta à cor "Pausar" (amarelo)
    }
  }

  // --- EVENTOS DOS BOTÕES ---
  startBtn.addEventListener("click", iniciarCronometro);
  stickyPauseBtn.addEventListener("click", togglePausaResume); // O botão sticky agora faz "toggle"

  // Mostrar tempo inicial
  atualizarDisplay();
</script>
</body>
</html>
