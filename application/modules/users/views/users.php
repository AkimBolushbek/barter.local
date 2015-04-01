<a href='/admin/<?= $module ?>/add'><button type="button" style='margin-bottom:20px;' class="btn btn-default btn-default">Добавить</button></a>
<table class="table table-bordered">

    <?php if (is_array($entries)) {  ?>

        <tr>
            <td width="30px">#</td>
            <td width="30%">Имя пользователя</td>
            <td width="30%">e-mail</td>
            <td>Имя</td>
            <td width="30%">Фамилия</td>
            <td>Телефон</td>
            <td>Дата регистрации</td>
            <td width="30px">Редактировать</td>
            <td width="30px">Удалить</td>
        </tr>
        <?php
        foreach ($entries as $entry):
            ?>

            <tr>
                <td class="id" width="30px"><?= $entry['id'] ?></td>
                <td width="30%"><?= $entry['username'] ?></td>
                <td width="30%"><?= $entry['email'] ?></td>
                <td width="30%"><?= $entry['first_name'] ?></td>
                <td width="30%"><?= $entry['last_name'] ?></td>
                <td width="30%"><?= $entry['phone'] ?></td>
                <td><?= date('d.m.Y H:i', $entry['created_on'])?></td>
                <td width="30px"><a href='/admin/<?= $module ?>/edit/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-edit"></span></a></td>
                <td width="30px"><a href='/admin/<?= $module ?>/delete/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
            <?php
        endforeach;
    } else {
        echo '<div class="alert alert-danger" role="alert"><strong>Oops! </strong>Записей в базе не найдено</div>';
    }
    ?>
</table>