<body>
    <div class="c">

        <header>
            <div class="wrapper">

                <div class="phone_number">
                    <?php $contacts = Modules::run('contacts/get'); ?>
                    <p><?= $contacts['phone'] ?></p>
                </div><!-- /phone_number -->
                <a href="/" class="logo"><img src="/img/logo.png" alt=""></a><!-- /logo -->
                <div class="order_btn">
                    <a id="backcall" href="/backcall/send">Заказать обратный звонок</a>
                </div><!-- /order_btn -->

            </div><!-- /wrapper -->
        </header><!-- /header -->

        <nav>
            <div class="wrapper">
                <div id="pjax-links">
                    <ul>
                        <li><a href="/">ГЛАВНАЯ</a></li>
                        <li><a href="/tours/">ТУРЫ ЗАРУБЕЖ</a></li>
                        <li><a href="/vises/">ВИЗОВЫЕ<br>УСЛУГИ</a></li>
                        <li><a href="/reservation/">ОНЛАЙН<br>БРОНИРОВАНИЕ</a></li>
                        <li><a href="/belay/">МЕДИЦИНСКАЯ<br>СТРАХОВКА</a></li>
                        <li><a href="/contacts/">Контакты</a></li>
                        <li><a href="/allreviews/">ОТЗЫВЫ</a></li>
                    </ul>
                </div>
            </div><!-- /wrapper -->
        </nav><!-- /nav -->