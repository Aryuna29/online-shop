
<div class="container">
    <form action="editedProfile" method="POST">
        <div class="card-link">
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
                <?php if (isset($errors['name'])): ?>
                    <label style="color: brown"> <?php echo $errors['name'];?> </label>
                <?php endif; ?>
                <label for="name">Name:</label>
                <input name="name" value="<?php echo $user->getName();?>">
            </div>
            <div class="card-e">
                <?php if (isset($errors['email'])): ?>
                    <label style="color: brown"> <?php echo $errors['email'];?> </label>
                <?php endif; ?>
                <label for="email">Email:</label>
                <input name="email" value="<?php echo $user->getEmail();?>">
            </div>
            <div class="card-btn">
                <button type="submit" name="submit">Изменить данные</button>
            </div>
            <div class="card-ex"> <a href="http://localhost:81/profile" ng-click="setTab(2)">Вернутся в профиль</a></div>
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

    .card-ex{
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
