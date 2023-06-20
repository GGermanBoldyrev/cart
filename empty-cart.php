<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>
<body>
<div class="page">
    <div class="nav">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="empty-cart.php">Корзина</a></li>
        </ul>
    </div>
    <div>
        <h1>Ваша корзина пустая</h1>
    </div>
</div>
</body>
</html>

<style>
    body {
        background-color: dimgray;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: whitesmoke;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    a:hover {
        cursor: pointer;
        text-decoration: underline;
    }

    ul {
        list-style: none;
        font-size: 28px;
        display: flex;
        justify-content: space-between;
    }

    table {
        border: 1px solid whitesmoke;
        width: 800px;
        padding: 15px;
        border-collapse:separate;
        border-spacing: 0 1.25em;
    }

    th {
        font-size: 20px;
    }

    td {
        font-size: 18px;
    }

    tr {
        text-align: center;
    }

    .page {
        display: grid;
        place-items: center;
        height: 500px;
    }

    .nav {
        width: 350px;
    }

    .quantity {
        display: flex;
        justify-content: center;
    }

    .quantity div {
        margin-left: 10px;
    }

    .quantity a:hover {
        text-decoration: none;
        color: greenyellow;
    }

</style>