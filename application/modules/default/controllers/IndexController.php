<?php

include_once 'AbstractCtrl.php';

class IndexController extends AbstractCtrl{

    public function init() {
        parent::init();
    }

    public function indexAction(){
        parent::indexAction();
        $this->viewAction();
    }

    public function viewAction(){

    }

    // ======================================= request getters ======================================================


}

