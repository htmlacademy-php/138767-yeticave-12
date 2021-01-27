<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--<?= $category['symbol_code'] ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= $category['name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $key => $item): ?>
            <?php
                $date_range = get_date_range($item["completed"]);
                $hours = $date_range[0];
                $minutes = $date_range[1];
            ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $item["img_url"] ?>" width="350" height="260" alt="<?= $item["lot_name"] ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $item["name"] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= $item["lot_name"] ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price($item["init_price"]) ?></span>
                        </div>
                        <?php if ($hours >= 0 && $minutes >= 0) {  ?>
                            <div class="lot__timer timer <?= $hours == 0 ? "timer--finishing" : ""; ?> ">
                                <?= $hours . "-" . $minutes ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

