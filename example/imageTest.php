<?php

include_once('../src/imageProcessor.php');


if(isset($_GET['go'])){

	$image = $_FILES['image'];
	$proc = new imageProcessor($image);
	if($_POST['crop'] !== ""){
		$proc->resampleCropSize = $_POST['crop'];
	}	

	echo'<b><u>Original Image</u></b><br>';
	echo('<b>Image selected:</b> '.$proc->imagePath);
	echo '<br><b>Image Type: </b>'.strtoupper($proc->imageType);
	echo '<br><b>Image Size: </b>'.$proc->imageSize.' bytes';
	echo '<br><b>Image resoultion: </b>'.$proc->getResolution();
	echo '<br>';
	echo'<br><b><u>Resampled Image</u></b><br>';

	if($proc->resample()){
		$path = $proc->resample();
		echo'<br><b>Resample resoultion: </b>'.$proc->resampleCropSize.'x'.$proc->resampleCropSize;
			?>
<br>
<b>Download resample: </b><a href="<?= $path ?>" download>Download</a><br>
<b>Preview:</b><br>
<img src="<?= $path ?>">

	<?php
	}else{
		echo $proc->error;
	}

?>

<br><hr>
<?php
}
?>

<form method="post" action="?go" enctype="multipart/form-data">
	<input type="file" name="image">
	<input type="text" name="crop" placeholder="resample resoultion (500)">
	<input type="submit" value="Go">
</form>