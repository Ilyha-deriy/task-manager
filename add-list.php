<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="<?php echo SITEURL ?>css/style.css">
  </head>
  <body>

    <div class="wrapper">


    <h1>Диспетчер задач</h1>


    <a class="btn-secondary" href="<?php echo SITEURL; ?>">На главную</a>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Управлять списками</a>

    <h3>Страница добавления списка</h3>

    <p>
      <?php
        if (isset($_SESSION['add_fail'])) {
          echo $_SESSION['add_fail'];
          unset($_SESSION['add_fail']);
        }
       ?>
    </p>


    <!--Страница добавления списка начинается здесь -->
    <form class="" action="" method="post">

          <table class="tbl-half">
            <tr>
              <td>Название списка</td>
              <td><input type="text" name="list_name" placeholder="Напишите название списка" required="required"></td>
            </tr>

            <tr>
              <td>Описание списка</td>
              <td><textarea name="list_description" placeholder="Напишите описание списка"></textarea></td>
            </tr>

            <tr>
              <td><input class="btn-primary btn-lg" type="submit" name="submit" value="СОХРАНИТЬ"></td>
            </tr>
          </table>

    </form>
    <!--Страница добавления списка начинается здесь -->

  </div>

  </body>
</html>

<?php

    if (isset($_POST['submit'])) {
      //Получаем данные с form
      $list_name= $_POST['list_name'];

      $list_description= $_POST['list_description'];

      //Подключаем базу данных
      $conn= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


      $db_select= mysqli_select_db($conn, DB_NAME);

      $sql= "INSERT INTO tbl_lists SET
            list_name='$list_name',
            list_description='$list_description'
            ";

            $res= mysqli_query($conn, $sql);

            if ($res==true) {
              $_SESSION['add']= "Список добавлен успешо";

              header('location:'.SITEURL.'manage-list.php');

            }else {
              $_SESSION['add_fail']= "Ошибка при добавлении списка";

              header('location:'.SITEURL.'add-list.php');
            }
    }

 ?>
