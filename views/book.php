<?php include 'blocks/top.php' ?>

<div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">
                <a style="color: blueviolet" href="/">← В каталог</a>
                <br>
                Просмотр книги
            </h3>
            <form class="pull-right" method="post" action="/book/<?= $item->getId() ?>/remove">
                <button type="submit" class="btn btn-danger btn-xs">Удалить книгу</button>
            </form>
            <a href="/book/<?= $item->getId() ?>/edit" class="btn btn-xs btn-primary pull-right">Редактировать</a>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <h1><?= $item->getName() ?></h1>

            <?php if ($item->getAuthor()): ?>
                <p><b>Автор: </b> <?= htmlspecialchars($item->getAuthor()) ?></p>
            <?php endif; ?>

            <?php if ($item->getPagesCount()): ?>
                <p><b>Количество страниц: </b> <?= htmlspecialchars($item->getPagesCount()) ?></p>
            <?php endif; ?>

            <?php if ($item->getReleaseDate()): ?>
                <p><b>Дата выпуска: </b> <?= htmlspecialchars($item->getReleaseDate()) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'blocks/bottom.php' ?>
