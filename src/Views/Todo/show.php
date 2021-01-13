<?php
ob_start();
?>

<section class="sectionView">
    <div id="modalDelete" class="modal">
        <div>
            <p>Voulez-vous vraiment suprimer votre liste ?</p>
            <p>Vous allez perdre toute vos tâches associées !</p>
            <div>
                <button type="button" id="btnUndoDel" name="button">Annuler</button>
                <form class="formDelete" action="/dashboard/<?php echo escape($todo->getName()); ?>/delete" method="post">
                    <input type="hidden" name="idList" value="<?php echo escape($todo->getId()); ?>">
                    <button type="submit" name="button">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

    <div class="viewList">
       <div class="top">
           <div class="enleveTodolist">
               <div class="showEdit">
                <p class="nameList"><?php echo escape($todo->getName()); ?></p>

                   <p class="hoverInfo">Edit Tache</p>
               </div>
           </div>

           <div class="afficheInput hiddenEdit">
               <form class="formEdit" action="/dashboard/<?php echo escape($todo->getName()); ?>" method="post">
                   <div class="labelInput">
                       <label for="nameTodo"><i class="fas fa-pen"></i></label>
                       <input type="text" name="nameTodo" value="<?php echo old("nameTodo") ? old("nameTodo") : escape($todo->getName());?>" placeholder="edit todo">
                   </div>
                   <button type="submit" name="button"><i class="fas fa-check"></i></button>
               </form>
               <p id="btnDeleteList"><i class="fas fa-trash"></i></p>
           </div>

           <span class="error"><?php echo error("nameTodo");?></span>
       </div>

       <div class="separateur"></div>

       <div class="bottom">

            <ul>
                <br>
                <?php
                foreach ($todo->tasks() as $key => $tasks){ ?>

                    <li style="display: flex">

                        <div class="enleveTodolist">
                            <div class="showEdit">
                                <?php if ($tasks->getCheckTask() == NULL || $tasks->getCheckTask() == 0){ ?>
                                <p class="nameList"><?= escape($tasks->getName())?></p>
                                <?php }else{ ?>
                                    <p style="text-decoration:line-through;" class="nameList"><?= escape($tasks->getName())?></p>
                                <?php } ?>

                                <p class="hoverInfo">Edit Tache</p>
                            </div>
                        </div>
                        <div class="afficheInput hiddenEdit">
                            <form class="formEdit" action="/dashboard/<?= escape($todo->getName()) ?>/task/<?= escape($tasks->getName()) ?>/update" method="post">
                                <div class="labelInput">
                                    <label for="nameTodo"><i class="fas fa-pen" aria-hidden="true"></i></label>
                                    <input type="text" name="nameTask" value="<?= escape($tasks->getName())?>" placeholder="edit todo">
                                    <input type="hidden" name="id_task" value="<?= escape($tasks->getId())?>" >
                                    <input type="hidden" name="nameTodo" value="<?= escape($todo->getName())?>" >
                                </div>
                                <button type="submit" name="button"><i class="fas fa-check" aria-hidden="true"></i></button>
                            </form>

                            <form id="deleteTask" method="post" action="/dashboard/<?= escape($todo->getName()) ?>/task/<?= escape($tasks->getName()) ?>/delete">
                                <input type="hidden" name="id_task" value="<?= escape($tasks->getId()) ?>">
                                <button type="submit" style=" border: none;background: none" class="btntaskdelete" id="btnDeleteList"><i class="fas fa-trash"></i></button>
                            </form>


                        </div>
                        <?php if ($tasks->getCheckTask() == NULL || $tasks->getCheckTask() == 0){ ?>
                        <form id="checkTask"  method="post" action="/dashboard/<?= escape($todo->getName()) ?>/task/<?= escape($tasks->getName()) ?>/check">
                            <input type="hidden" name="id_task" value="<?= escape($tasks->getId()) ?>">
                            <input type="hidden" name="nameTodo" value="<?= escape($todo->getName())?>" >
                            <button type="submit" style="color: green; border: none;background: none" class="btntaskdelete" id="btnDeleteList"><i class="fas fa-check"></i></button>
                        </form>
                            <?php }else{ ?>
                            <form id="checkTask"  method="post" action="/dashboard/<?= escape($todo->getName()) ?>/task/<?= escape($tasks->getName()) ?>/uncheck">
                                <input type="hidden" name="id_task" value="<?= escape($tasks->getId()) ?>">
                                <input type="hidden" name="nameTodo" value="<?= escape($todo->getName())?>" >
                                <button type="submit" style=" border: none;background: none" class="btntaskdelete" id="btnDeleteList"><i class="fas fa-cross"></i></button>                            <?php } ?>

                        </form>
                        &emsp;

                </li>


                    <br>
                <?php }  ?>
            </ul>



            <div class="blockForm">
                <form action="/dashboard/task/nouveau" method="post">
                    <i class="iconTask fas fa-tasks"></i>
                    <input type="text" name="nameTask" value="<?php echo old("nameTask");?>" placeholder="create task">
                    <input type="hidden" name="nameList" value="<?php echo $todo->getName(); ?>">
                    <input type="hidden" name="list_id" value="<?php echo $todo->getId(); ?>">
                    <button type="submit" name="button"><i class="fas fa-plus"></i></button>
                </form>
                <span class="error"><?php echo error("nameTask");?></span>
            </div>
       </div>
    </div>
</section>



<script>

let showEdit = document.getElementsByClassName('showEdit');

let enleveTodolist = document.getElementsByClassName('enleveTodolist');
let afficheInput = document.getElementsByClassName('afficheInput');

Array.from(showEdit).map(function(element, index) {
  element.addEventListener('click', function() {
    enleveTodolist[index].style.display = 'none';
    afficheInput[index].style.display = 'flex';
  })
})

let btnDelete = document.getElementById('btnDeleteList');
let btnUndoDel = document.getElementById('btnUndoDel');
let modalDelete = document.getElementById('modalDelete');

btnDelete.addEventListener('click', function() {
  console.log(2);
  modalDelete.style.display = 'flex';
});

btnUndoDel.addEventListener('click', function() {
  console.log(2);
  modalDelete.style.display = 'none';
});


</script>

<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
