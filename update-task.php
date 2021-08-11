<?php
include('config/constants.php');

  if (isset($_GET['task_id'])) {
    $task_id= $_GET['task_id'];

    $conn= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


    $db_select= mysqli_select_db($conn, DB_NAME);

    $sql= "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

    $res= mysqli_query($conn, $sql);

    if ($res==true) {
      $row= mysqli_fetch_assoc($res);

      $task_name= $row['task_name'];
      $task_description= $row['task_description'];
      $list_id= $row['list_id'];
      $priority= $row['priority'];
      $deadline= $row['deadline'];
    }

  }else {
    header('location:'.SITEURL);
  }
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

     <a class="btn-secondary" href="<?php echo SITEURL; ?>">На главную</a>

     <h3>Страница добавления новых задач</h3>

     <?php
     if (isset($_SESSION['update_fail'])) {
       echo $_SESSION['update_fail'];
       unset($_SESSION['update_fail']);
     }

      ?>

     <form action="" method="post">
       <table class="tbl-half">
         <tr>
         <td>Название задачи: </td>
         <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required"></td>
        </tr>

        <tr>
          <td>Описание задачи: </td>
          <td><textarea name="task_description"><?php echo $task_description; ?></textarea></td>
        </tr>

        <tr>
          <td>Выбрать список: </td>
          <td>
            <select name="list_id">

              <?php
              $conn2= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


              $db_select2= mysqli_select_db($conn2, DB_NAME);

              $sql2= "SELECT * FROM tbl_lists";

              $res2= mysqli_query($conn2, $sql2);

              if ($res2==true) {
                $count_rows2= mysqli_num_rows($res2);

                if ($count_rows2>0) {
                  while ($row2=mysqli_fetch_assoc($res2)) {
                    $list_id_db= $row2['list_id'];
                    $list_name= $row2['list_name'];
                    ?>

                    <option <?php if($list_id_db==$list_id){echo "selected='selected'";} ?> value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>

                    <?php
                  }
                }else {
                  ?>
                  <option <?php if($list_id=0){echo "selected='selected'";} ?> value="0">Нет</option>
                  <?php

                }
              }

               ?>

            </select>
          </td>
        </tr>

        <tr>
          <td>Важность: </td>
          <td>
             <select name="priority">
                 <option <?php if($priority=="Высокая"){ echo "selected='selected'";} ?> value="Высокая">Высокая</option>
                 <option <?php if($priority=="Средняя"){ echo "selected='selected'";} ?>  value="Средняя">Средняя</option>
                 <option <?php if($priority=="Низкая"){ echo "selected='selected'";} ?>  value="Низкая">Низкая</option>
             </select>
          </td>
        </tr>

        <tr>
          <td>Дедлайн: </td>
          <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"></td>
        </tr>

        <tr>
          <td><input class="btn-primary btl-lg" type="submit" name="submit" value="Обновить"></td>
        </tr>

       </table>
     </form>

   </div>

   </body>

   </html>

   <?php
      if (isset($_POST['submit'])) {
        $task_name= $_POST['task_name'];
        $task_description= $_POST['task_description'];
        $list_id= $_POST['list_id'];
        $priority= $_POST['priority'];
        $deadline= $_POST['deadline'];

        $conn3= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


        $db_select3= mysqli_select_db($conn3, DB_NAME);

        $sql3= "UPDATE tbl_tasks SET
        task_name='$task_name',
        task_description='$task_description',
        list_id=$list_id,
        priority='$priority',
        deadline='$deadline'
        WHERE task_id=$task_id
        ";

        $res3=mysqli_query($conn3, $sql3);

        if ($res3==true) {
          $_SESSION['update']= "Задача обновлена успешно";

          header('location:'.SITEURL);
        }else {
          $_SESSION['update_fail']= "Ошибка при обновлении задачи";
          header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
        }
      }

    ?>
