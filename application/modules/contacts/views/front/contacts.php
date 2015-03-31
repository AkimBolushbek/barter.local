<div class="contacts_col_1 contacts_col">
    <p>Мы также есть в социальных сетях,следите за нашими новостями и новыми турами.</p>
    <div class="social_icons">
        <?php if ($entry['social_vk']): ?>
            <a href="http://vk.com/<?= $entry['social_vk'] ?>" class="vk"></a>
        <?php endif; ?>
        <?php if ($entry['social_fb']): ?>
            <a href="http://fb.com/<?= $entry['social_fb'] ?>" class="fc"></a>
        <?php endif; ?>
        <?php if ($entry['social_tw']): ?>
            <a href="http://twitter.com/<?= $entry['social_tw'] ?>" class="tw"></a>
        <?php endif; ?>
        <?php if ($entry['social_ok']): ?>
            <a href="http://ok.ru/<?= $entry['social_ok'] ?>" class="ok"></a>
        <?php endif; ?>
        <?php if ($entry['social_insta']): ?>
            <a href="http://instagram.com/<?= $entry['social_insta'] ?>" class="insta"></a>
        <?php endif; ?>
    </div>
</div>

<div class="contacts_col_2 contacts_col">
    <p>Адрес: <?= $entry['adress'] ?></p>
    <p>Тел: <?= $entry['phone'] ?></p>
    <p>E-mail: <?= $entry['email'] ?></p>
</div>