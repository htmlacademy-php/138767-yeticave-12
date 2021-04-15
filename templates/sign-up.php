<form class="form container <?= isset($errors) ? "form--invalid" : "" ?>" action="/sign-up.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?= isset($errors["email"]) ? "form__item--invalid" : "" ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <?php show_form_error($errors["email"] ?? 0) ?>
    </div>
    <div class="form__item <?= isset($errors["password"]) ? "form__item--invalid" : "" ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <?php show_form_error($errors["password"] ?? 0) ?>
    </div>
    <div class="form__item <?= isset($errors["name"]) ? "form__item--invalid" : "" ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя">
        <?php show_form_error($errors["name"] ?? 0) ?>
    </div>
    <div class="form__item <?= isset($errors["message"]) ? "form__item--invalid" : "" ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"></textarea>
        <?php show_form_error($errors["message"] ?? 0) ?>
    </div>
    <?php if (isset($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
