<?php

declare(strict_types=1);

namespace App\Repository;

class TodoCookieRepository
{
    public function get_all_todos()
    {
        if (isset($_COOKIE['todos'])) {
            return explode('~', $_COOKIE['todos']);
        }
        return [];
    }
    public function save_todo(string $todo)
    {
        $_COOKIE['todos'] = $_COOKIE['todos'] . '~' . $todo;
        setcookie('todos', $_COOKIE['todos']);
    }
    public function delete_todo(string $todo)
    {
        $skillsArray = $this->get_all_todos();
        foreach ($skillsArray as $index=>$todoForDelete) {
            if($todo === $todoForDelete) {
                array_splice($skillsArray, $index, 1);
                break;
            }
        }
        setcookie('todos', implode("~", $skillsArray));
    }
}
