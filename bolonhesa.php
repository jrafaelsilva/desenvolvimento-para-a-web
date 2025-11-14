<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bolonhesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="shortcut icon" href="imgs/logo_arco_vermelho.svg">

</head>

<body>
      <?php 
    require('includes/nav.php');
    ?>

  <div class="ms-3 mt-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="receitasdecarne.php">Receitas de carne</a></li>
      <li class="breadcrumb-item active" aria-current="page">Bolonhesa</li>
    </ol>
</div>

    <div class="container">
      <div class="fw-bold mb-4 mt-5 fs-4 text-start">Bolonhesa</div>
      <img src="imgs/bolonhesa.jpg" class="d-flex mx-auto w-50 border border-4 rounded">
       <div id="timer-wrapper" class="text-center my-2">
        <h4 class="fw-bold mb-1">Temporizador</h4>
        <h2 id="timer" class="display-4 fw-bold text-success mb-4">00:00</h2>
        <div class="d-flex justify-content-center gap-3 timer-controls-original">
          <button id="startBtn" class="btn btn-success px-4">Começar</button>
        </div>
        <button id="sticky-pause-btn" class="btn btn-warning px-4" disabled>Pausar</button>
      </div>  

        <div class="container overflow-hidden">
          <div class="row gx-4 py-4 align-items-start">
              <div class="col-12 col-md-6 d-flex flex-column">
                  <div class=" mb-4 mt-5 fs-4 text-center ">Ingredientes</div>
                  <div class="p-3 w-75 mt-2 mx-auto">
                    <ul class="list-group">
                      <li class="list-group-item bg-receita">400 g de esparguete</li>
                      <li class="list-group-item bg-receita">2 dentes de alho</li>
                      <li class="list-group-item bg-receita">1 cebola</li>
                      <li class="list-group-item bg-receita">1 c. de sopa azeite</li>
                      <li class="list-group-item bg-receita">300 g de carne de novilho picada</li>
                      <li class="list-group-item bg-receita">½ c. de chá de sal</li>
                      <li class="list-group-item bg-receita">200 g de tomate pelado em cubos</li>
                      <li class="list-group-item bg-receita">100 g de polpa de tomate</li>
                      <li class="list-group-item bg-receita">1 unidade de tomilho seco</li>
                      <li class="list-group-item bg-receita">2 c. de sopa de queijo parmesão ralado</li>    
                  </ul></div>
              </div>
            <div class="col-12 col-md-6">
              <div class=" mb-4 mt-5 fs-4 text-center ">Modo de Preparação</div>
                <div class="p-3">
                    <ul class="list-group list-group-flush list-group-numbered">
                      <li class="list-group-item">Num tacho, coza o esparguete em água a ferver durante 8 minutos.</li>
                      <li class="list-group-item">Retire do lume, escorra e reserve.</li>
                      <li class="list-group-item">Pique o alho e a cebola.</li>
                      <li class="list-group-item">Numa frigideira antiaderente, refogue o alho e a cebola no azeite.</li>
                      <li class="list-group-item">Junte a carne de novilho picada, o sal e deixe cozinhar em lume médio.</li>
                      <li class="list-group-item">Acrescente o tomate pelado aos cubos, a polpa de tomate e o tomilho seco.</li>
                      <li class="list-group-item">Misture bem e deixe cozinhar mais um pouco para apurar.</li>
                      <li class="list-group-item">Sirva o esparguete à bolonhesa coberto com o molho e polvilhe com queijo parmesão ralado.</li>
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

 

    <?php
      require('includes/footer.php');
    ?>
    
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
