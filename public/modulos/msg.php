<?php if (isset($_GET["sucesso"])): ?>
    <div class="msg sucesso">
        <span class="material-symbols-outlined">check</span>
        <p><?= $_GET["sucesso"] ?></p>
    </div>
<?php endif ?>

<?php if (isset($_GET["erro"])): ?>
    <div class="msg erro">
        <span class="material-symbols-outlined">close</span>
        <p><?= $_GET["erro"] ?></p>
    </div>
<?php endif ?>

