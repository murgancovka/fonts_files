<?PHP
$allowedExts = array();
if (!empty($_POST)){
	for ( $i=0; $i < count($_POST['exts']); $i++ ){
		array_push($allowedExts, $_POST['exts'][$i]);
	}
	$tt=$_POST['other_exts'];
	array_push($allowedExts, $tt);
}

function get_files($dir){
	global $allowedExts;
	$files = array();
	if(is_dir($dir)){
		if($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false) {
				if(!($file == '.' || $file == '..')){
					$file = $dir.'/'.$file;
					if(is_dir($file) && $file != './.' && $file != './..'){
						$files = array_merge($files, get_files($file));
					}
					else if(is_file($file)){
						if(in_array(end(explode('.', $file)), $allowedExts)){
							$fullpath = str_replace("",$fullpath);
							$fullpath .= substr($file,2);
						
							$filename = basename($fullpath);
							$filesize = filesize($fullpath);
							$userfile_extn = substr($file, strrpos($file, '.')+1);
							$date = date("d.m.Y", filectime($fullpath));
							
							$files[] = array($fullpath, $filename, $filesize, $userfile_extn, $date);
						}
					
					}
				}
			}
		}
	}
	return $files;
}

function formatSizeUnits($bytes){
    if ($bytes >= 1073741824){
         $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576){
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
     }
    elseif ($bytes >= 1024){
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1){
         $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1){
        $bytes = $bytes . ' byte';
    }
     else{
         $bytes = 'too little!';
    }
    return $bytes;
}

function formatExtensionFiles($ext){
	$ext = "<img src='img/".$ext.".png' />";		
	return $ext;
}
		
?>

<table>
    <thead>
    	<tr>
        	<th scope="col">Full Path</th>
            <th scope="col">Name</th>
            <th scope="col">Size</th>
            <th scope="col">Extension</th>
			<th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
		<? foreach (get_files('.') as $key=>$file){ ?>
    	<tr>
        	<td><? echo $file[0]; ?></td>
            <td><a href="<? echo $file[0]; ?>"><? echo $file[1]; ?></a></td>
			<td><? echo formatSizeUnits($file[2]); ?></td>
			<td><? echo $file[3]; ?></td>
			<td><? echo $file[4]; ?></td>
		</tr>
		<? } ?>
    </tbody>
</table>