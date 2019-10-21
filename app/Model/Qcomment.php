<?php

class Qcomment extends AppModel
{
    var $belongsTo = array(
        'Question' => array(
            'counterCache' => true
        ),
        'User'
    );

    public $validate = array(
        'content' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength', 1),
                'message' => 'Вы что-то хотели ответить?',
            )
        )
    );

    public $adminTitles = array(
        'single' => 'комментарий к вопросу',
        'plurial' => 'комментарии к вопросу',
        'genitive' => 'комментария к вопросу'
    );

    public $adminOrder = "Qcomment.created DESC";
}