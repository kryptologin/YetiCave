<main>
    <form class="form container <?php // isset($errors) ? print ('form__item--invalid') : print (''); ?>" action="../signup.php" method="post" enctype="multipart/form-data">
        <h2>Регистрация нового аккаунта</h2>
        
        <div class="form__item <?php (isset($errors['email']) || (isset ($errors['unique_email']) && $errors['unique_email'] == false)) ? print ('form__item--invalid') : print (''); ?>">
            <label for="email">E-mail*</label>

            <input id="email" type="email" name="reg[email]" placeholder="Введите e-mail" value="<?=$reg['email'] ?? ''; ?>">

            <span class="form__error">
                <?php
                    if (isset($errors['email'])){
                        print ('Введите e-mail');
                    }
                    elseif (isset ($errors['unique_email']) && $errors['unique_email'] == false) {
                        print('Пользователь с таким e-mail уже существует');
                    }
                ?>
            </span>
        </div>
        
        <div class="form__item <?php if (isset($errors['password'])) { echo 'form__item--invalid'; } ?>">
            <label for="password">Пароль*</label>
           
            <input id="password" type="password" name="reg[password]" placeholder="Введите пароль" value="<?=$reg['password'] ?? ''; ?>">
            <span class="form__error"><?php isset($errors['password']) ? print('Введите пароль') : print(''); ?></span>
        
        </div>
        
        <div class="form__item <?php if (isset($errors['name'])) { echo 'form__item--invalid'; } ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="reg[name]" placeholder="Введите имя" value="<?=$reg['name'] ?? ''; ?>">
            <span class="form__error"><?php isset($errors['name']) ? print('Введите имя пользователя') : print(''); ?></span>
        </div>
        <div class="form__item <?php if (isset($errors['message'])) { echo 'form__item--invalid'; } ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="reg[message]" placeholder="Напишите как с вами связаться"><?=$reg['message'] ?? ''; ?></textarea>
            <span class="form__error"><?php isset($errors['message']) ? print('Напишите как с вами связаться') : print(''); ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?php if (isset($errors['image'])) { echo 'form__item--invalid'; } ?>">
            <label>Аватар</label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="image" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= $errors['image'] ?? ''; ?></span>
        </div>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="/?tab=login">Уже есть аккаунт</a>
    </form>
</main>