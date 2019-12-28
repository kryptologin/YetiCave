<?php
    //   $add_rate = $_POST;
    //   print ('<pre>');
    // print ('$add_rate<br>');
    // var_dump($lot);
    // print ('$_GET<br>');
    // var_dump($_GET);
    // print ('</pre><br>');
?>
<main>
  <section class="lot-item container">
    <h2><?=$lot['name']?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <!-- <img src="<?=$lot['image_url']?>" height="100%" alt="<?=$lot['name']?>"> -->
          <img src="<?=$lot['image_url']?>" width="730" height="550" alt="<?=$lot['name']?>">
        </div>
        <p class="lot-item__category">Категория: 
          <a href="/?tab=<?=$lot['category_en']?>">
              <span><?=$lot['category']?></span></p>
          </a>
        <p class="lot-item__description"><?=$lot['description']?></p>
      </div>
      <div class="lot-item__right">
        <div class="lot-item__state">
          <div class="lot-item__timer 
                  <?php 
                        if (yetti_time($lot['finish_time']) == 'Прием ставок завершен'){
                            print ('timer--finishing timer');
                        }
                        else if (empty($lot['bets'])){
                            print ('timer');
                        }
                        else{
                            print ('timer_bidding');
                        }
                            ?>">
            <?=yetti_time($lot['finish_time'])?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">
                  <?php 
                    if (yetti_time($lot['finish_time']) == 'Прием ставок завершен'){
                        print ('Финальная ');
                    }
                    elseif (empty($lot['bets'])){
                        print ('Стартовая ');
                    }
                    else{
                      print ('Текущая ');
                    }
                    print ('цена</span>');
                    if (!empty($lot['bets'][0]['value'])){
                        $lot['start_price'] = $lot['bets'][0]['value'];
                    }
                  ?>
              <span class='lot-item__cost'><?=divide_price($lot['start_price'])?></span>
            </div>
            <div class="lot-item__min-cost" <?php isset($errors) ? print (" style='color:#e6554e'") : print ("") ?> >
              <?php 
                if (yetti_time($lot['finish_time']) != 'Прием ставок завершен'){
                  print ("Мин. ставка <span>" . divide_price($lot['start_price'] + $lot['bet_step']) . "</span>");
                }
                ?>
            </div>
          </div>

          <form class="lot-item__form" action="/add_rate.php" method="post">
            <p class="lot-item__form-item <?php isset($errors) ? print ("form__item--invalid") : print ("") ?>">
              <label for="cost"><?php (yetti_time($lot['finish_time']) != 'Прием ставок завершен') ? print ('Ваша ставка') : print ('')?></label>
              <?php 
                if (yetti_time($lot['finish_time']) != 'Прием ставок завершен'){
                   isset($errors) ? $err_style =" style='border-color: #e6554e;'" : $err_style ="";
                    print ("<input id='rate' class='form__item--invalid'" . $err_style . " type='number' name='rate' placeholder='" . ($lot['start_price'] + $lot['bet_step']) . "' value='" . ($lot['start_price'] + $lot['bet_step']) . "'>");
                }
              ?>

            </p>
             <input type="hidden" id="lot_id" name="lot_id" value="<?=$lot['id']?>">
                <?php 
                  if (yetti_time($lot['finish_time']) != 'Прием ставок завершен'){
                    print ("<button type='submit' class='button'>Сделать ставку</button>");
                  }
                ?>
          </form>
        </div>

        <div class="history">
          <h3><?php empty($lot["bets"]) ? print ('') : print ('История ставок (<span>' . count($lot["bets"]) . '</span>)')?></h3>
          <table class="history__list">

<?php foreach ($lot["bets"] as $key => $value): ?>
            <tr class="history__item">
              <td class="history__name"<?php ($key == 0 && yetti_time($lot['finish_time']) == 'Прием ставок завершен') ? print ('style="color: #f84645;"') : print ('');?>><?=$value['user_name']?></td>
              <td class="history__price" <?php ($key == 0 && yetti_time($lot['finish_time']) == 'Прием ставок завершен') ? print ('style="color: #f84645; font-weight: bold;"') : print ('');?>><?=divide_price ($value['value'])?></td>
              <td class="history__time" <?php ($key == 0 && yetti_time($lot['finish_time']) == 'Прием ставок завершен') ? print ('style="color: #f84645; font-weight: bold;"') : print ('');?>><?=$value['creation_time']?></td>
            </tr>
<?php endforeach ?>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
