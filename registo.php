<!DOCTYPE html>
<html lang="pt" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registo - Pitada na Mesa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 h-100 bg-fade">

<main class="form-signin ms-auto me-auto p-3"> 

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">

      <form>
        <a href="index.php" class="d-flex justify-content-center mx-auto mb-4">
          <img src="imgs/pitada.logo.png" height="80" width="120" alt="Logótipo Pitada na Mesa"/>
        </a>
        
        <h1 class="fs-4 mb-3 fw-normal text-center">Faça o seu registo</h1>
        
        <div class="form-floating ">
          <input type="text" class="form-control mb-2" id="floatingUser" placeholder="utilizador"/>
          <label for="floatingUser">Nome de utilizador</label>
        </div>
        
        <div class="form-floating ">
          <input type="email" class="form-control mb-2" id="floatingEmail" placeholder="your-email@gmail.com"/>
          <label for="floatingEmail">Endereço de Email</label>
        </div>
        
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password"/>
          <label for="floatingPassword">Palavra-Passe</label>
        </div>

        <button class="btn btn-success w-100 py-2 mt-3" type="submit">Realizar registo</button>
        
        <p class="mt-3 text-center text-body-secondary mb-0">
          Já tens conta? 
          <a href="login.php" class="fw-semibold text-decoration-none">Faz login</a>
        </p>
        
      </form>

    </div>
  </div>
</main>
</body>
</html>