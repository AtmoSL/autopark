<?php include 'layouts/header.php';
/** @var \app\Models\User $user */
?>

    <div class="container">
        <h1>Профиль</h1>
        <table>
            <tr>
                <td>Имя: </td><td><?= $user->name ?></td>
            </tr>
            <tr>
                <td>Email: </td><td><?= $user->email ?></td>
            </tr>
        </table>
    </div>

<?php include 'layouts/footer.php' ?>