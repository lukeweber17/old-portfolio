<?php

function validate_fields($required_fields)
{
	$field_errors = array();
	foreach($required_fields as $fieldname)
	{
		
		if(!isset($fieldname) || (empty($fieldname)))
		{
			$field_errors[] = $fieldname;
		}
	}
	return $field_errors;
}

function validate_imagetype($imagetype)
{
	if(($imagetype== "image/gif") || ($imagetype =="image/jpeg") || ($imagetype=="image/jpg") || ($imagetype=="image/png"))
	return true;
    else
        return false;
}

function validate_filetype($filetype)
{
    if(($filetype== "application/vnd.ms-excel") || ($filetype =="text/csv") || ($filetype=="text/tsv"))
    return true;
    else
        return false;
}

function handle_upload_gallery_to_gallery($name,$pathpassed){
    $path = array();
    for ($i=0; $i <count($_FILES[$name]['tmp_name']); $i++) { 
        $logoname = $_FILES[$name]['name'][$i];
        $logoplace = $_FILES[$name]['tmp_name'][$i];
        $logotype = $_FILES[$name]['type'][$i];
        $mypath = $pathpassed.time().$logoname;
        $rpath = time().$logoname;
            // image validation begin here.
        $imagetype = validate_imagetype($logotype);
        // image validation code ends here... 
        // next is to move the image to a directory on our server.
        if ($imagetype){
            if(move_uploaded_file($logoplace,$mypath))
                $path[] = $rpath;    
        }
        else{
            return array(false,$path);
        }
    }
    return array(true,$path);
}

function handle_upload_excell_to_directory($name,$path){
            $logoname = $_FILES[$name]['name'];
            $logoplace = $_FILES[$name]['tmp_name'];
            $logosize = $_FILES[$name]['size'];
            $logotype = $_FILES[$name]['type'];
            $mypath = $path.time().$logoname;
            $rpath = time().$logoname;
            $excell_rpath=$rpath;
            // File validation begin here.
            $filetype = validate_filetype($logotype);
            // image validation code ends here... 
            // next is to move the image to a directory on our server.
            if ($filetype){
                if(move_uploaded_file($logoplace,$mypath))
                    return array(true,$rpath);
                else
                    return false;      
                }
            else
               return false;
}

function date_now(){
    $now = new DateTime();
    return $now->format('Y-m-d H:i:s');
    }

function redirect_to($location = NULL)
{
    if($location!=NULL)
    {
        header("location: {$location}");
        exit;
    }

}

function getexcel_data($imagearray,$excel_path,$excell_extention){
  $master_arraydata=array();
  $excel_filename =$excel_path;
  $path="assets/external_docs/";
  
  if($excell_extention)
  {
    $excel_file = fopen($path.$excel_filename, "r");//to open the file in read mode
    $count = 0;  
    $imgcount=0;
    $datacount=0;
    $current_data = "";
    
    //Retrieving of the record from the excell starts here                                       
   while(($excel_filesop = fgetcsv($excel_file, 0, ",")) !== false){
        $count++;
        /*if($count == 1)
            continue;*/

        //Excluding the first top 3 lines in the excell data
        if($count <= 3)
            continue;

        if(($datacount == $excel_filesop[3]))
        {
            //$current_data .= $excel_filesop[0].','.$excel_filesop[1].','.$excel_filesop[2].','.$excel_filesop[3].','.$excel_filesop[4].','.$excel_filesop[5];
            //continue;

            //Getting each of the data from each cell
            $current_data .= implode (",",$excel_filesop);
        }
        //Getting each of the data from each cell
        //$current_data = $excel_filesop[0].','.$excel_filesop[1].','.$excel_filesop[2];
        
        else
        {
            if( !($datacount < $excel_filesop[3]))
            {
                //$current_data .= $excel_filesop[0].','.$excel_filesop[1].','.$excel_filesop[2].','.$excel_filesop[3].','.$excel_filesop[4].','.$excel_filesop[5];
                
                //Getting each of the data from each cell
                $current_data .= implode (",",$excel_filesop);
            }
            
        }
        if($datacount >= $excel_filesop[3])
                $current_data .=',';

        if ($excel_filesop[3] > $datacount)
        {
            //Binding the excell data with each image
            $master_arraydata[] = array('data' => $current_data, 'image' => $imagearray[$imgcount]);
            $imgcount++;
            $datacount++;
            $current_data = "";
            //$current_data .= $excel_filesop[0].','.$excel_filesop[1].','.$excel_filesop[2].','.$excel_filesop[3].','.$excel_filesop[4].','.$excel_filesop[5];
            $current_data .= implode (",",$excel_filesop);
        }
    }
        //Binding the excell data with each image
        $master_arraydata[] = array('data' => $current_data, 'image' => $imagearray[$imgcount]);
        $temp = $datacount + 1;
        //var_dump($master_arraydata);
        fclose($excel_file);//close the excell file

return $master_arraydata;
}
else
    return false;
}

?>