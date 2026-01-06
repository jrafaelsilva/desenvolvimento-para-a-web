    <?php
    $logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;

    $nomeUtilizador = $logado ? htmlspecialchars($_SESSION['utilizador']) : '';
    $avatar_nav = "default"; // Define o padrão

    // Só procura na base de dados se estiver logado E se a conexão $dbh existir
    if (isset($_SESSION['logado']) && $_SESSION['logado'] === true && isset($dbh)) {
    $id_nav = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : (isset($_SESSION['id']) ? $_SESSION['id'] : 0);
    
    $stmtNav = $dbh->prepare("SELECT avatar FROM dados_perfil WHERE id_utilizador = ?");
    $stmtNav->execute([$id_nav]);
    $resultadoNav = $stmtNav->fetch(PDO::FETCH_ASSOC);
    
    if ($resultadoNav && !empty($resultadoNav['avatar'])) {
        $avatar_nav = $resultadoNav['avatar'];
    }
}
    ?>
        
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm " style="background-color: rgb(245, 240, 214);">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="imgs/pitada.logo.png" alt="Logótipo" width="100" height="auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="list-style: none">
                
                <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 me-4 text-center"> 
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Receitas</a>
                        <ul class="dropdown-menu text-center w-50 mx-auto ">
                            <li><a class="dropdown-item" href="categoria.php?tipo=carne">Carne</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="categoria.php?tipo=peixe">Peixe</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="categoria.php?tipo=sobremesa">Sobremesa</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="categoria.php?tipo=sopa">Sopas e Cremes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="categoria.php?tipo=comunidade">Comunidade</a></li>                           
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link active fs-5 ms-lg-3" href="chefs.php">Chef`s</a></li>
                    <li class="nav-item"><a class="nav-link active fs-5 ms-lg-3" href="minhasreceitas.php">Minhas Receitas</a></li>
                </ul>
                
                <form class="d-flex align-items-center me-lg-3 my-2 my-lg-0 mx-auto mx-lg-0 position-relative" 
                    role="search" 
                    style="max-width: 250px;" 
                    action="pesquisa.php" 
                    method="GET"
                    autocomplete="off"> <i class="bi bi-search position-absolute ms-3 text-dark" style="z-index: 10;"></i>
                    
                    <input 
                        id="inputPesquisa"
                        class="form-control ps-5 border-0 shadow-sm" 
                        type="search" 
                        name="q" 
                        placeholder="Pesquise por receitas ..." 
                        aria-label="Search" 
                        style="border-radius: 50px; background-color: rgba(229, 223, 194, 1);" />

                    <div id="listaResultados" class="list-group position-absolute w-100 shadow-sm d-none" 
                        style="top: 100%; left: 0; z-index: 1050; border-radius: 15px; overflow: hidden; margin-top: 5px;">
                        </div>
                </form>
                <ul class="navbar-nav align-items-center">
                    <?php if ($logado): ?>
                    <li class="nav-item dropdown d-flex flex-column align-items-center">
                        <a class="nav-link p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                
                                <?php if ($avatar_nav != "default" && file_exists("imgs/avatar/" . $avatar_nav)): ?>
                                    <!-- Se existir avatar, mostra a imagem -->
                                    <img src="imgs/avatar/<?php echo $avatar_nav; ?>" alt="Avatar" 
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 2px solid rgb(182, 125, 95);">
                                <?php else: ?>
                                    <!-- Se não existir, mostra o avatar padrão -->
                                        <img src="imgs/avatar/avpadrao.jpg" alt="Avatar Padrão" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 2px solid rgb(182, 125, 95);">
                                <?php endif; ?>                               

                            </a>    
                        <ul class="dropdown-menu dropdown-menu-lg-end text-center w-50">
                            <li>
                                <span class="dropdown-item-text fw-bold fs-5 text-dark">
                                    Olá, <?php echo $nomeUtilizador; ?>!
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="auth/logout.php">Terminar Sessão</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item d-flex align-items-center align-self-lg-center">
                        <a href="auth/login.php" class="nav-link p-0"><i class="bi bi-person-circle fs-2 "></i></a>
                    </li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const input = document.getElementById('inputPesquisa');
                const lista = document.getElementById('listaResultados');

                input.addEventListener('input', function() {
                    const termo = this.value.trim();

                    // Se tiver uma letra, mostra as opçoes
                    if (termo.length < 1) {
                        lista.innerHTML = '';
                        lista.classList.add('d-none');
                        return;
                    }

                    // Faz o pedido ao PHP
            fetch(`ajax/ajax_pesquisa.php?termo=${encodeURIComponent(termo)}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Erro na rede');
                            return response.json();
                        })
                        .then(data => {
                            lista.innerHTML = ''; 

                            if (data.length > 0) {
                                lista.classList.remove('d-none'); 

                                data.forEach(receita => {
                                    const item = document.createElement('a');
                                    item.href = `receita.php?id=${receita.id}`;
                                    item.className = 'list-group-item list-group-item-action d-flex align-items-center p-2 border-0 border-bottom';
                                    item.style.backgroundColor = "rgba(255, 255, 255, 0.98)"; 
                                    
                                    item.innerHTML = `
                                        <img src="${receita.imagem}" class="rounded-circle me-3 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                                        <span class="small fw-semibold text-dark">${receita.titulo}</span>
                                    `;
                                    
                                    lista.appendChild(item);
                                });
                            } else {
                                lista.classList.add('d-none');
                            }
                        })
                        .catch(err => console.error('Erro na pesquisa:', err));
                });

                // Fechar ao clicar fora
                document.addEventListener('click', function(e) {
                    if (!input.contains(e.target) && !lista.contains(e.target)) {
                        lista.classList.add('d-none');
                    }
                });
            });
        </script>
    </nav>
    