
<main class="container">
    <?php if ($is_tab):?>
             <section class="promo">
             <h2 class="promo__title">Нужен стафф для катки?</h2>
             <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
             <ul class="promo__list">
            <?php foreach ($categories as $id => $value):?>
                <li class="promo__item promo__item--<?=$categories[$id]['name_en']?>">
                    <a class="promo__link" href="/?tab=<?=$categories[$id]['name_en']?>"><?=$categories[$id]['name']?></a>
                </li>
            <?php endforeach; ?>
    <?php endif; ?>
        
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2 id='start'><?=$ru_category_name?></h2>
        </div>

<! Сортировка лотов>

      <div class="content__main-col">
    <header class="content__header">
        <nav class="filter">
            <a class="lot__title sort_text-link lots__item sorting_of_lots" href="/?tab=cheap">Дешевые</a> 
            <a class="lot__title sort_text-link lots__item sorting_of_lots" href="/?tab=expensive">Дорогие</a>
            <a class="lot__title sort_text-link lots__item sorting_of_lots" href="/?tab=new">Свежие</a>
            <a class="lot__title sort_text-link lots__item sorting_of_lots" href="/?tab=old">Старые</a>
            <h1></h1>
        </nav>
    </header>
</div>
<! Сортировка лотов>


        <ul class="lots__list">
            <! Карточка товара>
            <?php foreach ($lots as $key => $value):?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <a href="/?tab=lot&id=<?=$lots[$key]['id']?>">
                         <img src="<?=$lots[$key]['image_url']?>" height="260"  alt="<?=$lots[$key]['name']?>">
                    </a>
                </div>
                <div class="lot__info">
                    <a href="/?tab=<?=$lots[$key]['category_en']?>">
                        <span class="lot__category"><?=$lots[$key]['category']?></span>
                    </a>
                    <h3 class="lot__title">
                        <a class="text-link" href="/?tab=lot&id=<?=$lots[$key]['id']?>"><?=only_2_rows($lots[$key]['name'])?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?php
                                    if (yetti_time($lots[$key]['finish_time']) == 'Прием ставок завершен'){
                                        print ('Финальная цена');
                                    }
                                    elseif (empty($lots[$key]['value'])){
                                        print ('Стартовая цена');
                                    }
                                    else{
                                        print ('Текущая цена');
                                    }
                                    if (!empty($lots[$key]['value'])){
                                        $lots[$key]['start_price'] = $lots[$key]['value'];
                                    }
                                ?></span>
                            <span class="lot__cost"><?=divide_price($lots[$key]['start_price'])?>
                        </div>
                        <div class="lot__timer <?php 
                        if (yetti_time($lots[$key]['finish_time']) == 'Прием ставок завершен'){
                            print ('timer--finishing timer');
                        }
                        else if (empty($lots[$key]['value'])){
                            print ('timer');
                        }
                        else{
                            print ('timer_bidding');
                        }

                            ?>">
                            <?=yetti_time($lots[$key]['finish_time'])?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
</main>