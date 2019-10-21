<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<div class="page-404">
    <div class="inner">
        <h1>К сожалению эта страница  не найдена.  </h1>
        <p>Но, у нас есть много другой полезной информации:</p>
        <ul>
            <li><a href="/reviews/">Отзывы об операциях</a></li>
            <li><a href="/catalog/clinic/">Лучшие клиники</a></li>
            <li><a href="/forum/">Вопросы и помощь</a></li>
            <li><a href="/catalog/">Ответственные врачи</a></li>
        </ul>
    </div>
</div>

<p class="error" hidden="">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s could not be found.', '<em>' . h($pluginDot . $class) . '</em>'); ?>
</p>

