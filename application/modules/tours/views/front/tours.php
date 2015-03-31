<div class="tours <?php if ($this->uri->segment(1) == 'tours') echo 'abroad_tours' ?>">
    <div class="wrapper">
        <h3 class="main_title">ТУРЫ ОТ TRAVELSHOP</h3>
        <ul>
            <?php
            if (is_array($entries)) {
                foreach ($entries as $entry):
                    ?>
                    <li>
                        <div class="tours_title">
                            <h4><a href="/<?= $module ?>/<?= $entry['url'] ?>/"><?= $entry['name'] ?></a></h4>
                            <h5><a href="/<?= $module ?>/<?= $entry['url'] ?>/"><?= $entry['country'] ?></a></h5>
                        </div>
                        <div class="tours_content">
                            <img style="height: 100%;width:100%;" src="/images/<?= $module ?>/<?= $entry['image'] ?>" alt="<?= $entry['name'] ?>">
                            <?php if ($entry['label'] == 'action'): ?>
                                <h6 style="background: #ef7d00;"><a href="/<?= $module ?>/<?= $entry['url'] ?>/">Акция от TravelShop</a></h6>
                            <?php elseif ($entry['label'] == 'new'): ?>
                                <h6 style="background: #00aaff;"><a href="/<?= $module ?>/<?= $entry['url'] ?>/">Новое предложение</a></h6>
                            <?php elseif ($entry['label'] == 'offer'): ?>
                                <h6 style="background: #ff0400;"><a href="/<?= $module ?>/<?= $entry['url'] ?>/">Горящее предложение</a></h6>
                            <?php else: endif; ?>
                            <div class="tours_price">
                                <p><?= $entry['price'] ?><span>Тур на двоих</span></p>
                                <p class="date"><?= mysql_russian_datemonth($entry['datefrom']) ?><br><?= $entry['duration'] ?></p>
                                <a href="/<?= $module ?>/<?= $entry['url'] ?>/">Подробнее</a>
                            </div>
                        </div>
                    </li>
                    <?php
                endforeach;
            }else {
                echo 'Записей в базе не обнаружено';
            }
            ?>
        </ul>
        <a href="/tours/" class="more_tours">Еще Туры</a>
    </div><!-- /wrapper -->
</div><!-- /tours -->