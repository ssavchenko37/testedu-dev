<form method="post" id="frm0" name="forMain" enctype="multipart/form-data" onsubmit="return false">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1><?php _l("Преподаватели")?></h1>
            <?php if (isset($department)) { ?> <h5><?php echo $department?></h5> <?php } ?>
        </div>
        <div class="col-md-4 text-end ctrlBtn">
            <button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить преподавателя')?></button>
        </div>
    </div>
</form>

<table class="table table-striped table-hover border-secondary-subtle">
    <thead>
    <tr class="fixed-row sticky-top">
        <th class="w-5">ID</th>
        <th class="w-20"><?php _l('Преподаватель')?></th>
        <th class="w-35"><?php _l('Кафедра')?> / <?php _l('Тип')?></th>
        <th class="w-20"><?php _l('Предмет')?></th>
        <th class="w-5"><small><?php _l('Модули')?></small></th>
        <th class="w-5"><small><?php _l('Обучение')?></small></th>
        <th class="w-10 text-right">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $q = 1;
    foreach ($tutors as $r) {
        $tr_class = ($id == $r['tutor_id']) ? "table-success": "default";
        $tutor_dept = (is_array($dept[$r['tutor_id']]))
            ? tutor_meta($dept[$r['tutor_id']], "dept")
            : "<small class='text-muted'>not set yet</small>"
        ;

        $tutor_subj = (is_array($tutors_subjects[$r['tutor_id']]))
            ? tutor_meta($tutors_subjects[$r['tutor_id']], "all_subj")
            : "<small class='text-muted'>not set yet</small>"
        ;
        ?>
        <tr class="rws <?php echo $tr_class?>">
            <td class="align-middle"><small><?php echo $r['tutor_id']?></small></td>
            <td class="align-middle" title="<?php echo $r['tutor_uin']?> / <?php echo $r['tutor_email']?>">
                <?php _t($r)?>
            </td>
            <td class="align-middle">
                <?php
                if (is_array($dept[$r['tutor_id']])) {
                    foreach ($dept[$r['tutor_id']] as $d) {
                        ?>
                        <div class="ctrlBtn" data-pid="<?php echo $d['t_d_id']?>">
                            <button class="btn btn-link btn-sm text-start p-0" type="button" data-mod="dept" data-page="department">
                                <?php echo _lt([$d['dept_ru'], $d['dept_title']])?>
                            </button>
                        </div>
                        <?php
                    }
                } else { 
                    ?>
                    <div class="ctrlBtn" data-pid="<?php echo $d['t_d_id']?>">
                        <button class="btn btn-link btn-sm text-start p-0" type="button" data-mod="dept" data-page="department">
                            <small class='text-muted'>not set yet</small>
                        </button>
                    </div>
                    <?php
                }
                ?>
            </td>
            <td class="align-middle">
                <a href="/<?php echo A_ADM?>/tutor-details/?tid=<?php echo $r['tutor_id']?>"><?php echo $tutor_subj?></a>
            </td>
            <td class="align-middle"><?php echo $testing_qty[$r['tutor_id']]?></td>
            <td class="align-middle">
                <?php if( $training_qty[$r['tutor_id']] > 0 ) { ?>
                    <a href="/<?php echo A_ADM?>/training/?tid=<?php echo $r['tutor_id']?>" class="btn btn-sm btn-main"> <?php echo $training_qty[$r['tutor_id']]?> </a>
                <?php } ?>
            </td>
            <td class="align-middle text-center">
                <div class="ctrlBtn" data-pid="<?php echo $r['tutor_id']?>">
                    <button class="btn btn-success btn-sm" type="button" data-mod="edit" data-page="one"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-danger btn-sm" type="button" data-mod="delete" data-page="delete"><i class="far fa-trash-alt"></i></button>
                </div>
            </td>
        </tr>
        <?php
        $q++;
    }
    ?>
    </tbody>
</table>

<div class="offcanvas offcanvas-end viewer" tabindex="-1" id="detailsOne" aria-labelledby="detailsOneLabel">
    <div class="offcanvas-header">
        <div class="viewer__close">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body" id="offcanvas_body">
		
    </div>
</div>