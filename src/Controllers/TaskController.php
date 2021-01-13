<?php

namespace Todo\Controllers;

use Todo\Models\TaskManager;
use Todo\Validator;

/** Class UserController **/
class TaskController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }



    public function create()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Task/create.php';
    }

    public function store()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTask" => ["required"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTask"], $_SESSION["user"]["id"]);

            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/" . $_POST["nameList"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/nouveau");
            }
        } else {
            header("Location: /dashboard/nouveau");
        }
    }

    public function update($slug)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTask" => ["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTodo"], $_SESSION["user"]["id"]);

            if (empty($res) || $res->getName() == $slug) {
                $search = $this->manager->update($slug);
                header("Location: /dashboard/" . $_POST['nameTodo']);
            } else {
                $_SESSION["error"]['nameTodo'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/" . $slug);
            }

        } else {
            header("Location: /dashboard/" . $slug);
        }
    }

    public function check($slug)
    {
        $this->manager->check($slug);
        header("Location: /dashboard/" . $slug);
    }

    public function uncheck($slug)
    {
        $this->manager->uncheck($slug);
        header("Location: /dashboard/" . $slug);
    }

    public function delete()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->manager->delete();
        header("Location: /dashboard");
    }

    public function show($slug,$listId)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $task = $this->manager->find($slug, $listId);
        if (!$task) {
            header("Location: /error");
        }
        require VIEWS . 'Todo/show.php';
    }

}
