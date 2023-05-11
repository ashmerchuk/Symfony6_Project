<?php

declare(strict_types=1);

namespace App\Repository;

class TodoFileRepository
{
    public function get_all_todos()
    {
        $file = "testfile.txt";
        if (file_exists($file) && filesize($file) !== 0) {
            $file_content = file_get_contents($file);
            return explode("\n", $file_content);
        } else {
            return [];
        }
    }
    public function save_todo(string $todo)
    {
        $file = "testfile.txt";
        if (filesize($file) === 0) {
            file_put_contents($file, $todo);
        } else {
            file_put_contents($file, file_get_contents($file) . "\n" . $todo);
        }
    }
    public function delete_todo(string $todo)
    {
        $file = "testfile.txt";
        $skillsArray = $this->get_all_todos();
        foreach ($skillsArray as $index=>$todoForDelete) {
            if($todo === $todoForDelete) {
                array_splice($skillsArray, $index, 1);
                break;
            }
        }
        file_put_contents($file, implode("\n", $skillsArray));
    }
}
