<?php ?>
<?= import('_layouts/menus/header'); ?>

<div class="mb-4"><p><?= translate('languages_description') ?></p></div>

<form method="post" enctype="multipart/form-data" class="form-validator" action="/languages/create" exec="langUpdate">
   <div class="row">
      <div class="col-12">
          <label for="allLanguagesSelect"><?= translate('languages_pick_lang') ?></label>
          <select class="form-select" id="allLanguagesSelect" name="language_name" required onchange="loadTranslator(this.value)">
              <option hidden><?= translate('form_choose') ?></option>
              <?php if(count($currentLanguages) > 1) {
                    echo '<optgroup label="'.translate('languages_created_lang').'">';
                      foreach($allLanguages as $showLang){
                          if(in_array($showLang['file'], $currentLanguages)){
                              echo '<option value="'.$showLang['file'].'">'.$showLang['description'].'</option>';
                          }
                      }
                    echo '</optgroup>';
              }?>

              <optgroup label="<?= translate('languages_other_lang') ?>">
                  <?php foreach($allLanguages as $showLang){
                      if(!in_array($showLang['file'], $currentLanguages)){
                          echo '<option value="'.$showLang['file'].'">'.$showLang['description'].'</option>';
                      }
                  }?>
              </optgroup>
          </select>
      </div>
   </div>

    <?php
    $separator = false;
        foreach ($defaultLanguage as $key => $translate){
            $anotherText = strpos($key, "_") !== false ? explode("_", $key)[0] : $key;
            if($anotherText != $separator){
                $separator = $anotherText;
                echo '<hr class="mt-2 mb-4">';
            }
        ?>
            <div class="row mb-3">
                <div class="col-md-12 col-lg-6 mb-1">
                    <label><?= translate('languages_original') ?></label>
                    <input readonly tabindex="-1" class="form-control" aria-label="" value="<?= $translate ?>">
                </div>
                <div class="col-md-12 col-lg-6 mb-1">
                    <label><?= translate('languages_translating') ?></label>
                    <input class="form-control translate-elements" name="<?= $key ?>" aria-label=""
                           placeholder="<?= translate('languages_translate_here') ?>">
                </div>
            </div>
    <?php }?>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-check"></i> <?= translate('form_submit') ?>
        </button>
        <button class="btn btn-danger" type="button" id="deleteLangButton" hidden onclick="deleteLanguage()">
            <i class="fa-solid fa-xmark"></i> <?= translate('form_delete') ?>
        </button>
    </div>
</form>

<script src="assets/js/languages/script.js"></script>