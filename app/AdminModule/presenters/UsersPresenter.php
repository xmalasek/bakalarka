<?php

namespace AdminModule;

use Nette;


class UsersPresenter extends BasePresenter
{
    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    protected function createComponentInsertUserForm(){

        $form = (new InsertUserFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertUserSucceeded'];
        return $form;
    }

    public function insertUserSucceeded($form, $values)
    {
        try{
            if (strlen($values->password) == 0) {
                unset($values->password);
            } else {
                $values->password = password_hash($values->password, PASSWORD_DEFAULT);
            }
            unset($values->passwordVerify);

            $this->database->table('users')->insert([
                'email' => $values->email,
                'password' => $values->password,
                //                'role' => FIXME,
                'degree' => $values->degree,
                'name' => $values->name,
                'surname' => $values->surname
            ]);
            $this->flashMessage('Uživatel byl přidán.');
//            TODO REDIRECT
        }
        catch (Nette\Database\UniqueConstraintViolationException $ex) {
            $form->error("Email využívá jiný uživatel.");
        }
    }

    protected function createComponentEditUserForm(){

        $form = (new EditUserFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'editUserSucceeded'];
        return $form;
    }

    public function editUserSucceeded($form, $values)
    {
        if (!$this->getParameter('id')) {
            $this->error('Uživatel nenalezen');
        }

        $user = $this->database->table('users')->get($this->getParameter('id'));
        try {
            if(strlen($values->passwordVerifyOld) == 0 && strlen($values->password) > 0 ) {
                throw new \Exception("Původní heslo není vyplněno");
            }

            if(strlen($values->passwordVerifyOld) > 0 && strlen($values->password) == 0 ) {
                throw new \Exception("Nové heslo není vyplněno");
            }

            if (strlen($values->passwordVerifyOld) > 0 && strlen($values->password) > 0) {
                if (!password_verify($values->passwordVerifyOld, $user->password)) {
                    throw new \Exception('Původní heslo nesouhlasí s uloženým.');
                }
            }
            unset($values->passwordVerifyOld);

            if (strlen($values->password) == 0) {
                unset($values->password);
            }
            else {
                $values->password = password_hash($values->password, PASSWORD_DEFAULT);
            }

            $user->update($values);
            $this->flashMessage('Uživatel byl aktualizován.');
        }
        catch (Nette\Database\UniqueConstraintViolationException $ex) {
            $form->error("Email využívá jiný uživatel.");
        }
        catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }
    }

    public function renderDefault()
    {
        $this->template->users =  $this->database->table('users');
    }

    public function renderEdit($id)
    {
//        if ($this->JeEditor()) {
        //$id != $this->getUser()->getIdentity()->id

        //$this->redirect('Users:default');

    }

    public function actionEdit($id)
    {
        $user = $this->database->table('users')->get($id);
        if (!$user)
        {
            $this->error('Příspěvek nebyl nalezen');
        }

        $this['editUserForm']->setDefaults([
            'degree' => $user->degree,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
//           TODO 'role' => 1
        ]);

    }

    public function renderAdd()
    {
        //TODO role ADMIN
        //if ($this->JeAdministrator()) {
    }

    public function actionAdd()
    {
        $this['insertUserForm']->setDefaults([
//           TODO 'role' => 1
        ]);
    }

    public function handleDeleteUser($user_id){

        $this->database->table('users')->where('id', $user_id)->delete();
        $this->flashMessage('Uživatel byl úspěšně odstraněn.', 'info');


    }

}
