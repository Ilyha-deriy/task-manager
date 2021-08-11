<?php
include('config/constants.php');

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

     <p>

       <?php
          if (isset($_SESSION['add_fail'])) {
            echo $_SESSION['add_fail'];
            unset($_SESSION['add_fail']);
          }
        ?>

     </p>

     <form action="" method="post">

       <table class="tbl-half">
         <tr>
           <td>Название задачи</td>
           <td><input type="text" name="task_name" placeholder="Напишите название задачи" required="required"></td>
         </tr>

         <tr>
           <td>Описание задачи</td>
           <td><textarea name="task_description" placeholder="Напишите описание задачи"></textarea></td>
         </tr>

         <tr>
           <td>Выбрать список: </td>
           <td>
              <select name="list_id">

                <?php

                $conn= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


                $db_select= mysqli_select_db($conn, DB_NAME);

                $sql= "SELECT * FROM tbl_lists";

                $res= mysqli_query($conn, $sql);

                if ($res==true) {
                  $count_rows= mysqli_num_rows($res);

                  if ($count_rows>0) {
                    while ($row=mysqli_fetch_assoc($res)) {
                      $list_id= $row['list_id'];
                      $list_name= $row['list_name'];

                      ?>

                      <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>

                      <?php
                    }
                  } else {
                    ?>
                    <option value="0">Нет</option>
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
                  <option value="Высокая">Высокая</option>
                  <option value="Средняя">Средняя</option>
                  <option value="Низкая">Низкая</option>
              </select>
           </td>
         </tr>

         <tr>
           <td>Дедлайн: </td>
           <td><input type="date" name="deadline"></td>
         </tr>

         <tr>
           <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Сохранить"></td>
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

    $conn2= mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());


    $db_select2= mysqli_select_db($conn2, DB_NAME);

    $sql2= "INSERT INTO tbl_tasks SET
    task_name='$task_name',
    task_description='$task_description',
    list_id=$list_id,
    priority='$priority',
    deadline='$deadline'
    ";

    $res2=mysqli_query($conn2, $sql2);

    if ($res2==true) {
      $_SESSION['add']= "Задача добавлена успешно";

      header('location:'.SITEURL);
    }else {
      $_SESSION['add_fail']= "Ошибка при добавлении задач";
      header('location:'.SITEURL.'add-task.php');
    }

  }

 ?>
