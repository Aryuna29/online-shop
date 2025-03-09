<form action="orderUsers">
<section class="cards">
    <a href="http://localhost:81/profile" class="button16">Мой профиль</a>
    <a href="http://localhost:81/cart" class="button16">Корзина</a>
    <a href="http://localhost:81/catalog" class="button16">Каталог</a>
    <a href="/logout" class="button16">Выход</a>
    <h3>Мои заказы</h3>

    <div class="container container-cards">
        <?php foreach ($newUserOrders as $newUserOrder): ?>
            <div class="card">
                   <label>Номер заказа: <?php echo $newUserOrder->getId();?></label>
                <br>
                <label>Имя: <?php echo $newUserOrder->getContactName();?></label>
                <br>
                <label>Телефон: <?php echo $newUserOrder->getContactPhone();?></label>
                <br>
                <label>Адрес: <?php echo $newUserOrder->getAddress();?></label>
                <br>
                <label>Комментарий: <?php echo $newUserOrder->getComment();?></label>
                <br>
                <hr>
                <?php foreach ($newUserOrder->getNewOrderProducts() as $newOrderProduct): ?>
                    <br>
                    <div class="order"><li><?php echo $newOrderProduct->getProduct()->getName();?>
                            <br>
                            <img src="<?php echo $newOrderProduct->getProduct()->getImageUrl();?>" height="130" width="100" alt="Card image"/>
                            <br>
                            <label>
                                Количество: <?php echo $newOrderProduct->getAmount();?> шт
                                <br>
                                Сумма: <?php echo $newOrderProduct->getSum();?>₽
                            <br>
                            </label></li></div>
                <?php endforeach;?>
                <h4>Сумма заказа: <?php echo $newUserOrder->getTotal();?>₽</h4>
            </div>

        <?php endforeach;?>
    </div>
</section>
</form>
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
        margin: 0 auto;
        column-gap: 60px;
        row-gap: 70px;
    }
    .card {
        margin:auto;
        width: 275px;
        height: 600px;
        overflow: auto;
        box-shadow: 1px 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        border-radius: 6px;
        position: relative;
        transition: 0.2s;
    }


    .card:hover {
        box-shadow: 4px 8px 16px rgba(255,102,51,0.2);
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

