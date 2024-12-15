<?php

require_once __DIR__ . '/helpers.php';

//Получение данных из формы регистрации
$name = $_POST['surname'] . ' ' . $_POST['name'] . ' ' . $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_check=$_POST['password_check'];

//Страницы-заглушки обработки ошибок
$result_posirive_url = "../" . 'regist_result.html';
$error_url = "../" . 'regist_error.html';
$error_teacherID_url = "../" . 'regist_error_teacherID.html';
$error_userID_url = "../" . 'regist_error_userID.html';

$idTeacher = $_POST['idTeacher'];

//Получение соединения с БД
$connect = getDB();
//Проверка статуса пользователя как преподавателя
if (empty($idTeacher)===TRUE)
{
   
   //Если поле ID преподавателя пустое, ничего не делаем и регистрируем пользователя как студента 
   if ($password===$password_check) 
        {
            
            //Проверяем наличие такого пользователя в базе
            $sql = "SELECT id, name, email FROM users WHERE email='$email'";
            $result = $connect->query(query: $sql);
            if ($result->num_rows > 0) 
            {
                
                header('Location: '.$error_userID_url); 
            } 
            else 
            {
                //Создаем запрос на добавление пользователя в базу
                $sql_add = "INSERT INTO users (name, email, password) VALUES 
                ('$name', '$email', '$password')";
                if ($connect -> query(query: $sql_add)===TRUE) 
                {
                    
                    header('Location: '.$result_posirive_url);
                }
                else
                {
                    
                    header('Location: '.$error_url);
                }
            }
        }
        else
        {
            echo 'Введенные пароли отличаются';
        }
}
else
{
    //Если поле ID преподавателя не пустое, то запрашиваем из базы данных поиск по ID преподавателя
    $getTeachers = "SELECT idTeacher, name FROM teachers WHERE idTeacher=$idTeacher";
    $teacherList = $connect->query(query: $getTeachers);
    //Если преподаватель с таким ID найден пытаемся его зарегистрировать
    if ($teacherList->num_rows > 0) 
    {
        //Проверяем соответствие введенных паролей
        if ($password===$password_check) 
        {
            //Создаем запрос на добавление данных
            $user_add_as_teacher = "INSERT INTO users (name, email, password, status, teacherID) VALUES 
            ('$name', '$email', '$password', 'teacher', $idTeacher)";
            //Проверяем нет ли такого преподавателя уже в базе данных
            $sql = "SELECT id, name, email, teacherID FROM users WHERE teacherID='$idTeacher'";
            $result = $connect->query(query: $sql);
            if ($result->num_rows > 0) 
            {
                
                header('Location: '.$error_teacherID_url);
            } 
            else 
            {
                if ($connect -> query(query: $user_add_as_teacher)===TRUE) 
                {
                    
                    header('Location: '.$result_posirive_url);
                }
                else
                {
                    
                    header('Location: '.$error_url);
                }
            }
        }
        else
        {
            echo 'Введенные пароли отличаются';
        }
    } 
    else //Если преподаватель с указанным ID не найден
    {
        echo 'Преподаватель с указанным ID не найден';
    }
}


//Добавление пользователя в БД

// // // echo $sql;
// // // $connect -> query(query: $sql);
// if ($password===$password_check) 
// {

//     $sql = "SELECT id, name, email FROM users WHERE email='$email'";
//     $result = $connect->query(query: $sql);
//     if ($result->num_rows > 0) 
//     {
//         echo 'Ошибка при регистрации, возможно, пользователь уже зарегистрирован';
//     } 
//     else 
//     {
//         if ($connect -> query(query: $sql_add)===TRUE) 
//         {
//            echo 'Регистрация прошла успешно';
//         }
//         else
//         {
//             echo 'При регистрации произошла ошибка';
//         }
//     }
// }
// else
// {
//     echo 'Введенные пароли отличаются';
// }



