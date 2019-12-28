<main>
  <form class="form form--add-lot container <?php isset($errors) ? print ('form_invalid') : print ('') ?>" action="/add_lot.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two"> 

      <div class="form__item <?php isset($errors['name']) ? print ('form__item--invalid') : print ('') ?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>


        <input id="lot-name" type="text" name="add_lot[name]" placeholder="Введите наименование лота" value="<?=isset($add_lot['name']) ? $add_lot['name'] : '';?>">
        


        <span class="form__error">Введите наименование лота</span>
      
      </div>

      <div class="form__item <?php isset($errors['category_id']) ? print ('form__item--invalid') : print ('') ?>">
        <label for="category">Категория</label>

        <select id="category" name="add_lot[category_id]">

            <option value= ""> Выберите категорию</option>
                 <?php foreach ($categories as $key => $value):?>  
          <option <?= (isset($add_lot['category_id']) && $key+1 == $add_lot['category_id']) ? "selected" : "";?> value="<?=$categories[$key]['id']?>"><?=$categories[$key]['name']?></option>

            <?php endforeach;?>
        

        </select>
        <span class="form__error">Выберите категорию</span>
      </div>
    </div>
    <div class="form__item form__item--wide <?php isset($errors['description']) ? print ('form__item--invalid') : print ('') ?>">
      <label for="message">Описание</label>



      <textarea id="message" name="add_lot[description]" placeholder="Добавьте описание лота" value=""><?=isset($add_lot['description']) ? $add_lot['description'] : '';?></textarea>
      


      <span class="form__error">Добавьте описание лота</span>
    </div>

    <div class="form__item form__item--file "> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">



          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
       


        </div>
      </div>




      <div class="form__input-file">

        <input class="visually-hidden" type="file" id="photo2" value="lot" name = "lot">
        
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?php isset($errors['start_price']) ? print ('form__item--invalid') : print ('') ?>">
        <label for="lot-rate">Начальная цена</label>



        <input id="lot-rate" type="number" name="add_lot[start_price]" placeholder="0" value="<?=isset($add_lot['start_price']) ? $add_lot['start_price'] : '';?>">
        


        <span class="form__error">Введите начальную цену</span>
      </div>
      
      <div class="form__item form__item--small <?php isset($errors['bet_step']) ? print ('form__item--invalid') : print ('') ?>">
        <label for="lot-step">Шаг ставки</label>



        <input id="lot-step" type="number" name="add_lot[bet_step]" placeholder="0" value="<?=isset($add_lot['bet_step']) ? $add_lot['bet_step'] : '' ;?>">
        


        <span class="form__error">Введите шаг ставки</span>
      </div>
      <div class="form__item <?php isset($errors['finish_time']) ? print ('form__item--invalid') : print ('') ?>">
        <label for="lot-date">Дата окончания торгов</label>



        <input class="form__input-date" id="lot-date" type="date" name="add_lot[finish_time]" value="<?php 
              if (isset($errors['finish_time'])){
                print ($add_lot['finish_time']);
              }
              else if (isset($add_lot['finish_time'])){
                print ($add_lot['finish_time']);
              }
              else {
                print (date('Y-m-d', strtotime('+1 day')));
              }
          ?>">

        <span class="form__error">
          <?=isset($errors['finish_time']) ? $errors ['finish_time'] : '';?>  
        </span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>
</body>
</html>
