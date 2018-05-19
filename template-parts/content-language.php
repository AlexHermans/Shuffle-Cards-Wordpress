<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/05/2018
 * Time: 15:16
 *
 * This template part generates the list of languages
 *
 */

    // TODO: later kan ik voor de languages misschien een taxonomy maken ofzo om het modulair te maken
    $arr_lang = ['en', 'de', 'fr', 'it', 'nl', 'pl'];
?>

<select name="language-selector" id="language-selector">
    <?php foreach ($arr_lang as $lang): ?>
        <?php if (isset($_COOKIE['lang']) && $lang == $_COOKIE['lang']): ?>
            <option selected value="<?= $lang ?>"><?= $lang?></option>
        <?php else: ?>
            <option value="<?= $lang ?>"><?= $lang?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>