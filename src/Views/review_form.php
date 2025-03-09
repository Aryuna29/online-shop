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
                            <img src="<?php echo $product->getImageUrl();?>"  alt="Card image"/>
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

            <?php foreach ($reviews as $review): ?>
                <br>
                <div class="name"> Имя: <?php echo $review->getUser()->getName();?>
                </div>
                <div class="data"><?php echo $review->getReview();?>
                </div>
            <?php endforeach; ?>

            <form action="review-add" method="post">
            <label><b>Оставьте отзыв:</b></label>
            <?php if (isset($errors['review'])): ?>
                <label style="color: brown"> <?php echo $errors['review'];?> </label>
            <?php endif; ?>
            <p><textarea name="review" id="review" required></textarea></p>
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
