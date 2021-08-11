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

    <a  class="btn-secondary" href="<?php echo SITEURL; ?>">На главную</a>

    <h3>Страница управления списками</h3>

    <p>
      <?php
        if (isset($_SESSION['add'])) {
          echo $_SESSION['add'];
          unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
          echo $_SESSION['delete'];
          unset($_SESSION['delete']);
        }

        if (isset($_SESSION['delete_fail'])) {
          echo $_SESSION['delete_fail'];
          unset($_SESSION['delete_fail']);
        }

        if (isset($_SESSION['update'])) {
          echo $_SESSION['update'];
          unset($_SESSION['update']);
        }

       ?>
    </p>

<!--Список начинается здесь -->
        <div class="all-lists">

          <a class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Добавить список</a>
          <table class="tbl-half">
          <tr>
            <th>С.Н.</th>
            <th>Название списка</th>
            <th>Действие</th>
          </tr>

              <?php

              $conn= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

              $db_select= mysqli_select_db($conn, DB_NAME);

              $sql= "SELECT * FROM tbl_lists";

              $res= mysqli_query($conn, $sql);

              if ($res==true) {
                $count_rows= mysqli_num_rows($res);

                $sn= 1;

                if ($count_rows>0) {

                  while ($row=mysqli_fetch_assoc($res)) {
                    $list_id= $row['list_id'];
                    $list_name= $row['list_name'];
                    ?>

                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $list_name; ?></td>
                    <td>
                      <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Обновить</a>
                      <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Удалить</a>
                    </td>
                  </tr>


                    <?php
                  }

                }else {


                  ?>

                  <tr>
                    <td colspan="3">Список еще не добавлен</td>
                  </tr>

                  <?php
                }
                }

               ?>

        </table>
        </div>

<!--Список заканчивается здесь -->

</div>

  </body>
</html>
