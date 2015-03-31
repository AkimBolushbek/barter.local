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
<?php echo form_open(uri_string());?>

<p>
    <?php echo ('First Name');?> <br />
    <?php echo form_input($entry['first_name']);?>
</p>

<p>
    <?php echo ('Last Name');?> <br />
    <?php echo form_input($entry['last_name']);?>
</p>

<p>
    <?php echo ('e-mail');?> <br />
    <?php echo form_input($entry['email']);?>
</p>

<p>
    <?php echo ('phone');?> <br />
    <?php echo form_input($entry['phone']);?>
</p>

<p>
    <?php echo ('Password');?> <br />
    <?php echo form_input($entry['password']);?>
</p>

<p>
    <?php echo ('Password Confirm');?><br />
    <?php echo form_input();?>
</p>



<p><?php echo form_submit('submit', 'Save');?></p>

<?php echo form_close();?>