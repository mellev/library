<?php include 'blocks/top.php' ?>

<div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Каталог книг</h3>
            <a href="/book/create" class="btn btn-xs btn-primary pull-right">Добавить книгу</a>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <?php foreach ($items as $item): ?>
                <div><a href="/book/<?= $item->getId() ?>"><?= htmlspecialchars($item->getName()) ?></a></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'blocks/bottom.php' ?>