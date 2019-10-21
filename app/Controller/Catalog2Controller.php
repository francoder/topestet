<?php

class Catalog2Controller extends AppController
{

    public $layout = "inner";

    public $allow = "*";

    public $helpers = array("Display");

    public $uses = array("Page", "Post", "Region", "SpecialistService", "Service", "Specialization");

    public $paginate = array(
        "User" => array(
            "limit" => 15,
            "order" => "name"
        )
    );

    private $catalog_url = 'catalog2';

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->fastNav["/{$this->catalog_url}/"] = "Каталог специалистов";

        $this->set('catalog_url', $this->catalog_url);

        parent::seoFilter();
    }

    function index()
    {
        $specialist_conditions = array("is_specialist" => 1);

        // Список регионов
        $this->set("catalog", $this->Region->getTree());
        
        // Список специализаций
        $this->set("specializations", $this->Specialization->find("all"));

        // Список услуг
        $this->set("services", $this->Service->find("all", array("contain" => "Specialization")));

        // Список специалистов
        $this->setPaginate("specialists", $this->paginate("User", $specialist_conditions));
    }

    function all($specialization_alias = null, $service_alias = null)
    {
        $specialist_conditions = array("is_specialist" => 1);

        if (is_null($specialization_alias)) return $this->redirect("/");

        // Список регионов
        $this->set("catalog", $this->Region->getTree());
        
        // Специализации
        $specialization = $this->Specialization->findByAlias($specialization_alias);

        if (!$specialization) return $this->error_404();

        $this->set("specialization", $specialization);

        $this->fastNav["/{$this->catalog_url}/all/{$specialization['Specialization']['alias']}/"] = $specialization['Specialization']['title'];

        if (!is_null($service_alias)) { // Выбраны специализация и услуга
            // Услуга
            $service = $this->Service->find("first", array("conditions" => array("Service.alias" => $service_alias)));

            if (empty($service)) return $this->error_404();

            $this->set("service", $service);

            $this->fastNav["/{$this->catalog_url}/all/{$specialization['Specialization']['alias']}/{$service['Service']['alias']}/"] = $service['Service']['title'];
        
            $specialist_list = $this->SpecialistService->find("list", array("fields" => "user_id", "conditions" => array("service_id" => $service['Service']['id'])));

            $specialist_conditions = array("is_specialist" => 1, "id" => $specialist_list);
        } else { // Выбрана специализация
            // Список относящихся к ней услуг
            $services = $this->Service->find("all", 
                array("conditions" => array("Service.specialization_id" => $specialization['Specialization']['id']), 
                "contain" => "Specialization"));

            $this->set("services", $services);

            $services_ids = array();

            foreach ($services  as $service_info) {
                $services_ids[] = $service_info['Service']['id'];
            }

            $specialist_list = $this->SpecialistService->find("list", array("fields" => "user_id", "conditions" => array("service_id" => $services_ids)));

            $specialist_list = array_unique($specialist_list);

            $specialist_conditions = array("is_specialist" => 1, "id" => $specialist_list);
        }

        // Список специалистов
        $this->setPaginate("specialists", $this->paginate("User", $specialist_conditions));
    }

    function region($region_alias = null, $specialization_alias = null, $service_alias = null)
    {
        $specialist_conditions = array("is_specialist" => 1);

        // Выбран регион
        //   Название города
        //   Список специализаций
        $this->set("specializations", $this->Specialization->find("all"));
        //   Список услуг
        $this->set("services", $this->Service->find("all", array("contain" => "Specialization")));

        // Выбраны регион и специализация
        //   Название города
        //   Название специализации
        //   Список услуг

        // Выбраны регион, специализация и услуга
        //   Название города
        //   Название специализации
        //   Название услуги

        // Список специалистов
        $this->setPaginate("specialists", $this->paginate("User", $specialist_conditions));
    }

    function service($alias)
    {
        //???
    }
}
