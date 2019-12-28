

<main class="container">
    <?php

    print ('Tab = ' . $tab);

    ?>

    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            
            <?php foreach ($categories as $id => $value):?>
                <li class="promo__item promo__item--<?=$categories[$id]['name_en']?>">
                    <a class="promo__link" href="/?tab=<?=$categories[$id]['name_en']?>"><?=$categories[$id]['name']?></a>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2 id='start'>Открытые лоты</h2>
        </div>

<! Сортировка лотов>

      <div class="content__main-col">
    <header class="content__header">
        <nav class="filter">
            <a class="lot__title text-link lots__item lot" href="/?tab=cheap">Дешевые</a> 
            <a class="lot__title text-link lots__item lot" href="/?tab=expensive">Дорогие</a>
            <a class="lot__title text-link lots__item lot" href="/?tab=old">Свежие</a>
            <a class="lot__title text-link lots__item lot" href="/?tab=new">Старые</a>
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
                         <img sr c="<?=$lots[$key]['image_url']?>" width="350" height="260"  alt="<?=$lots[$key]['name']?>">
                    </a>
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lots[$key]['category']?></span>
                    <h3 class="lot__title">
                        <a class="text-link" href="/?tab=lot&id=<?=$lots[$key]['id']?>"><?=$lots[$key]['name']?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=divide_price($lots[$key]['start_price'])?>
                        </div>
                        <div class="lot__timer timer">
                            <?=remaining_time()?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
</main>