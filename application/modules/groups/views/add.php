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
<?php echo form_open(uri_string());?>
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
            <input required name='name'  type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="name">Описание</label>
            <textarea required name='description' class="form-control" rows="5" id="description"></textarea>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <input type="hidden" name="do" value="<?= $module ?>Add">
        <button type="submit" class="btn btn-default">Добавить</button>
    </div>
</div>
<?php echo form_close();?>