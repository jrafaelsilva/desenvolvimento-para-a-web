<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bolonhesa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <audio id="alarme" src="https://actions.google.com/sounds/v1/alarms/bugle_tune.ogg" preload="auto"></audio>

  <style>
/* CSS do Timer (mantido) */
.timer-sticky {
  position: fixed;
  top: 90px; 
  right: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  width: 120px;
  min-height: 100px;
  background: linear-gradient(135deg, #ffffff, #f3f3f3);
  border: 2px solid #d6d6d6;
  border-radius: 12px;
  padding: 1rem 0.8rem;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
  z-index: 1050;
  transition: all 0.3s ease;
}

.timer-sticky.active {
  display: flex;
}

.timer-sticky #timer {
  font-size: 2rem;
  font-weight: 700;
  color: #2e7d32;
  text-align: center;
}

.timer-sticky #sticky-pause-btn {
  display: block !important;
  font-size: 0.9rem;
  font-weight: 600;
  padding: 6px 12px;
  border-radius: 6px;
  width: 100%;
}

/* NOVO CSS: Garante que a imagem tenha 50% em telas de desktop */
#receita-img {
    width: 100%; /* Padrão 100% no mobile */
}
@media (min-width: 768px) { /* A partir de 768px (MD breakpoint) */
    #receita-img {
        width: 50% !important; /* Força 50% no desktop */
        max-width: 50%;
    }
}
  </style>
</head>

<body>
    <body>
    <?php
    require('includes/nav.php')
    ?>


  <nav aria-label="breadcrumb" class="ms-3 mt-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="receitasdecarne.php">Receitas de carne</a></li>
      <li class="breadcrumb-item active" aria-current="page">Bolonhesa</li>
    </ol>
  </nav>

  <div class="container">
    <div class="fw-bold mb-4 mt-5 fs-4 text-center">Bolonhesa</div>
    <img src="imgs/bolonhesa.jpg" id="receita-img" class="d-block mx-auto border border-4 rounded shadow-sm">

    <div id="timer-wrapper" class="text-center my-4">
      <h4 class="fw-bold mb-3">Temporizador</h4>
      <h2 id="timer" class="display-4 fw-bold text-success mb-4">00:00</h2>


      <div class="d-flex justify-content-center gap-3 timer-controls-original">
        <button id="startBtn" class="btn btn-success px-4">Começar</button>
      </div>

      <button id="sticky-pause-btn" class="btn btn-warning px-4" disabled>Pausar</button>
    </div>

    <div class="container overflow-hidden">
      <div class="row gx-4 py-4 align-items-start">
        <div class="col-12 col-md-6 d-flex flex-column align-items-center">
          <div class="mb-4 mt-2 fs-4 text-center">Ingredientes</div>
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
            </ul>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="mb-4 mt-2 fs-4 text-center">Modo de Preparação</div>
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
      <textarea class="form-control" placeholder="Deixe um comentário" id="floatingTextarea2" style="height: 60px"></textarea>
      <label for="floatingTextarea2">Comentários</label>
    </div>
  </div>

  <?php
  require('includes/footer.php')
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const TEMPO_INICIAL_SEGUNDOS = 2100; // 35 minutos
    let tempoRestante = TEMPO_INICIAL_SEGUNDOS;
    let cronometro = null;
    let aDecorrer = false;

    const timerDisplay = document.getElementById("timer");
    const startBtn = document.getElementById("startBtn");
    const alarme = document.getElementById("alarme");
    const timerWrapper = document.getElementById("timer-wrapper");
    const stickyPauseBtn = document.getElementById("sticky-pause-btn");

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
        alarme.play();
        alert("⏰ O tempo terminou!");
        aDecorrer = false;
        timerWrapper.classList.remove("timer-sticky", "active");
        stickyPauseBtn.disabled = true;
        startBtn.disabled = false;
        tempoRestante = TEMPO_INICIAL_SEGUNDOS;
        atualizarDisplay();
      }
    }

    function iniciarCronometro() {
      if (aDecorrer) return;
      aDecorrer = true;

      tempoRestante = TEMPO_INICIAL_SEGUNDOS;
      atualizarDisplay();

      cronometro = setInterval(runTimer, 1000);
      startBtn.disabled = true;

      timerWrapper.classList.add("timer-sticky", "active");
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
        if (tempoRestante > 0) {
          aDecorrer = true;
          cronometro = setInterval(runTimer, 1000);
          stickyPauseBtn.textContent = "Pausar";
          stickyPauseBtn.classList.replace("btn-success", "btn-warning");
        }
      }
    }

    startBtn.addEventListener("click", iniciarCronometro);
    stickyPauseBtn.addEventListener("click", togglePausaResume);

    atualizarDisplay();
  </script>
</body>
</html>