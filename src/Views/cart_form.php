<form action="cart" method="post">
    <div class="container">
        <div class="card-profile"><a href="http://localhost:81/profile" type="button">Мой профиль</a></div>
        <div class="card-cart"><a href="http://localhost:81/catalog" type="button">Каталог</a></div>
        <h1>Корзина</h1>
        <hr>

        <?php foreach ($products as $product): ?>
        <div class="card-name">
            <img src="<?php echo $product['image_url']?>" height="350" width="280" alt="Card image"/>
        </div>
            <div class="card-name">
                <label for="product_id"><?php echo $product['name'] ?></label>
            </div>
            <div class="card-name">
                <label for="product_id"> <?php echo $product['description'] ?></label>
            </div>
            <div class="card-name">
                <label for="product_id"> <?php echo $product['price'] ?></label>
            </div>

        <div class="card-e">
            <label for="amount">Количество: <?php echo $product['amount']?></label>
        </div>

        <?php endforeach;?>
        <button type="submit" name="submit" >Удалить</button>
        <div class="card-btn">
            <a href="http://localhost:81/catalog" ng-click="setTab(2)">Добавить товар</a>
        </div>
        <div class="card-cart"><a href="http://localhost:81/order" type="button">заказать</a></div>
    </div>
        <hr>

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

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
    <style>

