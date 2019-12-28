<form class="form container" action="/login.php" method="post">
    <h2>Вход</h2>
    <div class="form__item <?php isset($errors['email']) ? print ('form__item--invalid') : print('');?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="login[email]" placeholder="Введите e-mail" value="<?=$login['email'] ?? ''; ?>">
        <span class="form__error"><?= $errors['email']; ?><?php isset($errors['email']) ? print('Введите e-mail') : print('');?></span>
    </div>
    <div class="form__item form__item--last 
            <?php 
                    if (isset($errors['password']) || isset($errors['error_password']) || isset($errors['registred_email'])){
                        print ('form__item--invalid');
                    }
            ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="login[password]" placeholder="Введите пароль" value="<?php empty($login['password']) ? print('') : print($login['password'])?>"> 
        <span class="form__error">
            <?php
                    if (isset($errors['password'])){
                        print ('Введите пароль');
                    }
                    elseif (isset($errors['email'])){
                        print ('');
                    }
                    elseif (isset ($errors['error_password']) || isset($errors['registred_email'])){
                        print('Неверный логин или пароль');
                    }
            ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
