<?
App::uses('Model', 'Model');

class AppModel extends Model
{
  var $actsAs = array('Containable');
  var $recursive = -1;
  var $city_id;
  var $images_saved = false;

  /*var $hasOne = array(
    'Show'
  );*/

  public function __construct($id = false, $table = null, $ds = null)
  {
    parent::__construct($id, $table, $ds);
    foreach ($this->virtualFields as $field => $sql) {
      $this->virtualFields[$field] = str_replace("%model%", $this->alias, $sql);
    }
    if (isset($this->order)) {
      $this->order = str_replace("%model%", $this->alias, $this->order);
    }
  }

  public function beforeFind($queryData)
  {
    parent::beforeFind($queryData);
    if (isset($this->virtualFields['is_top'])) {
      $this->virtualFields['is_top'] = str_replace('%top_response_count%', $this->configs['top_response_count'],
        $this->virtualFields['is_top']);
      $this->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
        $this->virtualFields['is_top']);
    }
    if (isset($this->Specialist)) {

      $this->Specialist->virtualFields['is_top'] = str_replace('%top_response_count%',
        $this->configs['top_response_count'], $this->Specialist->virtualFields['is_top']);

      $this->Specialist->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
        $this->Specialist->virtualFields['is_top']);
    }
    if (isset($this->Clinic)) {
      $this->Clinic->virtualFields['is_top'] = str_replace('%top_response_count%', $this->configs['top_response_count'],
        $this->Clinic->virtualFields['is_top']);
      $this->Clinic->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
        $this->Clinic->virtualFields['is_top']);
    }
    if (isset($this->Sender)) {
      $this->Sender->virtualFields['is_top'] = str_replace('%top_response_count%', $this->configs['top_response_count'],
        $this->Sender->virtualFields['is_top']);
      $this->Sender->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
        $this->Sender->virtualFields['is_top']);
    }
    if (isset($this->Parent) && isset($this->Parent->virtualFields['is_top'])) {
      $this->Parent->virtualFields['is_top'] = str_replace('%top_response_count%', $this->configs['top_response_count'],
        $this->Parent->virtualFields['is_top']);
      $this->Parent->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
        $this->Parent->virtualFields['is_top']);
    }
  }

  function getTitle($type)
  {
    if (isset($this->adminTitles[$type])) {
      $page_title = $this->adminTitles[$type];
    } else {
      $page_title = $this->name;
    }

    return $page_title;
  }

  function afterSave($created, $data = array())
  {
    //работа с изображениями
    return true;
  }

  function load_images($data = null)
  {
    if (is_null($data)) {
      $source_data = $this->data;
    } else {
      $source_data = $data;
    }
    $loaded = true;
    if (isset($this->images)) {
      foreach ($this->images as $key => $img_data) {
        if (isset($source_data[$this->name][$key]) && ! empty($source_data[$this->name][$key]['tmp_name'])) {
          $hasMany = false;
          if (isset($img_data['hasMany']) && $img_data['hasMany']) {
            $hasMany = true;
            unset($img_data['hasMany']);
          }
          $source = $source_data[$this->name][$key];
          if (empty($img_data)) {
            $img_data = array("main" => "");
          }
          $extension = pathinfo($source['name']);
          $extension = strtolower($extension['extension']);
          $extension = ($extension == "jpeg") ? "jpg" : $extension;
          $function  = "imagecreatefrom".(($extension == "jpg") ? "jpeg" : $extension);
          $img       = $function($source['tmp_name']);

          foreach ($img_data as $prefix => $info) {
            if ($prefix == "main") {
              $prefix = "";
            } else {
              $prefix = "_$prefix";
            }


            $dir = strtolower($this->name);
            if ( ! is_dir("image/$dir")) {
              mkdir("image/$dir");
              chmod("image/$dir", 0777);
            }

            if ( ! $hasMany) {
              $filename_only = $key."_".$this->id.$prefix;
              $filename      = $filename_only.".".$extension;

            } else {
              if ( ! is_dir($d = "image/$dir/{$key}_{$this->id}")) {
                mkdir($d);
                chmod($d, 0777);
              }
              $i        = 1;
              $filename = "{$key}_{$this->id}/{$key}_{$i}$prefix.".$extension;
              while (is_file("image/$dir/".$filename)) {
                $i++;
                $filename = "{$key}_{$this->id}/{$key}_{$i}$prefix.".$extension;
              }
            }

            if (isset($info['width']) || isset($info['height'])) {

              if (isset($info['width']) && ! isset($info['height'])) {
                $width         = $info['width'];
                $height        = round($width * imagesy($img) / imagesx($img));
                $width_source  = imagesx($img);
                $height_source = imagesy($img);
                $x_source      = 0;
                $y_source      = 0;
              } elseif (isset($info['width']) && isset($info['height'])) {
                $k        = $info['width'] / $info['height'];
                $k_source = imagesx($img) / imagesy($img);
                $width    = $info['width'];
                $height   = $info['height'];
                if ($k_source < $k) {
                  //обрезаем по ширине
                  $width_source  = imagesx($img);
                  $height_source = round($width_source / $k);

                  $x_source = 0;
                  $y_source = round((imagesy($img) - $height_source) / 2);
                } else {
                  //обрезаем по высоте
                  $height_source = imagesy($img);
                  $width_source  = round($height_source * $k);

                  $y_source = 0;
                  $x_source = round((imagesx($img) - $width_source) / 2);
                }
              }
              $result = imagecreatetruecolor($width, $height);
              imagecopyresampled($result, $img, 0, 0, $x_source, $y_source, $width, $height, $width_source,
                $height_source);
              $function = "image".(($extension == "jpg") ? "jpeg" : $extension);
              //$function = "imagejpeg";
              foreach (array("jpg", "png", "gif") as $ext) {
                if (is_file($f = "image/$dir/$filename_only.".$ext)) {
                  unlink($f);
                }
              }
              $loaded = $function($result, "image/$dir/$filename", ($extension == "png") ? 9 : 100);
              imagedestroy($result);
              unset($result);
            } else {
              copy($source['tmp_name'], "image/$dir/$filename");
            }
          }
        }
      }
    }

    return $loaded;
  }

  function removeImages($alias, $id)
  {
    foreach ($this->images[$alias] as $type => $img) {
      $type = ($type != "main") ? "_".$type : "";
      $mask = "image/".strtolower($this->name)."/".$alias."_".$id.$type.".*";
      (array_map("unlink", glob($mask)));
    }

    return true;
  }

  function getIdByTitle($title)
  {
    $this->id = null;
    $id       = $this->findByTitle($title);
    if ( ! empty($id)) {
      return $id[$this->name]['id'];
    } else {
      $this->save(array($this->name => array("title" => $title)));

      return $this->id;
    }
  }

  function saveListFromStr($string, $main_id, $sub_model, $main_field, $sub_field)
  {
    if (empty($string)) {
      return true;
    }
    $items = explode(",", $string);
    foreach ($items as $item) {
      $item = preg_replace("/ {2,}/i", "", trim($item));
      if (empty($item)) {
        continue;
      }
      $item_id = $this->{$sub_model}->getIdByTitle($item);
      $cnt     = $this->find("count", array("conditions" => array($sub_field => $item_id, $main_field => $main_id)));
      if ($cnt == 0) {
        $this->id = null;
        $this->save(array($this->name => array($sub_field => $item_id, $main_field => $main_id)));
      }
    }

    return true;
  }

  function beforeSave($data = array())
  {
    if ( ! empty($this->data[$this->name]['id'])) {
      $this->load_images();
      $this->images_saved = true;
    }
    foreach ($this->_schema as $key => $value) {
      if ($value['type'] == 'date' && isset($this->data[$this->name][$key]) && ($this->data[$this->name][$key] == "" || $this->data[$this->name][$key] == "0000-00-00")) {
        $this->data[$this->name][$key] = null;
      }
      if ($value['type'] == 'datetime' && isset($this->data[$this->name][$key]) && ($this->data[$this->name][$key] == "" || $this->data[$this->name][$key] == "0000-00-00 00:00:00")) {
        $this->data[$this->name][$key] = null;
      }
    }
    if (isset($this->adminSchema)) {
      foreach ($this->adminSchema as $field => $item) {
        if (isset($item['type']) && $item['type'] == "file" && ! empty($this->data['Document'][$field]['tmp_name'])) {
          $this->data['Document']['type'] = $this->data['Document'][$field]['type'];
          $this->data['Document']['size'] = $this->data['Document'][$field]['size'];
          if ( ! is_dir($dir = "files/".strtolower($this->name))) {
            mkdir($dir, 0777);
          }
          $fname = $this->data['Document'][$field]['name'];
          $i     = 1;
          while (file_exists($dir."/".$fname)) {
            $path  = pathinfo($this->data['Document'][$field]['name']);
            $fname = $path['filename']."_".$i.".".$path['extension'];
            $i++;
          }
          copy($this->data['Document'][$field]['tmp_name'], $dir."/".$fname);
          $this->data['Document']['url'] = $dir."/".$fname;
        }
      }
    }

    //сохраняем IP если нада
    if (isset($this->_schema['ip'])) {
     $this->data[$this->name]['ip'] = $_SERVER['REMOTE_ADDR'];
    }

    return true;
  }

  function save($data = null, $validate = true, $fildList = array())
  {
    $this->images_saved = false;
    if (isset($data['Language'])) {
      $this->locale = $this->languages[0];
      if (parent::save($data, $validate, $fildList)) {
        foreach ($data['Language'] as $lang => $translated) {
          if (in_array($lang, $this->languages)) {
            $this->locale            = $lang;
            $data[$this->name]['id'] = $this->id;
            $data[$this->name]       = array_merge($data[$this->name], $translated);
            parent::save($data, $validate, $fildList);
          }
        }
        if ( ! $this->images_saved) {
          $this->load_images();
        }

        return true;
      }
    } else {
      $save = parent::save($data, $validate, $fildList);
      if ($save) {
        if ( ! $this->images_saved) {
          $this->load_images($data);
        }
      }

      return $save;
    }
  }

  function afterFind($data, $primary = false)
  {
    if ( ! $primary && isset($this->actsAs['Translate']) && ! empty($this->actsAs['Translate'])) {
      $result = array();
      foreach ($data as $i => $record) {
        $model  = key($record);
        $fields = array_keys($record[$model]);
        $id     = $record[$model]['id'];
        $line   = $this->find("first", array("conditions" => array("$model.id" => $id), "fields" => $fields));
        if ( ! empty($line)) {
          $data[$i] = $line;
        } else {
          $data[$i][$model] = array();
        }
      }
    }

    return $data;
  }
}

?>