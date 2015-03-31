<div class="row">
    <div class="col-md-12">
        <a href="/admin/<?= $module ?>">
            <button type="button" class="btn btn-default btn-default"><span class='glyphicon glyphicon-step-backward'></span> Назад к списку</button>
        </a>
    </div>
</div>
<div class="page-header">
    <h2>Редактирование модуля "<?= $module_name ?>"</h2>
</div>
<?= form_open_multipart('admin/' . $module . '/edit/' . $entry['id']) ?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <button type="submit" class="btn btn-default">Сохранить</button>
    </div>
</div>
<div class="row" style="margin-bottom: 5px;">
    <div class="col-md-12">
        <?= validation_errors(); ?>
        <?php
        if ($this->session->userdata('error')) {
            echo $this->session->userdata('error');
        }
        $this->session->unset_userdata('error');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Название</label>
            <input required name='name' value="<?= $entry['name'] ?>" type="text" class="form-control" id="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="url">ЧПУ</label>
            <input name='url' value="<?= $entry['url'] ?>" type="text" class="form-control" id="url" placeholder="">
        </div>
        <div class="form-group">
            <label for="country">Страна, город</label>
            <input required name='country' value="<?= $entry['country'] ?>" type="text" class="form-control" id="country" placeholder="">
        </div>
        <div class="form-group">
            <label for="flightout">Вылет</label>
            <input required name='flightout' value="<?= $entry['flightout'] ?>" type="text" class="form-control" id="flightout" placeholder="из Москвы">
        </div>
        <div class="form-group">
            <label for="priceperone">Цена за одного человека</label>
            <input required name='priceperone' value="<?= $entry['priceperone'] ?>" type="text" class="form-control" id="priceperone" placeholder="">
        </div>
        <div class="form-group">
            <label for="price">Стоимость</label>
            <input required name='price' value="<?= $entry['price'] ?>" type="text" class="form-control" id="price" placeholder="">
        </div>
        <div class="form-group">
            <label for="datefrom">Дата с:</label>
            <div class='input-group date' id='datefrom'>
                <input required name="datefrom" id="datefrom" type='text' value="<?= date('d.m.Y h:i', strtotime($entry['datefrom'])) ?>" class="form-control" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datefrom').datetimepicker();
            });
        </script>
        <div class="form-group">
            <label for="duration">Продолжительность</label>
            <input required name='duration' value="<?= $entry['duration'] ?>" type="text" class="form-control" id="duration" placeholder="">
        </div>
        <div class="form-group">
            <label for="dateto">Дата по:</label>
            <div class='input-group date' id='dateto'>
                <input required name="dateto" id="dateto" type='text' value="<?= date('d.m.Y h:i', strtotime($entry['dateto'])) ?>" class="form-control" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#dateto').datetimepicker();
            });
        </script>
        <div class="form-group">
            <label for="hotel">Отель</label>
            <select name="hotel" class="form-control" id="hotel">
                <option value="0" selected>Нет</option>
                <?php foreach ($hotels as $hotel): ?>
                    <option <?php
                    if ($hotel['id'] == $entry['hotel_id']) {
                        echo 'selected';
                    }
                    ?> value="<?= $hotel['id'] ?>"><?= $hotel['id'] . '. ' . $hotel['name'] ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Тип тура</label>
            <input required name='type' value="<?= $entry['type'] ?>" type="text" class="form-control" id="type" placeholder="Стандартный двухместный номер с 1 кроватью или 2 отдельными кроватями - одноместное размещение">
        </div>
        <div class="form-group">
            <label for="placement">Размещение</label>
            <input required name='placement' value="<?= $entry['placement'] ?>" type="text" class="form-control" id="placement" placeholder="Одноместный номер (SGL)">
        </div>
        <div class="form-group">
            <label for="feed">Питание</label>
            <input name='feed' value="<?= $entry['feed'] ?>" type="text" class="form-control" id="feed" placeholder="Завтрак, ужин (или иногда обед на выбор) (HB)">
        </div>
        <div class="form-group">
            <label for="room">Номер</label>
            <input required name='room' value="<?= $entry['room'] ?>" type="text" class="form-control" id="room" placeholder="Standard">
        </div>
        <div class="form-group">
            <label for="outflight">Рейс туда</label>
            <input name='outflight' value="<?= $entry['outflight'] ?>" type="text" class="form-control" id="outflight" placeholder="">
        </div>
        <div class="form-group">
            <label for="backflight">Рейс обратно</label>
            <input name='backflight' value="<?= $entry['backflight'] ?>" type="text" class="form-control" id="backflight" placeholder="">
        </div>
        <div class="form-group">
            <label for="priceinc">В стоимость тура включено</label>
            <input required name='priceinc' value="<?= $entry['priceinc'] ?>" type="text" class="form-control" id="priceinc" placeholder="">
        </div>
        <div class="form-group">
            <label for="label">Надпись</label>
            <select name="label" class="form-control" id="label">
                <option value="0" selected>Нет</option>
                <?php
                $labels = array(
                    '0' => array(
                        'value' => 'offer',
                        'name' => 'Горящее предложение'
                    ),
                    '1' => array(
                        'value' => 'action',
                        'name' => 'Акция'
                    ),
                    '3' => array(
                        'value' => 'new',
                        'name' => 'Новый'
                    )
                );
                foreach ($labels as $label):
                    ?>
                    <option <?php
                    if ($label['value'] == $entry['label']) {
                        echo 'selected';
                    }
                    ?> value="<?= $label['value'] ?>"><?= $label['name'] ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="image">Главное изображение</label><br/>
            <div class="well"><img width="200px" style="border: 1px solid black; background-color: grey;" src="/images/<?= $module ?>/<?= $entry['image'] ?>"></div>
            <input name='image' type="file" class="btn-file" id="image">
            <p class="help-block">Выберите главное фото</p>
        </div>
        <script>
            $(document).ready(function () {
                var url = '/admin/' + '<?= $module ?>' + '/images_upload/' + '<?= $entry['id'] ?>';
                $("#upload_image").imageUpload(url, {
                    uploadButtonText: "Добавить",
                    previewImageSize: 150,
                    onSuccess: function (response) {
                        $.ajax(
                                {
                                    url: '/admin/<?= $module ?>/get_images/' + '<?= $entry['id'] ?>',
                                    type: 'POST',
                                    data: {
                                    },
                                    error: function () {
                                        console.log('Ошибка');
                                    },
                                    success: function (data) {
                                        $('.images_group').html(data)
                                        image_del_click_subscription('<?= $module ?>');
                                    }
                                });
                    }
                });
                $.ajax({
                    url: '/admin/<?= $module ?>/get_images/' + '<?= $entry['id'] ?>',
                    type: 'POST',
                    data: {
                    },
                    error: function () {
                        console.log('Ошибка');
                    },
                    success: function (data) {
                        $('.images_group').html(data)
                        image_del_click_subscription('<?= $module ?>');
                    }
                });
            });
        </script>
        <div class="checkbox">
            <label>
                <input name='active' <?php
                if ($entry['active'] == 'on') {
                    echo 'checked';
                }
                ?> type="checkbox"> Активен
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input name='valid' <?php
                if ($entry['valid'] == 'on') {
                    echo 'checked';
                }
                ?> type="checkbox"> Действителен
            </label>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input name='title' value="<?= $entry['title'] ?>" type="text" class="form-control" id="title" placeholder="">
        </div>
        <div class="form-group">
            <label for="metatitle">Мета title</label>
            <input name='metatitle' value="<?= $entry['metatitle'] ?>" type="text" class="form-control" id="metatitle" placeholder="">
        </div>
        <div class="form-group">
            <label for="desc">Мета description</label>
            <textarea name='desc' rows="5" class="form-control" id="desc" placeholder=""><?= $entry['desc'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="keyw">Мета keywords</label>
            <textarea name='keyw' rows="3" class="form-control" id="keyw" placeholder=""><?= $entry['keyw'] ?></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="text">Картинки</label>
        <div class="alert alert-info" role="alert">
            <div id="upload_image"></div>
        </div>
        <div class="images_group"></div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <input type="hidden" name="do" value="<?= $module ?>Edit">
        <button type="submit" class="btn btn-default">Сохранить</button>
    </div>    
</div>
<?php form_close(); ?>