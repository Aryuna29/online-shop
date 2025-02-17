<section class="cards">
<div class="card-profile"><a href="http://localhost:81/profile" type="button">Мой профиль</a></div>
<div class="card-cart"><a href="http://localhost:81/cart" type="button">Корзина</a></div>

    <div class="card-exit"><a href="/logout" type="button">Выход</a></div>
<h3>Каталог</h3>

    <div class="container container-cards">
                <?php foreach ($products as $product): ?>
                <div class="card">
                    <div class="card-top">
                        <a href="#" class="card-img">
                         <img src="<?php echo $product['image_url']?>"  alt="Card image"/>
                        </a>
                    </div>
                            <div class="card-body">
                                <div class="card-prices">
                                 <div class="card-price"> <?php echo $product['price']; ?></div>
                            </div>
                            <div class="card-title"> <?php echo $product['name']; ?> </div>
                                <div class="card-desc"> <?php echo $product['description']; ?> </div>
                        </div>
                </div>
                    <form action="catalog" method="POST">
                        <div class="container">
                            <input type="hidden" placeholder="Enter Product-id" name="product_id" value="<?php echo $product['id'];?>" id="product_id" required>

                            <label for="amount"><b>Amount</b></label>
                            <?php if (isset($errors['amount'])): ?>
                                <label style="color: brown"> <?php echo $errors['amount'];?> </label>
                            <?php endif; ?>
                            <input type="text" placeholder="Enter Amount" name="amount" id="amount" required>
                            <hr>
                            <button type="submit" name="submit">Добавить в корзину</button>
                        </div>

                    </form>
                <?php endforeach;?>
            </div>
    </div>
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
    .card-cart{
        margin-right: 60px;
        display: block;
        margin-bottom: 10px;
        font-weight: 700;
        font-size: 18px;
        line-height: 0;
        color: black;
        text-align: right;
    }
    .card-profile{
        display: block;
        margin-right: 60px;
        margin-bottom: 10px;
        font-weight: 700;
        font-size: 18px;
        line-height: 2;
        color: black;
        text-align: right;
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

    .card-btn {
        display: block;
        width: 100%;
        font-weight:700;
        font-size: 16px;
        color: #70c05b;
        padding: 10px;
        text-align: center;
        border: 1px solid #70c05b;
        border-radius: 4px;
    }


</style>
