<form action="cart" method="post">
    <a class="container">
        <a href="http://localhost:81/profile" class="button16">Мой профиль</a>
        <a href="http://localhost:81/catalog" class="button16">Каталог</a>
        <a href="http://localhost:81/OrderUsers" class="button16">Мои заказы</a>
        <h3>Корзина</h3>
        <hr>

        <?php foreach ($products as $product): ?>
        <div class="card-name">
            <img src="<?php echo $product->getImageUrl();?>" height="350" width="280" alt="Card image"/>
        </div>
            <div class="card-name">
                <label for="product_id"><?php echo $product->getName();?></label>
            </div>
            <div class="card-name">
                <label for="product_id"> <?php echo $product->getDescription();?></label>
            </div>
            <div class="card-name">
                <label for="product_id"> <?php echo $product->getPrice();?></label>
            </div>

        <div class="card-e">
            <label for="amount">Количество: <?php echo $product->getAmount();?></label>
        </div>

        <?php endforeach;?>
        <form class="mt-4">
            <button type="submit" name="submit" class="btn btn-outline-primary btn-lg btn-block">Удалить</button>
        </form>

        <a href="http://localhost:81/create-order" class="button21">заказать</a>
    </div>
        <hr>
    </a>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
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


    a.button21 {
        display: inline-block;
        width: 5em;
        height: 2em;
        line-height: 2em;
        vertical-align: middle;
        text-align: center;
        text-decoration: none;
        user-select: none;
        color: rgb(0,0,0);
        outline: none;
        border: 1px solid rgba(0,0,0,.4);
        border-top-color: rgba(0,0,0,.3);
        border-radius: 2px;
        background: linear-gradient(rgb(255,255,255), rgb(240,240,240));
        box-shadow:
                0 0 3px rgba(0,0,0,0) inset,
                0 1px 1px 1px rgba(255,255,255,.2),
                0 -1px 1px 1px rgba(0,0,0,0);
        transition: .2s ease-in-out;
    }
    a.button21:hover:not(:active) {
        box-shadow:
                0 0 3px rgba(0,0,0,0) inset,
                0 1px 1px 1px rgba(0,255,255,.5),
                0 -1px 1px 1px rgba(0,255,255,.5);
    }
    a.button21:active {
        background: linear-gradient(rgb(250,250,250), rgb(235,235,235));
        box-shadow:
                0 0 3px rgba(0,0,0,.5) inset,
                0 1px 1px 1px rgba(255,255,255,.4),
                0 -1px 1px 1px rgba(0,0,0,.1);
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
    <style>

