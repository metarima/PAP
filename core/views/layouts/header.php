<?php use core\classes\store;
//$_SESSION['cliente'] = 1;

?>
<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3">
            <a href="?a=inicio">
                <h3><?= APP_NAME ?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a href="?a=inicio" class="nav-item">Início</a>
            <a href="?a=loja" class="nav-item">Loja</a>
            <?php if (Store::clienteLogado()): ?>
                <i class="fas fa-user mr-6"></i> <?= $_SESSION['utilizador'] ?></a>
                <a href="?a=logout" class="nav-item">Logout</a>
            <?php else: ?>
                <a href="?a=login" class="nav-item"><i class="fas fa-sign-out-alt"></i></a>
                <a href="?a=novo_cliente" class="nav-item">Criar conta</a>
            <?php endif; ?>
            <a href="?a=carrinho">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <span class="badge bg-warning"></span>
        </div>
    </div>
</div>