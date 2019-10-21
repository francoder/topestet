<?php
App::uses('AppHelper', 'View/Helper');

class AdminHelper extends Helper
{
  function generate_line($model, $id, $element, $t)
  {
    if (isset($element['inform']) && $element['inform'] == false) return false;
    if (isset($element['type']) && $element['type'] == 'plain' && empty($t->data[$model])) {
      return false;
    }
    $line = "<tr valign='top'>";
    if ($element['type'] == "text") {
      $line .= '<td colspan="2">';
      $line .= (isset($element['title']) ? $element['title'] : $id) . ":<br>";
      $editor = "";
      if (isset($element['editor']) && $element['editor']) $editor = "js-summernote";
      if (isset($element['editor']) && $element['editor']) {
        //$line .= '<div class="editor_switcher"><a href="" class="editor selected">Редактор</a>, <a href="" class="plain">HTML</a></div>';
      }
      $line .= $t->Form->textarea($model . "." . $id, ["class" => "field $editor", "id" => 'js-summernote']);
      $line .= '</td>';
    } else {
      //$line .= '<td nowrap>'.(isset($element['title'])?$element['title']:$id).'</td>';
      if (isset($element['type']) && $element['type'] !== 'bool') {
        $line .= '<label for="nf-name">' . (isset($element['title']) ? $element['title'] : $id) . '</label>';
      }
      $line .= '<td width="100%">';
      if (isset($element['type'])) {
        $options = [];
        $options['required'] = 'no';
        if (isset($element['default'])) {
          $options['default'] = $element['default'];
        }
        switch ($element['type']) {
          case 'string':
          case 'tags':
            $line .= $t->Form->text($model . "." . $id, array_merge($options, [
              "class" => "form-control nput-xxlarge", "autocomplete" => "off",
            ]));
            break;
          case 'date':
            $line .= $t->Form->dateTime($model . "." . $id, "DMY", false, array_merge($options, [
              "class" => "form-control input-small", "autocomplete" => "off", "style" => "width:auto;",
              'minYear' => date('Y') - 15, 'maxYear' => date('Y') + 15,
            ]));
            break;
          case 'datetime':
            $line .= $t->Form->dateTime($model . "." . $id, "DMY", 24, array_merge($options, [
              "class" => "form-control field", "autocomplete" => "off", "style" => "width:auto;",
              'minYear' => date('Y') - 15, 'maxYear' => date('Y') + 15,
            ]));
            break;
          case 'integer':
            $line .= $t->Form->text($model . "." . $id, array_merge($options, [
              "class" => "form-control field", "autocomplete" => "off", "style" => "",
            ]));
            break;
          case 'image':
            $line .= '<br>';
            $line .= $t->element("admin_image", ["model" => $model, "alias" => $id]);
            $line .= '<br>';
            break;
          case 'password':
            $line .= $t->Form->password($model . "." . $id, array_merge($options, [
              "class" => "form-control field", "value" => "", "autocomplete" => "off",
            ]));
            break;
          case 'bool':
            $line .= '';
            $line .= '<label class="css-control css-control-info css-switch">';
            $line .= $t->Form->checkbox($model . "." . $id, ['class' => 'css-control-input']);
            $line .= '<span class="css-control-indicator"></span> ' . (isset($element['title']) ? $element['title'] : $id);
            $line .= '</label>';
            break;
          case 'file':
            if (!empty($t->data[$model]['url'])) {
              $line .= "<a href=\"/{$t->data[$model]['url']}\">" . basename($t->data[$model]['url']) . "</a><br>";
            }
            $line .= $t->Form->file($model . "." . $id);
            break;
          case 'list':
            $values = [];
            $var = str_replace("_id", "", $id);
            $var = "{$var}_values";
            if (isset($element['values'])) {
              $values = $element['values'];
            } else if (isset($t->viewVars[$var])) {
              $values = $t->viewVars[$var];
            }
            $options['style'] = '';
            $line .= '<br>';
            $line .= $t->Form->select($model . "." . $id, $values, $options);
            break;
          case 'plain':
            $values = [];
            $var = str_replace("_id", "", $id);
            $var = "{$var}_values";
            if (isset($element['values'])) {
              $values = $element['values'];
              $value = $element['values'][$t->data[$model][$id]];
            } else if (isset($t->viewVars[$var])) {
              $values = $t->viewVars[$var];
              $value = @$t->viewVars[$var][$t->data[$model][$id]];
            } else {
              $value = $t->data[$model][$id];
            }
            $line .= $value;
            break;
          case 'habtm':
            $var = str_replace("_id", "", $id);
            $var = "{$var}_values";
            $values = $t->viewVars[$var];
            $join_table = str_replace("_id", "", $id);
            $line .= '<a class="dashed show_habtm" href="#">Развернуть (' . count($values) . ')</a><div class="habtm_values" ><a class="dashed hide_habtm" href="#">Свернуть</a><br><table class="fields">';
            if (isset($element['fields'])) {
              $line .= '<tr><td></td><td><b>Заголовок</b></td>';
              foreach ($element['fields'] as $alias => $title) {
                $line .= "<td><b>$title</b></td>";
              }
              $line .= '</tr>';
            }
            foreach ($t->viewVars['habtms'] as $habtm) {
              if ($habtm['associationForeignKey'] == $id) {
                $m_habtm = $habtm['with'];
              }
            }
            foreach ($values as $i => $val) {
              $attributes = ['value' => $i];
              $saved_values = [];
              if (!isset($t->data[$m_habtm][$i][$id]) && isset($t->viewVars[strtolower($join_table) . "_saved_values"])) {
                foreach ($t->viewVars[strtolower($join_table) . "_saved_values"] as $s) {
                  if ($s[$m_habtm][$id] == $i) {
                    $saved_values = $s;
                    $attributes['checked'] = "checked";
                    break;
                  }
                }
              }

              $line .= '<tr><td width="0%">' . $t->Form->checkbox("$m_habtm.$i.$id", $attributes) . '</td><td nowrap>' . $t->Form->label("$m_habtm.$i.$id", "$val") . "</td>";

              if (isset($element['fields'])) {
                foreach ($element['fields'] as $alias => $title) {
                  $attributes = ['style' => 'width:250px;'];
                  if (!empty($saved_values)) {
                    $attributes['value'] = $saved_values[$m_habtm][$alias];
                  }

                  $line .= "<td>" . $t->Form->text("$m_habtm.$i.$alias", $attributes) . "</td>";
                }
                $line .= '</tr>';
              }
              $line .= '</tr>';
            }
            $line .= '</table></div>';
            break;
          case 'link':
            if (!empty($t->data)) {
              if (isset($element['template'])) {
                $link = $element['template'];
                foreach ($t->data[$model] as $key => $val) {
                  $link = str_replace("::$key::", $val, $link);
                }
              } else {
                $link = $t->data[$model][$id];
              }

              if (isset($element['caption'])) {
                $caption = $element['caption'];
              } else {
                $caption = $link;
              }

              $line .= "<a href=\"$link\">$caption</a>";
            }
            break;
          case 'text':
            $editor = "";
            $editor_id = "";
            if (isset($element['editor']) && $element['editor']) {
              $editor = "wysiwyg";
              $editor_id = 'wysiwyg' . rand(0, 10000);
            }
            $line .= $t->Form->textarea($model . "." . $id, [
              "class" => "form-control field $editor", "id" => $editor_id,
              "style" => "width:100%; height:500px;",
            ]);
            $line .= '</td>';
            break;
        }
      } else {
        $line .= $t->Form->input($model . "." . $id);
      }
      $line .= '</td>';
    }
    $line .= '</tr>';
    if (!empty($element['note'])) {
      $line .= "<tr><td></td><td class=\"NB\">" . $element['note'] . "</td></tr>";
    }

    $before = '<div class="form-group">';
    $after = '</div>';

    return $before . $line . $after;
  }
}

?>
