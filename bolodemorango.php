<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bolo de morango</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php 
    require('includes/nav.php');
    ?>

    <div class="ms-3 mt-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="receitasdesobremesa.php">Receitas de sobremesas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bolo de morango</li>
      </ol>
    </div>
    <div class="container">
      <div class="fw-bold mb-4 mt-5 fs-4 text-start">Bolo de morango</div>
      <img src="imgs/bolo.morango.webp" class="d-flex mx-auto w-50 border border-4 rounded">
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
              <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                  <div class=" mb-4 mt-5 fs-4 text-center ">Ingredientes</div>
                  <div class="p-3 w-75 mt-2 mx-auto">
                    <ul class="list-group">
                      <li class="list-group-item bg-receita">200 g de manteiga amolecida</li>
                      <li class="list-group-item bg-receita">200 g de açúcar branco</li>
                      <li class="list-group-item bg-receita">1 c. chá de extrato de baunilha</li>
                      <li class="list-group-item bg-receita">4 ovos</li>
                      <li class="list-group-item bg-receita">200 g de farinha de trigo</li>
                      <li class="list-group-item bg-receita">1c. chá de fermento em pó</li>
                      <li class="list-group-item bg-receita">Compota de morango q.b.</li>
                      <li class="list-group-item bg-receita">Morangos frescos q.b.</li>
                      <li class="list-group-item bg-receita">Açúcar em pó q.b.</li>
                  </ul></div>
              </div>
            <div class="col-12 col-md-6">
              <div class=" mb-4 mt-5 fs-4 text-center">Modo de Preparação</div>
                <div class="p-3">
                    <ul class="list-group list-group-flush list-group-numbered">
                      <li class="list-group-item">Comece a bater a manteiga com o açúcar branco e o extrato de baunilha até obter uma mistura esbranquiçada.</li>
                      <li class="list-group-item">Junte a farinha e o fermento peneirando bem. Envolva delicadamente.</li>
                      <li class="list-group-item">Disponha numa forma redonda previamente untada e forrada com papel vegetal.</li>
                      <li class="list-group-item">Alise bem a superfície e leve ao forno a 180ºC por 30 a 35 minutos.</li>
                      <li class="list-group-item">Assim que o bolo tiver arrefecido corte-o ao meio ficando com 2 metades iguais.</li>
                      <li class="list-group-item">Disponha a compota de morango numa das metades alise bem e de seguida o mascarpone batido. Sobreponha a 2ª metade do bolo por cima do mascarpone.</li>
                      <li class="list-group-item">Decore com morangos frescos e polvilhe com açúcar em pó.</li>
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
