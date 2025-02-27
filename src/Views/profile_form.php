<div class="container">
    <form action="profile" method="post">
        <div class="card-link">
                <a href="http://localhost:81/catalog" class="button16">Каталог</a>
            </li>
        </div>
        <div class="card-info">
            <h3>Профиль</h3>
        </div>
        <div class="card-obs">
            <div class="card-top">
                <a href="#" class="card-img">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwFCGhmH9R7iIqQmrP-wS4Gw36vKtR9xFG-A&s"  alt="Card image"/>
                </a>
            </div>
            <div class="card-name">
                <label for="name">Name: <?php echo $user->getName();?></label>
            </div>
            <div class="card-e">
                <label for="email">Email: <?php echo $user->getEmail();?></label>
            </div>

            <div class="card-btn">
                <a href="http://localhost:81/editedProfile" ng-click="setTab(2)">Изменить данные</a>
            </div>
        </div>

    </form>
</div>

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

    .card-obs {
        margin:auto;
        overflow: auto;
        width: 500px;
        min-height: 550px;
        box-shadow: 1px 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        border-radius: 6px;
        position: relative;
        transition: 0.2s;
    }

    .card-top{
        width: 500px;
        height: 300px;
        text-align: center;
    }
    .card-name{
        display: block;
        margin-left: 30px;
        margin-bottom: 20px;
        font-weight: 400;
        font-size: 16px;
        line-height: 1.2;
        color: black;
    }

    .card-e{
        display: block;
        margin-left: 30px;
        margin-bottom: 20px;
        font-weight: 400;
        font-size: 16px;
        line-height: 1.2;
        color: black;
    }
    .card-btn{
        display: block;

        font-size: 20px;
        color: #70c05b;
        padding: 20px;
        text-align: center;
        border-radius: 4px;
    }

    h1, p, a {
        color: #4DC9C9 !important;
    }

    .nav-pills > li.active > a, .btn-primary {
        background-color: #6C6C6C !important;
        border-color: #6C6C6C !important;
        border-radius: 25px;
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