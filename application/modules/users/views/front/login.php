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
                <label for="name">Логин</label>
                <input required name='username'  type="text" class="form-control" id="username">
            </div>
            <div class="control-group">
                <label class="control-label" for="password">Пароль</label>
                <input type="password" id="password" name="password" class="input-xlarge">
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <input type="hidden" name="do" value="<?= $module?>Login">
            <button type="submit" class="btn btn-default">Войти</button>
        </div>
    </div>
<?php echo form_close();?>