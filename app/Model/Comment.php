<?php
class Comment extends AppModel
{
    var $actsAs = array('Containable');
    var $recursive = -1;
    var $virtualFields = array(
    	'url_old' => 'IF(
    		`belongs` = "Question",
    		CONCAT("/forum/answer/", `Comment`.`belongs_id`,"/"),
    			IF (
    				`belongs` = "Review",
    				CONCAT("/service/review/", `Comment`.`belongs_id`,"/"),
    				IF (
    					`belongs` = "RegionService",
    					"err2",
    					"err1"
    				)
    			)
    	)'
    );

    public $validate = array(
        'content' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Укажите сам комментарий',
            )
        ),
        'parent_id' => array(
            'correct' => array(
                'allowEmpty' => true,
                'required' => false,
                'rule' => '_parent',
                'message' => 'Ошибка в указании комментария, на который отвечаете',
            )
        )
    );

    var $belongsTo = array(
        'Review' => array(
            'counterCache' => array(
            	'comment_count' => array(
            		'belongs' => 'Review'
            	)
            ),
            'foreignKey' => 'belongs_id',
            'fieldList' => 'subject'
        ),
        'Question' => array(
       		'counterCache' => array(
            	'comment_count' => array(
            		'belongs' => 'Question'
            	)
            ),
            'foreignKey' => 'belongs_id',
            'fieldList' => 'subject'
        ),
         'Post' => array(
       		'counterCache' => array(
            	'comment_count' => array(
            		'belongs' => 'Post'
            	)
            ),
            'foreignKey' => 'belongs_id',
            'fieldList' => 'title'
        ),
        'User' => array(
            'fieldList' => 'name'
        )
    );

    public $hasMany = array(
        'CommentChild' =>  array(
            'dependent' => true,
            'foreignKey' => 'parent_id',
            'className' => 'Comment'
        )
    );

    public $adminTitles = array(
        'single' => 'комментарий',
        'plurial' => 'Комментарии',
        'genitive' => 'комментария'
    );

    public $order = "%model%.created DESC";

    public $adminSchema = array(
        'user_id' => array(
        	'title' => 'Пользователь',
        	'type' => 'integer'
        ),
        'belongs_id' => array(
        	'title' => 'Привязка ID',
        	'type' => 'integer'
        ),
        'belongs' => array(
        	'title' => 'Привязка тип',
        	'type' => 'string'
        ),
        'url' => array(
        	'type' => 'link',
        	'title' => 'Ссылка',
        	'caption' => 'перейти>>'
        ),
         'url_old' => array(
        	'type' => 'link',
        	'title' => 'Ссылка (старая)',
        	'caption' => 'перейти>>'
        ),
		'content' => array(
			'type' => 'text',
			'title' => 'Содержание отзыва',
			'show_short' => false
		),
		'ip' => array(
			'type' => 'string',
			'title' => 'IP',
			'inform' => false
		),
        'created' => array(
            'type' => 'datetime',
            'title' => 'Отправлено',
            'inform' => false
        )
    );

    function _parent($data){
        return true;
    }

    public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        $tree = $this->generateTree(@$extra['parent_id'], $conditions, $order, $limit, $page);
        return $tree;
    }

    function generateTree($parent_id, $conditions, $order, $limit = null, $page = ""){
    	$offset = 0;
        if ($limit){
            $offset = (($page - 1) * $limit);
        }

        $conditions['Comment.parent_id'] = $parent_id;
        $result = $this->find("all", array("conditions" => $conditions, "order" => $order, "limit" => $limit, "contain" => "User", 'offset' => $offset));
        foreach ($result as $i => $item){
            $result[$i]['children'] = $this->generateTree($item['Comment']['id'], $conditions, $order);
        }
        return $result;
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        $conditions['Comment.parent_id'] = null;
        return $this->find("count", array("conditions" => $conditions));
    }

    public function afterFind($results, $primary = false){
    	parent::afterFind($results, $primary = false);
    	if ($primary){

    	} else {
    		foreach ($results as $i => $result){
    			if (!isset($result['Comment']['id']) && !isset($result['id'])) continue;
    			if (!isset($result['Comment'])){
    				$results[$i]['Parent'] = $this->getParent($result);
    			} else {
    				$results[$i]['Comment']['Parent'] = $this->getParent($result['Comment']);
    			}
    		}
    	}
    	return $results;
    }

    private function getParent($comment){
    	if ($comment['belongs'] == 'RegionService'){
    		$ids = explode('-', $comment['belongs_id']);
    		App::import('Model/Region');
    		$region = new Region;
    		App::import('Model/Service');
    		$service = new Service;
    		return array_merge(
    			$region->findById($ids[0]),
    			$service->find('first', array('conditions' => array('Service.id' => $ids[1]), 'contain' => 'Specialization'))
    		);
    	} elseif (!empty($comment['belongs'])) {
    		App::import('Model/' . $comment['belongs']);
    		$model = new $comment['belongs'];
    		return $model->findById($comment['belongs_id']);
    	}
    }
}
