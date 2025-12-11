<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

$chapter = $TS->chapter($id);
p($chapter['chapter_code']);
p('-----');
p($chapter['subject_code']);
p($chapter['chapter_semester']);
p($chapter['chapter_modul']);
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" id="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="filter_dept" value="<?php echo $_POST['filter_dept']?>">
	<input type="hidden" name="filter_subject" value="<?php echo $_POST['filter_subject']?>">
	<input type="hidden" name="filter_semester" value="<?php echo $_POST['filter_semester']?>">
	<input type="hidden" name="filter_module" value="<?php echo $_POST['filter_module']?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>
	</div>

</form>