 <section class="cards">
        <a href="http://localhost:81/profile" class="button16">Мой профиль</a>
        <a href="http://localhost:81/catalog" class="button16">Каталог</a>
        <a href="http://localhost:81/cart" class="button16">Корзина</a>
        <a href="http://localhost:81/OrderUsers" class="button16">Мои заказы</a>
        <a href="/logout" class="button16">Выход</a>
        <h3>Отзывы</h3>
        <div class="container container-cards">
                <div class="card">
                    <div class="card-top">
                        <a href="#" class="card-img">
                            <img src="<?php echo $product->getImageUrl();?>" alt="Card image"/>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-prices">
                            <div class="card-price"> <?php echo $product->getPrice(); ?></div>
                        </div>
                        <div class="card-title"> <?php echo $product->getName(); ?> </div>
                        <div class="card-desc"> <?php echo $product->getDescription(); ?> </div>
                </div>
        </div>
            <?php if ($reviews === null) {?>
                <p>Нет отзывов</p>
            <?php } else {?>
            <p>Средний рейтинг <?php echo ceil($ratingTotal); ?></p>
            <div class="rating-result">
                <span class="<?php if (ceil($ratingTotal) >= 1) echo 'active'; ?>"></span>
                <span class="<?php if (ceil($ratingTotal) >= 2) echo 'active'; ?>"></span>
                <span class="<?php if (ceil($ratingTotal) >= 3) echo 'active'; ?>"></span>
                <span class="<?php if (ceil($ratingTotal) >= 4) echo 'active'; ?>"></span>
                <span class="<?php if (ceil($ratingTotal) >= 5) echo 'active'; ?>"></span>
            </div>
            <p>На основе <?php echo $count;?> оценок</p>

            <?php foreach ($reviews as $review): ?>
                <br>
                <div class="name"> Имя: <?php echo $review->getUser()->getName();?>
                </div>
                <div class="data"><?php echo $review->getReview();?>
                </div>
                <div class="time"><?php echo $review->getTime();?>
                </div>
                <div class="rating-mini">
                    <span class="<?php if ($review->getRating() >= 1) echo 'active'; ?>"></span>
                    <span class="<?php if ($review->getRating() >= 2) echo 'active'; ?>"></span>
                    <span class="<?php if ($review->getRating() >= 3) echo 'active'; ?>"></span>
                    <span class="<?php if ($review->getRating() >= 4) echo 'active'; ?>"></span>
                    <span class="<?php if ($review->getRating() >= 5) echo 'active'; ?>"></span>
                </div>
            <br>

            <?php endforeach; ?>
<br>
            <?php } ?>
            <form action="review-add" method="post">
                <input type="hidden" placeholder="Enter Product-id" name="product_id" value="<?php echo $product->getId();?>" id="product_id" required>
            <label><b>Оставьте отзыв:</b></label>
            <?php if (isset($errors['review'])): ?>
                <label style="color: brown"> <?php echo $errors['review'];?> </label>
            <?php endif; ?>
            <p><textarea name="review" id="review" required></textarea></p>
                <label>Ваша оценка</label>
                <?php if (isset($errors['rating'])): ?>
                    <label style="color: brown"> <?php echo $errors['rating'];?> </label>
                <?php endif; ?>
                <div class="rating-area">
                    <input type="radio" id="star-5" name="rating" value="5">
                    <label for="star-5" title="Оценка «5»"></label>
                    <input type="radio" id="star-4" name="rating" value="4">
                    <label for="star-4" title="Оценка «4»"></label>
                    <input type="radio" id="star-3" name="rating" value="3">
                    <label for="star-3" title="Оценка «3»"></label>
                    <input type="radio" id="star-2" name="rating" value="2">
                    <label for="star-2" title="Оценка «2»"></label>
                    <input type="radio" id="star-1" name="rating" value="1">
                    <label for="star-1" title="Оценка «1»"></label>
                </div>
        <button type="submit" >Оставить отзыв</button>
            </form>
    </section>
    <style>

        h3 {
            display: block;
            margin-bottom: 60px;
            margin-left: 60px;
            font-weight: 1000;
            font-size: 40px;
            line-height: 1.2;
            color: #333333;
            text-align: justify-all;
        }
        .time {
            font-style: oblique;
            font-size: 10px;

        }
        .data {
            border: 2px solid lightslategrey; /* Параметры рамки */
            padding: 10px; /* Поля */
            width: 400px; /* Ширина */
            height: auto; /* Высота */
            box-sizing: border-box; /* Алгоритм расчёта ширины */
            font-size: 14px; /* Размер шрифта */
        }
        textarea {
             /* Цвет фона */
            border: 2px solid #a9c358; /* Параметры рамки */
            padding: 10px; /* Поля */
            width: 400px; /* Ширина */
            height: auto; /* Высота */
            box-sizing: border-box; /* Алгоритм расчёта ширины */
            font-size: 14px; /* Размер шрифта */
        }

        .container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .rating-area {
            overflow: hidden;
            width: 265px;

        }
        .rating-area:not(:checked) > input {
            display: none;
        }
        .rating-area:not(:checked) > label {
            float: right;
            width: 42px;
            padding: 0;
            cursor: pointer;
            font-size: 32px;
            line-height: 32px;
            color: lightgrey;
            text-shadow: 1px 1px #bbb;
        }
        .rating-area:not(:checked) > label:before {
            content: '★';
        }
        .rating-area > input:checked ~ label {
            color: gold;
            text-shadow: 1px 1px #c60;
        }
        .rating-area:not(:checked) > label:hover,
        .rating-area:not(:checked) > label:hover ~ label {
            color: gold;
        }
        .rating-area > input:checked + label:hover,
        .rating-area > input:checked + label:hover ~ label,
        .rating-area > input:checked ~ label:hover,
        .rating-area > input:checked ~ label:hover ~ label,
        .rating-area > label:hover ~ input:checked ~ label {
            color: gold;
            text-shadow: 1px 1px goldenrod;
        }
        .rate-area > label:active {
            position: relative;
        }

        .rating-result {
            width: 265px;

        }
        .rating-result span {
            padding: 0;
            font-size: 32px;
            margin: 0 3px;
            line-height: 1;
            color: lightgrey;
            text-shadow: 1px 1px #bbb;
        }
        .rating-result > span:before {
            content: '★';
        }
        .rating-result > span.active {
            color: gold;
            text-shadow: 1px 1px #c60;
        }

        .rating-mini {
            display: inline-block;
            font-size: 0;
        }
        .rating-mini span {
            padding: 0;
            font-size: 20px;
            line-height: 1;
            color: lightgrey;
        }
        .rating-mini > span:before {
            content: '★';
        }
        .rating-mini > span.active {
            color: gold;
        }
        .card {
            margin:auto;
            overflow: hidden;
            width: 275px;
            min-height: 450px;
            box-shadow: 1px 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            border-radius: 6px;
            position: relative;
            transition: 0.2s;
        }

        .card-desc{
            display: block;
            margin-bottom: 5px;
            font-weight: 400;
            font-size: 16px;
            line-height: 1.2;
            color: black;
            text-align: justify-all;
            width: 275px;
            height: 60px;
            overflow: auto;
        }

        .card-top {
            flex: 0 0 240px;
            position: relative;
            overflow: hidden;
        }
        .card-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
        }
        .card-img > img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: 0.2s;
        }
        .card-img:hover > img {
            transform: scale(1.1);
        }

        .card:hover {
            box-shadow: 4px 8px 16px rgba(255,102,51,0.2);
        }

        .card-body {
            flex: 1 0 auto;
            text-align:center;
        }

        .card-prices {
            display: flex;
            margin-bottom: 15px;
            text-align: center;
        }
        .card-price{
            font-weight: 600;
            font-size: 20px;
            color: black;

        }
        .card-price::after {
            content:"\20BD";
            margin-left: 4px;
        }

        .card-title {
            display: block;
            margin-bottom: 20px;
            font-weight: 400;
            font-size: 16px;
            line-height: 1.2;
            color: black;
            text-align: center;
        }

        a.button16 {
            display: inline-block;
            text-decoration: none;
            padding: 1em;
            outline: none;
            border-radius: 1px;
        }
        a.button16:hover {
            background-image:
                    radial-gradient(1px 45% at 0% 50%, rgba(0,0,0,.6), transparent),
                    radial-gradient(1px 45% at 100% 50%, rgba(0,0,0,.6), transparent);
        }
        a.button16:active {
            background-image:
                    radial-gradient(45% 45% at 50% 100%, rgba(255,255,255,.9), rgba(255,255,255,0)),
                    linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.3));
            box-shadow:
                    inset rgba(162,95,42,.4) 0 0 0 1px,
                    inset rgba(255,255,255,.9) 0 0 1px 3px;
        }



    </style>
