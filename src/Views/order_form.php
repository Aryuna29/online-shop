
<div class="card-cart"><a href="http://localhost:81/cart" type="button">Корзина</a></div>
<form action="order" method="POST">
    <div class="container">
        <h1>Order</h1>
        <hr>

        <label for="address"><b>Address</b></label>
        <?php if (isset($errors['address'])): ?>
            <label style="color: brown"> <?php echo $errors['address'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter address" name="address" id="address" required>

        <label for="phone"><b>phone</b></label>
        <?php if (isset($errors['phone'])): ?>
            <label style="color: brown"> <?php echo $errors['phone'];?> </label>
        <?php endif; ?>
        <input type="text" placeholder="Enter phone" name="phone" id="phone" required>
        <?php foreach ($products as $product): ?>
            <div class="card-name">
                <label for="product_id"><?php echo $product['name'] ?></label>
            </div>

            <div class="card-name">
                <label for="product_id"> <?php echo $product['price'] ?></label>
            </div>

            <div class="card-e">
                <label for="amount">Количество: <?php echo $product['amount']?></label>
            </div>
        <?php endforeach;?>

        <hr>

        <button type="submit" name="submit">Оформить заказ</button>
    </div>

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