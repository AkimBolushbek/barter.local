<style type="text/css">
.no_revs{
	  text-align: center;
  		margin-bottom: 20px;
  		color:red;
  		font-weight: bold;
}
</style>
<script type="text/javascript">
$( document ).ready(function() {
	var startFrom = 5;
	$('.more_reviews').click(function(e){
		e.preventDefault();
		$.ajax({
		  type: "POST",
		  url: "/allreviews/ajax_load",
		  data: ({startFrom : startFrom}),
		}).done(function(data) {
		  data = jQuery.parseJSON(data);
		  if (data.length > 0) {
			$.each(data, function(index,data){
           	 $("#ajax_reviews").append('<div class="reviews_inner_item"><p>' + data.text + "</p><h6>" + data.name + ", "+data.date+"</h6></div>");
            });
            startFrom += 5;
		  }
		  else{
		  	$('.more_reviews').before( "<p class='no_revs'>Нет записей</p>" );
		  	setTimeout(function() {
    			$('.no_revs').fadeOut('slow');
			}, 1000);
		  }
		  console.log(startFrom);
		});
	});
});
</script>

<?php if (!empty($entries)): ?>
	<div id="ajax_reviews">
    <?php foreach ($entries as $e): ?>
        <div class="reviews_inner_item">
            <p><?= $e['text'] ?></p>
            <h6><?= $e['name'] ?>, <?= date('d.m.Y H:i', strtotime($e['date'])) ?></h6>
        </div>
    <?php endforeach; ?>
	</div>
    <a href="" class="more_reviews">Еще отзывы</a>
<?php else: ?>
    <p>Отзывов еще никто не добавлял. Будьте первым!</p>
<?php endif; ?>