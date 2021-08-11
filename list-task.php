<?php include('config/constants.php');
      $list_id_url= $_GET['list_id'];
?>

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


        <!--Меню начинается здесь -->
        <div class="menu">

        <a href="<?php echo SITEURL; ?>">На главную</a>

        <?php
        $conn2= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


        $db_select2= mysqli_select_db($conn2, DB_NAME);

        $sql2= "SELECT * FROM tbl_lists";

        $res2= mysqli_query($conn2, $sql2);

        if ($res2==true) {
          while ($row2=mysqli_fetch_assoc($res2)) {
            $list_id= $row2['list_id'];
            $list_name= $row2['list_name'];
            ?>

              <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

            <?php
          }
        }
         ?>

        <a href="<?php echo SITEURL; ?>manage-list.php">Управлять списком</a>

      </div>
        <!--Меню заканчивается здесь -->

        <div class="all-task">
            <a class="btn-primary" href="<?php echo SITEURL; ?>add-task.php">Добавить список</a>

            <table class="tbl-full">
              <tr>
                <th>С.Н.</th>
                <th>Название задачи</th>
                <th>Важность</th>
                <th>Дедлайн</th>
                <th>Действие</th>
              </tr>

                <?php     $conn= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


                          $db_select= mysqli_select_db($conn, DB_NAME);

                          $sql="SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";

                          $res= mysqli_query($conn, $sql);

                          if ($res==true) {
                            $count_rows= mysqli_num_rows($res);

                            if ($count_rows>0) {
                              while ($row=mysqli_fetch_assoc($res)) {
                                $task_id= $row['task_id'];
                                $task_name= $row['task_name'];
                                $priority= $row['priority'];
                                $deadline= $row['deadline'];
                                ?>

                                <tr>
                                  <td>1.</td>
                                  <td><?php echo $task_name; ?></td>
                                  <td><?php echo $priority; ?></td>
                                  <td><?php echo $deadline; ?></td>
                                  <td>
                                    <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Обновить</a>
                                    <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Удалить</a>
                                  </td>
                                </tr>


                                <?php
                              }
                            }else {
                              ?>

                              <tr>
                                <td colspan="5">Нет задач в этом списке</td>
                              </tr>

                              <?php
                            }
                          }
                  ?>

            </table>
        </div>

      </div>

          </body>
        </html>
