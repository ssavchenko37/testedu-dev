<?php
require_once '../../../kernel.php';
?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="mode" value="upload">
    <div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
    <h5 class="mt-2 mb-4"><?php _l('Импорт глав')?></h5>

    <div class="row mb-4">
        <div class="form-group form-row">
            <label for="uplfile" class="col-12 col-form-label"> <?php _l("Выбрать файл")?> </label>
            <div class="col-12">
                <input class="form-control" type="file" id="uplfile" name="uplfile">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="offset-sm-3 col-sm-9 d-flex justify-content-between">
            <button type="submit" class="btn btn-main w-50"> <?php _l('Загрузить')?> </button>
            <button class="btn btn-secondary dismiss-tsaside" type="button" aria-label="Close"> <?php _l('Отменить')?> </button>
        </div>
    </div>
</form>