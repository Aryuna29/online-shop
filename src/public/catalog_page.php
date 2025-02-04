<div class="container">
    <h3>Каталог</h3>
    <div class="card-deck" style=" display: -webkit-inline-flex ">
        <?php foreach ($products as $product): ?>
            <div class="card text-center" style="margin:3% 5%">
                <a href="#">
                    <img class="card-img-top" src="<?php echo $product['image_url']?>" alt="Card image">
                    <div class="card-body" style="text-align: center">
                        <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product['price'] .' руб'; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;?>
    </div>
</div>

<style>
    body {
        font-style: italic;
        background-color: lightgray;

    }

    a {
        color: black;
        text-decoration: none;
    }

    a:hover {
        text-decoration: black;
    }

    h3 {
        font-style: normal;
        font-size: 30px;
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    img {
        box-shadow: 10px 5px 5px lavender;
        width: 300px;
        height: 300px;
    }

    .text-muted {
        font-size: 20px;
    }

    .card-footer{
        font-weight: lighter;
        font-size: 25px;
        background-color: lightgray;
    }
</style>
