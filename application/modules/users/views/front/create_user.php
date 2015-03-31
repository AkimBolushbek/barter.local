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
            <div class="form-group">
                  <label for="name">Имя</label>
                  <input required name='first_name' type="text" class="form-control" id="first_name">
            </div>
            <div class="form-group">
                  <label for="last_name">Фамилия</label>
                  <input required name='last_name'  type="text" class="form-control" id="last_name">
            </div>
            <div class="form-group">
                  <label for="email">email</label>
                  <input required name='email'  type="text" class="form-control" id="email">
            </div>
            <div class="form-group">
                  <label for="phone">Телефон</label>
                  <input required name='phone' type="text" class="form-control" id="phone" >
            </div>
            <div class="form-group">
                  <label for="company">Компания</label>
                  <input required name='company' type="text" class="form-control" id="company" >
            </div>
            <div class="form-group">
                  <label for="password">Пароль</label>
                  <input required name='password' type="password" class="form-control" id="password" >
            </div>
            <div class="form-group">
                  <input required name='password_confirm' type="password" data-match="#password"  class="form-control" id="company" placeholder="Confirm">
            </div>
      </div>
</div>
<div class="row" style="margin-top: 10px;">
      <div class="col-md-12">
            <input type="hidden" name="do" value="<?= $module?> Add">
            <button type="submit" class="btn btn-default">Добавить</button>
      </div>
</div>
<?php echo form_close();?>
