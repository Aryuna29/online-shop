<div class="container">
    <form action="profile" method="post">
        <div class="card-link">
            <li ng-class="{ active: isSet(2) }">
                <a href="http://localhost:81/catalog" ng-click="setTab(2)">Каталог</a>
            </li>
        </div>
        <div class="card-info">
            <h1>Профиль</h1>
        </div>
        <div class="card-obs">
            <div class="card-top">
                <a href="#" class="card-img">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwFCGhmH9R7iIqQmrP-wS4Gw36vKtR9xFG-A&s"  alt="Card image"/>
                </a>
            </div>
            <div class="card-name">
                <label for="name">Name: <?php echo $user['name'] ?></label>
            </div>
            <div class="card-e">
                <label for="email">Email: <?php echo $user['email']?></label>
            </div>

            <div class="card-btn">
                <a href="http://localhost:81/editedProfile" ng-click="setTab(2)">Изменить данные</a>
            </div>
        </div>

    </form>
</div>

<style>
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

</style>