<?php
    function getImage($ID){
        return DB("SELECT * FROM `".$Config['slider']."` WHERE `parent` = ".$ID);
    }
	function saveImage($imag)
	{
		global $FILE;
		$file=$FILE['temp'].$imag;
		if (file_exists($file))
		{
			for ($i=0; $i<count($FILE['images']); $i++)
			{
				$newfile=$FILE['path'].$FILE['images'][$i]['path'];
				if (!file_exists($newfile))
				{
					mkdir($newfile);
				}
				image_resize($file, $newfile.$imag, $FILE['images'][$i]['width'], $FILE['images'][$i]['height']);
			}
			unlink($file);
		}
	}

	function unlinkImage($imag)
	{
		global $FILE;
		if (trim($imag)!='')
		{
			for ($i=0; $i<count($FILE['images']); $i++)
			{
				$file=$FILE['path'].$FILE['images'][$i]['path'].$imag;
				if (file_exists($file))
				{
					unlink($file);
				}
			}
		}
	}
?>