<nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgb(245, 240, 214);">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="imgs/pitada.logo.png" alt="Logótipo" width="100" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-start" id="navbarSupportedContent">
            
            <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 me-4"> 
                
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Receitas</a>
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
                <li class="nav-item"><a class="nav-link active fs-5 ms-lg-3" href="#">Minhas Receitas</a></li>
            </ul>

            <form class="d-flex align-items-center position-relative me-lg-3 my-2 my-lg-0 w-100 w-lg-auto align-self-lg-center" role="search" style="max-width: 250px;">
                <i class="bi bi-search position-absolute ms-2 text-dark"></i>
                <input 
                    class="form-control ps-5 border-0 shadow-sm" type="search" 
                    placeholder="Pesquise por receitas ..." 
                    aria-label="Search" 
                    style="border-radius: 50px; background-color: #e5dfc2;" />
            </form>
            
            <ul class="navbar-nav"> 
                <li class="nav-item d-flex align-items-center align-self-lg-center">
                    <a href="login.php" class="nav-link p-0"><i class="bi bi-person-circle fs-3 "></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>