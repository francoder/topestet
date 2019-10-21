<!-- Page Content -->
<div class="content">
    <!-- Striped Table -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><?= $page_title ?></h3>


            <? if (!empty($filters)): ?>
                <? foreach ($filters as $filter): ?>
                    <h4 class="orange"><img src="/img/admin/test-pass-icon.png"> <?= $filter ?></h4>
                <? endforeach; ?>
            <? endif; ?>
            <center><?= $this->Session->flash(); ?>
                <? foreach ($schema as $i => $item) {
                    if (isset($item['inlist']) && !$item['inlist']) {
                        unset($schema[$i]);
                    }
                } ?>
                <table>
                    <tr>

                    </tr>
                </table>
            </center>


            <? if (isset($links['add'])) {
                $add_url = $links['add'];
            } else {
                $add_url = "/admin/self_item/$model/";
            } ?>
            <?
            if (!empty($params_named)) {
                foreach ($params_named as $key => $value) {
                    $params[] = "$key:$value";
                }
                $add_url = $add_url . implode("/", $params) . "/";
            } ?>
            <div class="block-options">
                <a class="dropdown-item" href="<?= $add_url ?>" data-toggle="layout">
                    <i class="si si-plus mr-5"></i> Добавить
                </a>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-striped table-vcenter">
                <thead>
                <tr>
                    <th class="text-left font-size-xss"><?= $this->Paginator->sort('id'); ?></th>
                    <?php foreach ($schema as $key => $element): ?>
                        <? if (isset($element['type']) && in_array($element['type'], [
                                "image", "file", "habtm",
                            ])) continue; ?>
                        <th class="text-left font-size-xss" style="max-width: 150px;">
                            <?php $row_title = isset($element['title_short']) ? $element['title_short'] : (isset($element['title']) ? $element['title'] : $key) ?> <?= $this->Paginator->sort($key, $row_title); ?>
                        </th>
                    <? endforeach; ?>
                    <th class="text-left font-size-xss">Действия</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($items

                as $i => $item) { ?>
                <? $item = $item[$model]; ?>
                <? if (isset($links['edit'])) {
                    $edit_link = $links['edit'] . $item['id'] . "/";
                } else {
                    $edit_link = "/admin/self_item/{$model}/{$item['id']}/";
                } ?>
                <tr class="<?= ($i % 2) ? "first" : "second" ?>">
                    <td class="text-left" scope="row"><?= $item['id'] ?></td>
                    <? foreach ($schema as $key => $element): ?>
                        <? if (isset($element['type']) && in_array($element['type'], [
                                "image", "file", "habtm",
                            ])) continue; ?>
                        <td>
                            <? $value = ""; ?>
                            <? if (isset($element['icons'])): ?>
                                <? if (isset($element['icons'][$item[$key]])): ?>
                                    <? if (!empty($element['icons'][$item[$key]])): ?>
                                        <? $title = ""; ?>
                                        <? if (isset($element['values'][$item[$key]])) {
                                            $title = $element['values'][$item[$key]];
                                        } ?>
                                        <? $value = "<img src=\"{$element['icons'][$item[$key]]}\" align=\"center\" title=\"{$title}\">" ?>
                                    <? endif ?>
                                <? else: ?>
                                    <? $value = $item[$key] ?>
                                <? endif; ?>
                            <? elseif (isset($element['values'])): ?>
                                <? $value = $element['values'][$item[$key]] ?>
                            <? elseif ($element['type'] == "link"): ?>
                                <? $value = $item[$key]; ?>
                                <? if (!empty($value)): ?>
                                    <? if (isset($element['template'])): ?>
                                        <? $link = $element['template'] ?>
                                        <? foreach ($item as $key => $val): ?>
                                            <? if (is_array($val)) continue; ?>
                                            <? $link = str_replace("::$key::", $val, $link) ?>
                                        <? endforeach; ?>
                                        <? $value = "<a href=\"$link\">$value</a>"; ?>
                                    <? else: ?>
                                        <?
                                        $caption = $value;
                                        if (!empty($element['caption'])) {
                                            $caption = $element['caption'];
                                        } ?>
                                        <? $value = "<a href=\"$value\" target=\"_blanc\">$caption</a>"; ?>
                                    <? endif; ?>
                                <? endif; ?>
                            <? elseif ($element['type'] == "list"): ?>
                                <? $values = [];
                                $var = str_replace("_id", "", $key);
                                $var = "{$var}_values";
                                if (isset($element['values'])) {
                                    $values = $element['values'];
                                } else if (isset($$var)) {
                                    $values = $$var;
                                }
                                ?>
                                <? $value = isset($values[$item[$key]]) ? mb_substr($values[$item[$key]], 0, 35, "UTF-8") . ((mb_strlen($values[$item[$key]]) > 35) ? "..." : "") : false ?>
                            <? else: ?>
                                <? if (!isset($element['show_short']) || $element['show_short'] == 'true'): ?>
                                    <? $value = $this->Display->short($item[$key], 10); ?>
                                <? else: ?>
                                    <? $value = $item[$key] ?>
                                <? endif; ?>
                            <? endif; ?>
                            <? if (isset($element['edit_link']) && $element['edit_link']): ?><a
                                    href="<?= $edit_link ?>"><? endif; ?><?= $value ?><? if (isset($element['edit_link']) && $element['edit_link']): ?></a><? endif; ?>
                        </td>
                    <? endforeach; ?>
                    <td>
                        <a href="<?= $edit_link ?>">
                            <button type="button" class="btn btn-sm btn-secondary"
                                    title="Изменить">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <a href="/admin/self_item_del/<?= $model ?>/<?= $item['id'] ?>/"
                           class="item_delete">
                            <button type="button" class="btn btn-sm btn-secondary"
                                    onclick=""
                                    title="Удалить">
                                <i class="fa fa-times"></i>
                            </button>
                        </a>
                    </td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>


            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
                <ul class="pagination">
                    <?= $this->Paginator->prev('Предыдушая'); ?>
                    <?= $this->Paginator->numbers(['modulus' => 6, 'first' => 1, 'last' => 1]); ?>
                    <?= $this->Paginator->next('Следующая'); ?>
                </ul>
            </div>
            <? $this->Paginator->options(['url' => $this->passedArgs]); ?>
        </div>
    </div>
    <!-- END Striped Table -->
</div>
