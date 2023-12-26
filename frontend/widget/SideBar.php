<?php


namespace frontend\widget;


use yii\base\Widget;

class SideBar extends Widget
{
    public function run()
    {
        return $this->render('side-bar');
    }
}