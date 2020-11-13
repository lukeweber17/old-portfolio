<?php
require_once('includes/config.php');
require_once('includes/functions_base.php');
require_once('libs/DatabaseClass.php');
$c_class = new Civil();

if(isset($_POST["submit_form_btn"])){
    if(empty($error)){
    	  if(!empty($_FILES['p_image']) && !empty($_FILES['p_excel'])){
    	  $img_path = './assets/external_images/';
    	  $data_path = './assets/external_docs/';
    	  $master_record = array();
                $img_uploadname = 'p_image';
                list($img_result,$img_uploadpath) = handle_upload_gallery_to_gallery($img_uploadname,$img_path);
                $data_uploadname = 'p_excel';
                list($data_result,$excel_uploadpath) = handle_upload_excell_to_directory($data_uploadname,$data_path);
                //Pairing each image with the  data
                $master_record = getexcel_data($img_uploadpath,$excel_uploadpath,$data_result);
                //die();
                if(($img_result) && ($data_result) && ($master_record != false)){
                    foreach ($master_record as $key => $value) {
                    	$db_img = $value['image'];
                    	$db_data = $value['data'];
                    	//sending record to database begins here
                    	$addrecordyresult = $c_class->insert_record($db_img,$db_data);
                    }

                    if($addrecordyresult['result'] !== "false")
                      $successmsg = 'Record Successfully Added.';
                    else
                        $regerror = 'Record could not be add at the moment. please try again later';
                }//ends here
                else
                    $regerror = 'Image / File could not be uploaded. Supported image type are jpg/png/gif and 
                				supported file type is csv';
            }
             else
                $regerror = 'Files Not Selected! Please select a file';
    }
    else
		$regerror = 'All Fields marked(*) are Required!!! you have ' . count($error) . ' missing Fields';
}
?>        
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Add New Record</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
               		<div class="row">
	                    <div class="col-lg-12 ">
	                    	<div class="row">
		                    <div class="col-lg-12 ">
								<br/>
								<?php require_once('components/message_section.php');?>
		                        <div class="alert alert-danger">
		                             <strong>NOTE!!!</strong><br> 1) You can Upload Multiple Images but Images should be added according to the numbered record in the Excell File.<br>
                                     2) Excell files should only be saved with the extention .csv
		                        </div>
                       
		                    </div>
		                    </div>
	                        <!-- <h5>Select Image</h5> -->
						      <form name="add_record" action="" method="post" enctype="multipart/form-data"><!-- Do Not remove the classes -->
					       		<label for="p_image[]">Select Image</lable>
					       		<input type="file" required multiple  value="Image" name="p_image[]" />
					       		<br>
					       		<label for="p_excel">Select Excel File</lable>
					       		<input type="file" required value="Excel" name="p_excel" />
					       		<br>
					        <div class="search-button-container">
					            <input class="btn btn-primary btn-lg" type="submit" name="submit_form_btn" value="Add Record" /><!-- Submit button -->
					        </div>
					    </form>
	                    </div>
                    </div>
                 <!-- /. ROW  -->           
    		</div>
             <!-- /. PAGE INNER  -->
        </div>