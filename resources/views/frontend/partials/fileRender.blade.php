<?php 
// CHAGE THE LOGIN AS PER YOUR FILE TYPE AND HANDLE MLTIPLE OR SINGLE IMAGE CASE
$class = isset($class) && $class ? $class : "";

if($file)
{
	$extension = pathinfo($file, PATHINFO_EXTENSION);

	if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG', 'GIF']))
	{
		$sizesFiles = FileSystem::getAllSizeImages($file);

		$imageSrc = isset($sizesFiles[$size]) && $sizesFiles[$size] ? $sizesFiles[$size] : "";

		if($imageSrc)
		{
			echo '<img src="'.url($imageSrc).'" class="'.$class.'">';
		}
		else
		{
			echo '<img src="'.url('frontend/noImage/no_image.png').'" class="'.$class.'">';
		}
	}
	else
	{
		echo '<img src="'.url('frontend/noImage/no_image.png').'" class="'.$class.'">';
	}
}
else
{
	echo '<img src="'.url('frontend/noImage/no_image.png').'" class="'.$class.'">';
}