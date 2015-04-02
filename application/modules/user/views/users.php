<a href='/admin/<?= $module ?>/add'><button type="button" style='margin-bottom:20px;' class="btn btn-default btn-default">Добавить</button></a>
<table class="table table-bordered">

    <?php if (is_array($entries)) {  ?>

        <tr>
            <td width="30px">#</td>
            <td width="20%">Имя пользователя</td>
            <td width="20%">e-mail</td>
            <td>Имя</td>
            <td width="20%">Фамилия</td>
            <td>Телефон</td>
            <td>Группа</td>
            <td>Дата регистрации</td>
            <td width="30px">Редактировать</td>
            <td width="30px">Удалить</td>
        </tr>
        <?php
        foreach ($entries as $entry):
            ?>

            <tr>
                <td class="id" width="30px"><?= $entry['id'] ?></td>
                <td width="20%"><?= $entry['username'] ?></td>
                <td width="20%"><?= $entry['email'] ?></td>
                <td width="15%"><?= $entry['first_name'] ?></td>
                <td width="20%"><?= $entry['last_name'] ?></td>
                <td width="20%"><?= $entry['phone'] ?></td>
                <td width="20%">
                    <?php foreach($groups as $group)
                    {
                        if($entry['group_id'] == $group['id'])
                        {
                            echo $group['name'];
                        }
                    }
                    ?>
                </td>
                <td><?= date('d.m.Y', $entry['created_on'])?></td>
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