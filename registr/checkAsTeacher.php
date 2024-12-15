<?php

require_once __DIR__ . '/helpers.php';

//Получение соединения с БД


function checkTeacher(): bool|mysqli {
    $connect = getDB();
    $idTeacher = $_POST['idTeacher'];
    if (empty($idTeacher)===TRUE)
    {
    //Если поле ID преподавателя пустое, ничего не делаем и регистрируем пользователя как студента 
    }
    else
    {
        //Если поле ID преподавателя не пустое, то запрашиваем из базы данных поиск по ID преподавателя
        $getTeachers = "SELECT id, name FROM teachers WHERE id='$idTeacher'";
        $teacherList = $connect->query(query: $getTeachers);
        //Если преподаватель с таким ID найден пытаемся его зарегистрировать
        if ($teacherList->num_rows > 0) 
        {
            $status_teacher = 'true';
        } 
        else //Если преподаватель с указанным ID не найден
        {
            $status_teacher = 'false';
        }
    }
    if ($status_teacher==='false')
    {
        return false;
    }
    else 
    {
        return true;
    }
    
}




