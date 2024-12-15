<?php

require_once __DIR__ . '/helpers.php';

//Получение данных из формы регистрации
$email = $_POST['email'];
$password = $_POST['password'];
$teacher_url = "../../" . 'adminPage/Boltz_v1.0_22_June_2021/xhtml/index.html';
//$student_url = "../../" . 'userPage/remos/index.html';
//Страницы обработки ошибок
$auth_error_login = "../" . 'auth_error_login.html';
$auth_error_password = "../" . 'auth_error_password.html';

//Получение соединения с БД
$connect = getDB();

$getUser = "SELECT password, status FROM users WHERE email='$email'";
$result = $connect->query(query: $getUser);

if ($result->num_rows > 0) 
    {
        foreach($result as $row){
         
            $userPassword = $row["password"];
            $userStatus = $row["status"];
        }
        if ($userPassword===$password)
        {
            if ($userStatus==='teacher')
            {
                
                header('Location: '.$teacher_url);
            }
            else
            {
                
                header('Location: '.$student_url);
            }
        }
        else
        {
            header('Location: '.$auth_error_password);
        }
    }
    else
    {
        header('Location: '.$auth_error_login);
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



