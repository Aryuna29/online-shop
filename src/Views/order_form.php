
<a href="http://localhost:81/cart" class="button16">Корзина</a>
<a href="http://localhost:81/OrderUsers" class="button16">Мои заказы</a>
<form action="create-order" method="POST">
    <div class="container">
        <h3>Заказ</h3>
        <hr>
        <label for="contact_name"><b>Имя</b></label>
        <?php if (isset($errors['contact_name'])): ?>
            <label style="color: brown"> <?php echo $errors['contact_name'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter contact name" name="contact_name" id="contact_name" required>

        <label for="contact_phone"><b>Телефон</b></label>
        <?php if (isset($errors['contact_phone'])): ?>
            <label style="color: brown"> <?php echo $errors['contact_phone'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter contact phone" name="contact_phone" id="contact_phone" required>

        <label for="address"><b>Адрес</b></label>
        <?php if (isset($errors['address'])): ?>
            <label style="color: brown"> <?php echo $errors['address'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter address" name="address" id="address" required>

        <label for="comment"><b>Комментарий</b></label>
        <?php if (isset($errors['comment'])): ?>
            <label style="color: brown"> <?php echo $errors['comment'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter comment" name="comment" id="comment" required>
        <hr>
        <div class="order"><h2>Заказ</h2></div>
        <?php foreach ($newProductOrder as $product): ?>
        <div class="order"><li><strong><?php echo $product->getName();?><br> </strong>
        <label>Стоимость <?php echo $product['amount'];?> шт * <?php echo $product->getPrice();?>₽ : <?php echo $product['cost'];?>₽</label></li></div>
        <?php endforeach;?>
        <div class="order"><h2>Общая стоимость: <?php echo $totalCost;?> ₽</h2> </div>
        <hr>
        <button type="submit" class="orderbtn">Оформить заказ</button>
    </div>

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

    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        display: inline-block;
        margin-left: 300px;
        margin-right: auto;
    }

    .order {
        display: flex;
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
    .orderbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .orderbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
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