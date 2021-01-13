<?php
namespace Todo\Models;

use Todo\Models\Task;
/** Class UserManager **/
class TaskManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $list_id)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $list_id
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Todo\Models\Task");

        return $stmt->fetch();
    }

    public function store() {
        $stmt = $this->bdd->prepare("INSERT INTO Task(name, list_id) VALUES (?, ?)");
        $stmt->execute(array(
            $_POST["nameTask"],
            $_POST["list_id"],
        ));
    }

    public function update($slug) {
        $stmt = $this->bdd->prepare("UPDATE task SET name = ? WHERE id = ?");
        $stmt->execute(array(
            $_POST['nameTask'],
            $_POST['id_task']
        ));
    }

    public function check($slug) {
        $stmt = $this->bdd->prepare("UPDATE task SET checkTask = ? WHERE id = ?");
        $stmt->execute(array(
            1,
            $_POST['id_task']
        ));
    }

    public function uncheck() {
        $stmt = $this->bdd->prepare("UPDATE task SET checkTask = ? WHERE id = ?");
        $stmt->execute(array(
            NULL,
            $_POST['id_task']
        ));
    }

    public function delete() {
     //   $selected = array_keys($_POST);
       // for ($i = 0; $i < count($selected); $i++){
        $stmt = $this->bdd->prepare("DELETE FROM task WHERE id = ?");
        $stmt->execute(array(
           $_POST['id_task'],
        ));
      //  }
    }

    public function getAll(int $listId):array
    {
        $stmt = $this->bdd->prepare('SELECT * FROM Task WHERE list_id = ?');
        $stmt->execute(array(
            $listId
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Todo\Models\Task");
    }
}
