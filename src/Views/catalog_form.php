<section class="cards">
    <a href="http://localhost:81/profile" class="button16">Мой профиль</a>
    <a href="http://localhost:81/OrderUsers" class="button16">Мои заказы</a>
    <a href="/logout" class="button16">Выход</a>

<h3>Каталог</h3>
    <a href="http://localhost:81/cart" class="cart-count"><span>
  <svg height="512pt" viewBox="0 -31 512.00026 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m164.960938 300.003906h.023437c.019531 0 .039063-.003906.058594-.003906h271.957031c6.695312 0 12.582031-4.441406 14.421875-10.878906l60-210c1.292969-4.527344.386719-9.394532-2.445313-13.152344-2.835937-3.757812-7.269531-5.96875-11.976562-5.96875h-366.632812l-10.722657-48.253906c-1.527343-6.863282-7.613281-11.746094-14.644531-11.746094h-90c-8.285156 0-15 6.714844-15 15s6.714844 15 15 15h77.96875c1.898438 8.550781 51.3125 230.917969 54.15625 243.710938-15.941406 6.929687-27.125 22.824218-27.125 41.289062 0 24.8125 20.1875 45 45 45h272c8.285156 0 15-6.714844 15-15s-6.714844-15-15-15h-272c-8.269531 0-15-6.730469-15-15 0-8.257812 6.707031-14.976562 14.960938-14.996094zm312.152343-210.003906-51.429687 180h-248.652344l-40-180zm0 0"/><path d="m150 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/><path d="m362 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/></svg>
  <span class="cart__count"><?php echo $cart; ?></span>
</span></a>
    <div class="container container-cards">
                <?php foreach ($products as $product): ?>
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
                                <div class='quantity_inner'>
                                    <form class="minus" onsubmit="return false" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>" id="product_id" required>
                                        <input  name="amount" type="hidden" id="amount" value="1" required>
                                        <button class="bt_minus"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                                    </form>
                                    <input type="text" value="<?php echo $product->getAmount();?>" size="1" class="quantity" readonly/>
                                    <form class="plus" onsubmit="return false" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>" id="product_id" required>
                                        <input  name="amount" type="hidden" id="amount" value="1" required>
                                        <button class="bt_plus"> <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                                    </form>
                                </div>

                                    <form action="/product" method="POST">
                                        <input type="hidden" placeholder="Enter Product-id" name="product_id" value="<?php echo $product->getId();?>" id="product_id" required>
                                        <input type="submit" value="открыть">
                                    </form>
                        </div>
                </div>

                <?php endforeach;?>
            </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $("document").ready(function () {
        // console.log($(this).serialize());
        $('.plus').submit(function () {
            $.ajax({
                type: "POST",
                url: "/add",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // Обновляем количество товаров в бейдже корзины
                    $('.cart-count').text(response.count);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>
<script>
    $("document").ready(function () {
        $('.minus').submit(function () {
            $.ajax({
                type: "POST",
                url: "/decrease",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // Обновляем количество товаров в бейдже корзины
                    $('.cart-count').text(response.count);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>
<style>
    body {
        padding: 50px;
    }

    .cart-count {
        position: relative;
        display: block;
        width: 50px;
        height: 50px;
        margin-right: auto;
        margin-left: 0;
    }

    .cart-count svg {
        width: 100%;
        height: 100%;
    }

    .cart__count {
        position: absolute;
        right: -10px;
        top: -10px;
        display: inline-block;
        padding: 2px 7px;
        color: #fff;
        background-color: crimson;
        border-radius: 100%;
    }
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

    .container {
        width: 100%;
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .container-cards{
        display: grid;
        width: 100%;
        grid-template-columns:repeat(auto-fill, 225px);
        justify-content: center;
        justify-items: center;
        margin: 50px auto;
        column-gap: 60px;
        row-gap: 70px;
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


    .quantity_inner * {
        box-sizing: border-box;
    }
    .quantity_inner {
        display: inline-flex;
        height: 30px;
        border-radius: 26px;
        border: 4px solid lightslategrey;
    }
    .quantity_inner .bt_minus,
    .quantity_inner .bt_plus,
    .quantity_inner .quantity {
        height: 30px;
        width: 30px;
        padding: 0;
        border: 0;
        margin: 0;
        background: transparent;
        cursor: pointer;
        outline: 0;
    }
    .quantity_inner .quantity {
        width: 25px;
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        color: #000;
        font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
    }
    .quantity_inner .bt_minus svg,
    .quantity_inner .bt_plus svg {
        stroke: lightslategrey;
        stroke-width: 4;
        transition: 0.5s;
        margin: 10px;
    }
    .quantity_inner .bt_minus:hover svg,
    .quantity_inner .bt_plus:hover svg {
        stroke: #000;
    }

</style>
