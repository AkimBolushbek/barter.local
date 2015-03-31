<?php if (!empty($entries)): ?>
    <div class="flexslider">
        <ul class="slides">
            <?php foreach ($entries as $entry): ?>
                <li>
                    <img src="/images/slider/<?= $entry['image'] ?>" alt="">
                    <h2><?= $entry['text'] ?></h2>
                </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- /flexslider -->
<?php endif; ?>