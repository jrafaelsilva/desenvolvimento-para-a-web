<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bolo de cenoura</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
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
        <li class="breadcrumb-item active" aria-current="page">Bolo de cenoura</li>
      </ol>
    </div>

    <div class="container">
      <div class="fw-bold mb-4 mt-5 fs-4 text-start">Bolo de cenoura</div>
      <img src="imgs/bolodecenoura.png" class="d-flex mx-auto w-75 w-md-75 w-lg-50 border border-4 rounded">
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
                      <li class="list-group-item bg-receita">300 g de cenoura ralada</li>
                      <li class="list-group-item bg-receita">120 g de açúcar branco</li>
                      <li class="list-group-item bg-receita">1 c. sopa de óleo vegetal</li>
                      <li class="list-group-item bg-receita">4 ovos</li>
                      <li class="list-group-item bg-receita">80 g de farinha de trigo</li>
                      <li class="list-group-item bg-receita">1c. chá de fermento em pó</li>
                  </ul></div>
              </div>
            <div class="col-12 col-md-6">
              <div class=" mb-4 mt-5 fs-4 text-center">Modo de Preparação</div>
                <div class="p-3">
                    <ul class="list-group list-group-flush list-group-numbered">
                      <li class="list-group-item">Pré-aqueça o forno a 180 ºC.</li>
                      <li class="list-group-item">Unte uma forma com manteiga e farinha.</li>
                      <li class="list-group-item">Numa tigela bata as gemas, o açúcar, o óleo e a cenoura ralada.</li>
                      <li class="list-group-item">Junte a farinha e misture com um garfo.</li>
                      <li class="list-group-item">Envolva as claras batidas em castelo.</li>
                      <li class="list-group-item">Deite o preparado e leve ao forno durante 30 minutos.</li>
                      <li class="list-group-item">Retire do forno e desenforme o bolo.</li>
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
    
  <script src="js/bootstrap.bundle.min.js"></script>
    
<script>
  let tempoRestante = 35 * 60; 
  let cronometro = null;
  let aDecorrer = false;

  const timerDisplay = document.getElementById("timer");
  const startBtn = document.getElementById("startBtn");
  const alarme = document.getElementById("alarme");
  const timerWrapper = document.getElementById("timer-wrapper");
  const stickyPauseBtn = document.getElementById("sticky-pause-btn"); // O nosso botão "sticky"

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
      alert("O tempo terminou!");
      aDecorrer = false;
      
      timerWrapper.classList.remove("timer-sticky"); 
      startBtn.disabled = false;                     
      tempoRestante = 35 * 60;                     
      atualizarDisplay();                            
    }
  }

  function iniciarCronometro() {
    if (aDecorrer) return;
    aDecorrer = true;
    cronometro = setInterval(runTimer, 1000); 

    startBtn.disabled = true; 
    timerWrapper.classList.add("timer-sticky"); 
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

  startBtn.addEventListener("click", iniciarCronometro);
  stickyPauseBtn.addEventListener("click", togglePausaResume); 

  atualizarDisplay();
</script>
</body>
</html>
