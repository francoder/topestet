<?php

class Response extends AppModel
{
  var $actsAs = array('Containable');
  var $recursive = -1;

  public $validate = array(
    'content' => array(
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Заполните ответ',
      ),
    ),
  );

  public $belongsTo = array(
    'Question'   => array(
      'counterCache' => true,
    ),
    'Specialist' => array(
      'counterCache' => true,
      'className'    => 'User',
      'foreignKey'   => 'specialist_id',
    ),
  );

  function getLast($conditions = array(), $limit = 4)
  {
    return $this->find("all", array(
      "conditions" => $conditions,
      "fields"     => "*, MAX(`Response`.`created`) as m",
      "limit"      => $limit,
      "group"      => "question_id",
      "order"      => "m DESC",
      "contain"    => "Question",
    ));
  }

  public function getClinicName() {
    Debugger::dump($this);
  }
} ?>
