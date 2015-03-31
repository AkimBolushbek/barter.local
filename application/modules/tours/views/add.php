<div class="row">
    <div class="col-md-12">
        <a href="/admin/<?= $module ?>">
            <button type="button" class="btn btn-default btn-default"><span class='glyphicon glyphicon-step-backward'></span> Назад к списку</button>
        </a>
    </div>
</div>
<div class="page-header">
    <h2>Добавление записи в модуль "<?= $module_name ?>"</h2>
</div>
<?= form_open_multipart('admin/' . $module . '/add') ?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <button type="submit" class="btn btn-default">Добавить</button>
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
            <input required name='name' value="<?= set_value('name') ?>" type="text" class="form-control name" id="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="url">ЧПУ</label>
            <input required name='url' value="<?= set_value('url') ?>" type="text" class="form-control name_translit" id="url" placeholder="">
        </div>
        <div class="form-group">
            <label for="country">Страна, город</label>
            <input required name='country' value="<?= set_value('country') ?>" type="text" class="form-control" id="country" placeholder="">
        </div>
        <div class="form-group">
            <label for="flightout">Вылет</label>
            <input required name='flightout' value="<?= set_value('flightout') ?>" type="text" class="form-control" id="flightout" placeholder="из Москвы">
        </div>
        <div class="form-group">
            <label for="priceperone">Цена за одного человека</label>
            <input required name='priceperone' value="<?= set_value('priceperone') ?>" type="text" class="form-control" id="priceperone" placeholder="">
        </div>
        <div class="form-group">
            <label for="price">Стоимость</label>
            <input required name='price' value="<?= set_value('price') ?>" type="text" class="form-control" id="price" placeholder="">
        </div>
        <div class="form-group">
            <label for="datefrom">Дата с:</label>
            <div class='input-group date' id='datefrom'>
                <input required name="datefrom" id="datefrom" type='text' value="<?= set_value('datefrom') ?>" class="form-control" />
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
            <input required name='duration' value="<?= set_value('duration') ?>" type="text" class="form-control" id="duration" placeholder="">
        </div>
        <div class="form-group">
            <label for="dateto">Дата по:</label>
            <div class='input-group date' id='dateto'>
                <input required name="dateto" id="dateto" type='text' value="<?= set_value('dateto') ?>" class="form-control" />
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
                    <option value="<?= $hotel['id'] ?>"><?= $hotel['id'] . '. ' . $hotel['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Тип тура</label>
            <input required name='type' value="<?= set_value('type') ?>" type="text" class="form-control" id="type" placeholder="Стандартный двухместный номер с 1 кроватью или 2 отдельными кроватями - одноместное размещение">
        </div>
        <div class="form-group">
            <label for="placement">Размещение</label>
            <input required name='placement' value="<?= set_value('placement') ?>" type="text" class="form-control" id="placement" placeholder="Одноместный номер (SGL)">
        </div>
        <div class="form-group">
            <label for="feed">Питание</label>
            <input name='feed' value="<?= set_value('feed') ?>" type="text" class="form-control" id="feed" placeholder="Завтрак, ужин (или иногда обед на выбор) (HB)">
        </div>
        <div class="form-group">
            <label for="room">Номер</label>
            <input required name='room' value="<?= set_value('room') ?>" type="text" class="form-control" id="room" placeholder="Standard">
        </div>
        <div class="form-group">
            <label for="outflight">Рейс туда</label>
            <input name='outflight' value="<?= set_value('outflight') ?>" type="text" class="form-control" id="outflight" placeholder="">
        </div>
        <div class="form-group">
            <label for="backflight">Рейс обратно</label>
            <input name='backflight' value="<?= set_value('backflight') ?>" type="text" class="form-control" id="backflight" placeholder="">
        </div>
        <div class="form-group">
            <label for="priceinc">В стоимость тура включено</label>
            <input required name='priceinc' value="<?= set_value('priceinc') ?>" type="text" class="form-control" id="priceinc" placeholder="">
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
                    <option value="<?= $label['value'] ?>"><?= $label['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="image">Главное изображение</label><br/>
            <input required name='image' type="file" class="btn-file" id="image">
            <p class="help-block">Выберите главное фото</p>
        </div>
        <div class="checkbox">
            <label>
                <input name='active' type="checkbox"> Активен
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input name='valid' type="checkbox"> Действителен
            </label>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input name='title' value="<?= set_value('title') ?>" type="text" class="form-control" id="title" placeholder="">
        </div>
        <div class="form-group">
            <label for="metatitle">Мета title</label>
            <input name='metatitle' value="<?= set_value('metatitle') ?>" type="text" class="form-control" id="metatitle" placeholder="">
        </div>
        <div class="form-group">
            <label for="desc">Мета description</label>
            <textarea name='desc' rows="5" class="form-control" id="desc" placeholder=""><?= set_value('desc') ?></textarea>
        </div>
        <div class="form-group">
            <label for="keyw">Мета keywords</label>
            <textarea name='keyw' rows="3" class="form-control" id="keyw" placeholder=""><?= set_value('keyw') ?></textarea>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <input type="hidden" name="do" value="<?= $module ?>Add">
        <button type="submit" class="btn btn-default">Добавить</button>
    </div>    
</div>
<?form_close(); ?>