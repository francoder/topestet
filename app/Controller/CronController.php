<?php

class CronController extends AppController
{
  public $layout = false;
  public $allow = "*";
  public $uses = array("Review", "Service", "SpecialistService");

  function index()
  {
  }


  function afterFilter()
  {
    parent::afterFilter();
    if ($this->cronAction) {
      session_destroy();
    }
  }

  function remind()
  {
    $intervals = array_unique($this->Review->find("list", array(
      "fields"     => "remind",
      "conditions" => array("remind <>" => ""),
    )));

    $results = array();

    foreach ($intervals as $interval) {

      $reviews = $this->Review->find("all", array(
        "fields"     => "*, DATE_FORMAT(DATE_ADD(`Review`.`created`, INTERVAL +$interval), '%Y-%m-%d'), `Review`.created, curdate()",
        "conditions" => array(
          "DATE_FORMAT(DATE_ADD(`Review`.`created`, INTERVAL +$interval), '%Y-%m-%d') = CURDATE()",
          "remind <>" => "",
        ),
        "contain"    => "User",
      ));

      if ( ! empty($reviews)) {
        $results = array_merge($results, $reviews);
      }
    }

    foreach ($results as $review) {
      App::uses('CakeEmail', 'Network/Email');
      $email = new CakeEmail();
      $email->from('no-reply@'.str_replace("www.", "", $_SERVER['SERVER_NAME']));
      $email->to($review['User']['mail']);
      $email->subject("Напоминание с сайта {$_SERVER['SERVER_NAME']}");
      $email->emailFormat("html");
      $email->viewVars(array("review" => $review));
      $email->template('remind_review');
      $email->send();
      $email->reset();
    }
    exit();
  }

  function raiting_service()
  {
    $services = $this->SpecialistService->find('all', array('order' => 'SpecialistService.rate DESC'));

    foreach ($services as $service) {
      $rr = $this->Review->find('first', array(
        'fields'     => 'SUM(`note_specialist`) as s, COUNT(*) as c',
        'conditions' => array(
          'service_id'    => $service['SpecialistService']['service_id'],
          'clinic_id' => $service['SpecialistService']['user_id'],
        ),
      ));
      $r      = $rr[0]['s'];
      $nr     = $rr[0]['c'];
      $rating = 0;
      if ($nr != 0) {
        $rating = $rating + ($r / $nr) * 2;
      }
      if ($service['SpecialistService']['rate_count'] != 0) {
        $rating = $rating + $service['SpecialistService']['rate'] / $service['SpecialistService']['rate_count'];
      }
      $rating                      = $rating + $service['SpecialistService']['rating_manual'];
      $this->SpecialistService->id = $service['SpecialistService']['id'];
      $this->SpecialistService->saveField('rating', $rating);

      $user = $this->User->find('first', array(
          'conditions' => array('User.is_specialist' => 2, 'id' => $service['SpecialistService']['user_id']),
        )
      );

      if(!empty($user)) {
        $this->User->id = $user['User']['id'];

        $tmpRating = $rating;

        if($tmpRating >= 5) {
          $tmpRating = 5;
        }

        $this->User->saveField('rate', $tmpRating);
      }
      //exit();
    }
    exit();
  }

  function recalculateReviewCount($specialistId = 1)
  {
    $users = $this->User->find('all', array(
        'order'      => 'User.review_count DESC',
        'conditions' => array('User.is_specialist' => $specialistId),
      )
    );

    foreach ($users as $user) {
      $reviews = $this->Review->find('all', array(
        'fields'     => array('count(*) as cnt, Review.*'),
        'conditions' => $specialistId === 1 ? array('Review.specialist_id' => $user['User']['id']) : array('Review.clinic_id' => $user['User']['id']),
      ));

      foreach ($reviews as $review) {
        if ($review[0]['cnt'] !== $user['User']['review_count']) {
          $this->User->id = $user['User']['id'];
          $this->User->saveField('review_count', $review[0]['cnt']);
        }
      }
    }

    exit();
  }
}
