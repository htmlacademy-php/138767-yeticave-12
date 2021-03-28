<form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : "" ?>" action="add.php" enctype="multipart/form-data" method="post">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= isset($errors["lot_name"]) ? "form__item--invalid" : "" ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" >
            <?php show_form_error($errors["lot_name"] ?? 0) ?>
        </div>
        <div class="form__item <?= isset($errors["lot_category_id"]) ? "form__item--invalid" : "" ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="lot_category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php print($category["category_id"]) ?>"><?php print($category["name"]) ?></option>
                <?php endforeach; ?>
            </select>
            <?php show_form_error($errors["lot_category_id"] ?? 0) ?>
        </div>
    </div>
    <div class="form__item form__item--wide <?= isset($errors["description"]) ? "form__item--invalid" : "" ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"></textarea>
        <?php show_form_error($errors["description"] ?? 0) ?>
    </div>
    <div class="form__item form__item--file <?= isset($errors["img_url"]) ? "form__item--invalid" : "" ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <!--   убираю класс visually-hidden т.к кнопка "добавить" с ним не работает         -->
            <input type="file" id="img_url" name="img_url">
<!--            <label for="lot-img">-->
<!--                Добавить-->
<!--            </label>-->
            <?php show_form_error($errors["img_url"] ?? 0) ?>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors["init_price"]) ? "form__item--invalid" : "" ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="init_price" placeholder="0">
            <?php show_form_error($errors["init_price"] ?? 0) ?>
        </div>
        <div class="form__item form__item--small <?= isset($errors["bet_step"]) ? "form__item--invalid" : "" ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="bet_step" placeholder="0">
            <?php show_form_error($errors["bet_step"] ?? 0) ?>
        </div>
        <div class="form__item <?= isset($errors["completed"]) ? "form__item--invalid" : "" ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="completed"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <?php show_form_error($errors["completed"] ?? 0) ?>
        </div>
    </div>
    <?php if (isset($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>

    <button type="submit" class="button">Добавить лот</button>
</form>
