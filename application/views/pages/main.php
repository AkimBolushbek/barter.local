<article>
    <div class="wrapper">
        <div class="news">
            <h4>Новости</h4>
            <?php foreach ($news as $entry): ?>
                <div class="block_item">
                    <a href="/news/<?= $entry['url'] ?>" class="block_img_wrapper"><img src="/images/news/<?= $entry['image'] ?>" alt="<?= $entry['name'] ?>"></a>
                    <div class="block_item_content">
                        <h5><a href="/news/<?= $entry['url'] ?>"><?= mb_strimwidth(strip_tags($entry['name']), 0, 61, "..."); ?></a></h5>
                        <p><?= mb_strimwidth(strip_tags($entry['text']), 0, 200, "..."); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <a href="/news/" class="read_more">Читать еще...</a>

        </div><!-- news -->

        <div class="blog">
            <h4>Блог</h4>
            <?php foreach ($blog as $entry): ?>
                <div class="block_item">
                    <a href="/blog/<?= $entry['url'] ?>" class="block_img_wrapper"><img src="/images/blog/<?= $entry['image'] ?>" alt="<?= $entry['name'] ?>"></a>
                    <div class="block_item_content">
                        <h5><a href="/blog/<?= $entry['url'] ?>"><?= mb_strimwidth(strip_tags($entry['name']), 0, 61, "..."); ?></a></h5>
                        <p><?= mb_strimwidth(strip_tags($entry['text']), 0, 200, "..."); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <a href="/blog/" class="read_more">Читать еще...</a>

        </div><!-- blog -->
    </div><!-- /wrapper -->
</article><!-- /article -->


<div class="search_tour">
    <div class="wrapper">
        <!--<input type="button" id="button_1">-->
        <!--<? base_url() ?>css/form.css-->
        <iframe id="search_tours" src="http://spb.ntk-intourist.ru/main.aspx?userCSS=http://travelshop.kg/css/form.css" width="100%" height="100%"></iframe>
    </div><!-- /wrapper -->
</div><!-- /search_tour -->

<?= Modules::run('tours/view', true) ?>

<div class="hotel">
    <div class="wrapper">

        <h3 class="main_title">НАЙТИ ОТЕЛЬ</h3>

        <div class="left_side">
            <p class="blue"><?= Modules::run('widget/getByTitle', 'main-text-1') ?></p>
            <p><?= Modules::run('widget/getByTitle', 'main-text-2') ?></p>
        </div>

        <?= Modules::run('requests/save'); ?>

    </div><!-- /wrapper -->
</div><!-- /hotel -->

<div class="reviews">
    <div class="wrapper">

        <h3 class="main_title">ОТЗЫВЫ КЛИЕНТОВ</h3>

        <div class="flexslider">
            <ul class="slides reviews_slider">
                <?= Modules::run('allreviews/get_for_slider') ?>
            </ul>
        </div><!-- /flexslider -->

    </div><!-- /wrapper -->
</div><!-- /reviews -->




<div class="partners">
    <?= Modules::run('partners/view', true) ?>
</div><!-- /partners -->
