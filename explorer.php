<?php 
// if($_SERVER['REQUEST_URI'] === "/PHP_HW6/explorer.php") header('Location: ./index.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP_HW6</title>
</head>
<body>


    <?PHP 

    ?>

<div class="list_dir_files" style="background-color: #eded;">
        <?php $listDirFiles ?>
</div>


<div class="walk_dir" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px;">
    <form action="./"  method="post">
        <input type="hidden" name="GoUp" value="up">
        <button class="btn_Up">Up</button>
    </form>
    <form action="./"  method="post">
        <input type="hidden" name="Reset" value="default_dir">
        <button class="btn_Up">Reset</button>
    </form>
</div>
<div class="walk_dir" style="margin-bottom: 15px;" >
    <fieldset>
        <legend style="font-weight: bold;" >Создание/переименование/удаление директорий</legend>
        <div class="walk_dir_forms" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Создать директорию в текущей папке: </label>
                <input type="text" name="make_dir" placeholder="Имя папки">
                <button class="btn_create">Create</button>
            </form>
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Переименовать директорию: </label>
                <input type="text" name="rename_olddir" placeholder="Какой переменовать">
                <input type="text" name="name_newdir" placeholder="Новое имя">
                <button class="btn_alter">Rename</button>
            </form>
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Удалить директорию: </label>
                <input type="text" name="del_dir" placeholder="Что удалить">
                <button class="btn_del">Remove</button>
            </form>
        </div>  
    </fieldset>
</div>
<div class="walk_dir" style="margin-bottom: 15px;">
    <fieldset>
        <legend style="font-weight: bold;" >Создание/переименование/удаление файлов</legend>
        <div class="walk_dir_forms" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Создать файл в текущей папке: </label>
                <input type="text" name="make_file" placeholder="Имя файла с расшир.">
                <button class="btn_create">Create</button>
            </form>
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Переименовать файл: </label>
                <input type="text" name="rename_oldfile" placeholder="Какой переменовать">
                <input type="text" name="name_newfile" placeholder="Новое имя">
                <button class="btn_alter">Rename</button>
            </form>
            <form action="./"  method="post">
                <label style="margin-bottom: 5px; display: block;" for="#">Удалить файл: </label>
                <input type="text" name="del_file" placeholder="Что удалить">
                <button class="btn_del">Remove</button>
            </form>
        </div>
    </fieldset>
</div>
<div class="content_files" style="margin-bottom: 15px;">
    <fieldset>
        <legend style="font-weight: bold;" >Создание содержимого файлов</legend>
        <form action="./"  method="post">
            <label style="margin-bottom: 5px; display: block;" for="#">Выбрать файл в текущей папке: </label>
            <input type="text" name="select_file" placeholder="Имя файла с расшир.">
            <label style="margin: 5px 0; display: block;" for="#">Внести данные в файл в текущей папке: </label>
            <textarea type="text" name="make_content" placeholder="Добавить содержимое файла" cols="30" rows="10" style="margin-bottom: 5px; display: block;"><?php echo (!empty($fillFile)) ? $fillFile : "";
            ?></textarea>
            <label style="margin-bottom: 5px; display: block;" for="#">Как поступить с файлом: </label>
            <select name="select_action" style="margin-bottom: 5px; display: block;" id="#">
                <option value="0" selected></option>
                <option value="start">Переписать</option>
                <option value="add">Добавить</option>
                <option value="del">Очистить</option>
                <option value="edit">Редактировать</option>
            </select>
            <button class="btn_cont" style="margin-top: 5px;">Submit</button>
        </form>
    </fieldset>
</div>

<div class="upload_files" style="margin-bottom: 15px;">
    <fieldset>
        <legend style="font-weight: bold;" >Загрузить файлы в избранную папку в текущей директории/в текущую директорию</legend>
        <form action="./"  method="post" enctype="multipart/form-data">
            <label style="margin-bottom: 5px; display: block;" for="#">Выбрать папку в текущей директории: </label>
            <input type="text" name="select_dir" placeholder="Имя файла папки">
            <input type="file" multiple name="uploaded_files[]">
            <button class="btn_cont" style="margin-top: 5px;">Submit</button>
        </form>
    </fieldset>
</div>



</body>
</html>









