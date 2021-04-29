<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Registration-SMS</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-3" style="max-width: 400px;">
    <form id="reg-form" action="/reg/request" method="post">
        @csrf
        <div class="mb-3">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Клиент</label>
                <select class="form-select" aria-label="Default select example" id="name" name="type">
                    <option selected>Выберите</option>
                    <option value="1">Юр.лицо</option>
                    <option value="2">Физ.лицо</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Имя / Название</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <label for="exampleInputEmail1" class="form-label">Электронная почта</label>
            <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Номер телефона</label>
            <input type="phone" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">ИНН клиента</label>
            <input type="text" class="form-control" id="inn" name="inn">
        </div>
        <button type="submit" class="btn btn-primary" id="btn-reg">зарегестрироваться</button>
    </form>
</div>
</body>
</html>
