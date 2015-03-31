<footer>
    <div class="wrapper">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/about/">О нас</a></li>
            <li><a href="/blog/">Статьи </a></li>
            <li><a href="/news/">Новости</a></li>
        </ul>
        <a href="http://www.googstudio.com" class="googstudio"></a>
        <p><?= Modules::run('widget/get_widget', 'copyright') ?></p>
        <div class="metrics"></div>
    </div><!-- /wrapper -->
</footer><!-- /footer -->

</div>
<?= Modules::run('widget/getByTitle', 'snipets') ?>
</body>
</html>