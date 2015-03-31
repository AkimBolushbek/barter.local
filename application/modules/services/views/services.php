<script src="<?php echo base_url();?>js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/tagit.ui-zendesk.css">
<style type="text/css">
.ui-helper-hidden-accessible { display:none; }
</style>
<script type="text/javascript">
	$(document).ready(function() {
		var readTags = false;
		$(".myTags").click(function(){
			readTags = true;
		});

		$(".myTags").tagit({
			allowSpaces:true,
			afterTagAdded: function(event, ui) {
				var tagLabel = ui.tagLabel;
				var serviceId = ($(this).data('service'));
				if(readTags){
					$.ajax({
						type: "POST",
						data: ({tagLabel : tagLabel,serviceId : serviceId}),
						url: '/services/add_tab',
					});
				}
			},
			afterTagRemoved:function(event, ui) {
				var tagLabel = ui.tagLabel;
				var serviceId = ($(this).data('service'));
				$.ajax({
						type: "POST",
						data: ({tagLabel : tagLabel,serviceId : serviceId}),
						url: '/services/delete_tab',
					});
			},
		});
	});
</script>
<a href='/admin/<?= $module ?>/add'><button type="button" style='margin-bottom:20px;' class="btn btn-default btn-default">Добавить</button></a>
<table class="table table-bordered">
	<?php if (is_array($entries)) { ?>
		<tr>
			<td style="text-align:center" width="5%">#</td>
			<td width="20%">Текст</td>
			<td width="5%">Картинка</td>
			<td width="50%">услуги</td>
			<td width="5%">Активен</td>
			<td width="5%">Порядок</td>
			<td width="5%">Редактировать</td>
			<td width="5%">Удалить</td>
		</tr>
		<?php
		foreach ($entries as $entry):
			?>
			<tr>
				<td style="text-align:center" class="id"><?= $entry['id'] ?></td>
				<td><?= mb_strimwidth(strip_tags($entry['text']), 0, 50, "..."); ?></td>
				<td style="text-align:center"><img width="30px" src='/images/<?= $module ?>/<?= $entry['image'] ?>'></td>
				
				<td>
					<ul class="myTags" data-service="<?= $entry['id'] ?>">
					<?php foreach ($entry['elems'] as $elem):	?>
						<li><?php echo $elem?></li>
					<?php endforeach ?>
					</ul>

				</td>
				<td style="text-align:center"><?php
					if ($entry['active'] == 'on') {
						echo '<span style="-webkit-user-select: none;" class="label label-success active">да</span>';
					} else {
						echo '<span style="-webkit-user-select: none;" class="label label-danger active">нет</span>';
					}
					?></td>
				<td ><a href='/admin/<?= $module ?>/up/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-arrow-up"></span></a><a href='/admin/<?= $module ?>/down/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-arrow-down"></span></a> (<?= $entry['order'] ?>)</td>
				<td style="text-align:center"><a href='/admin/<?= $module ?>/edit/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-edit"></span></a></td>
				<td style="text-align:center"><a href='/admin/<?= $module ?>/delete/<?= $entry['id'] ?>'><span class="glyphicon glyphicon-remove"></span></a></td>
			</tr>
			<?php
		endforeach;
	} else {
		echo '<div class="alert alert-danger" role="alert"><strong>Oops! </strong>Записей в базе не найдено</div>';
	}
	?>
</table>