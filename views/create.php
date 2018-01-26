<?php include 'blocks/top.php' ?>

<div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Создание книги</h3>
        </div>
        <div class="panel-body">
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Название книги *</label>
                    <input type="text" name="name" class="form-control" value="<?= @$_REQUEST['name'] ?>">
                </div>
                <div class="form-group">
                    <label>Автор</label>
                    <input type="text" name="author" class="form-control" value="<?= @$_REQUEST['author'] ?>">
                </div>
                <div class="form-group">
                    <label>Кол-во страниц</label>
                    <input type="text" name="pages_count" class="form-control" value="<?= @$_REQUEST['pages_count'] ?>">
                </div>
                <div class="form-group">
                    <label>Дата выпуска</label>
                    <input type="date" name="release_date" class="form-control" value="<?= @$_REQUEST['release_date'] ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                    <a href="/" class="btn btn-default">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'blocks/bottom.php' ?>
