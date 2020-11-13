<?php
    $DB_NAME = 'civileng';

    /* Database Host */
    $DB_HOST = 'localhost';

    /* Your Database User Name and Passowrd */
    $DB_USER = 'civileng';
    $DB_PASS = 'g0valp0';

    /* Establish the database connection */
    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $result = $mysqli->query('SELECT * FROM civilrecords');

    $rows = array();
    $table = array();
    $organized_data = array();
    
    //Layout of JSON Table
    $table['cols'] = array(
        array('label' => 'Time', 'type' => 'string'),
        array('label' => 'ImageURL', 'type' => 'string'),
        array('label' => 'Step', 'type' => 'number'),
        array('label' => 'Load', 'type' => 'number'),
        array('label' => 'Loading (lb)', 'type' => 'number'),
        array('label' => 'Displacement (in)', 'type' => 'number'),
        array('label' => 'Ext Bot', 'type' => 'number'),
        array('label' => 'Int Top', 'type' => 'number'),
        array('label' => 'Int Bot', 'type' => 'number'),
        array('label' => 'Int Shear', 'type' => 'number'),
        array('label' => 'Ext Top', 'type' => 'number')
    );

    /* Extract the information from $result */
    foreach($result as $r) {
      $temp = array();
      $raw_data_string = (string) $r['image_data']; 
      $data_array = explode(',', $raw_data_string);

      //Store Data in Array
      $organized_data = array(
            'Time' => $data_array[0],
            'ImageURL' => (string) $r['image_url'],
            'Step' => $data_array[3],
            'Load'=> $data_array[4],
            'Loading (lb)'=> $data_array[5],
            'Displacement (in)'=> $data_array[10],
            'Ext Bot'=> $data_array[14],
            'Int Top'=> $data_array[15],
            'Int Bot'=> $data_array[16],
            'Int Shear'=> $data_array[19],
            'Ext Top'=> $data_array[20]);

      $temp[] = array('v' => (string) $organized_data['Time']); 
      $temp[] = array('v' => (string) $organized_data['ImageURL']); 
      $temp[] = array('v' => (float) $organized_data['Step']); 
      $temp[] = array('v' => (float) $organized_data['Load']); 
      $temp[] = array('v' => (float) $organized_data['Loading (lb)']); 
      $temp[] = array('v' => (float) $organized_data['Displacement (in)']); 
      $temp[] = array('v' => (float) $organized_data['Ext Bot']); 
      $temp[] = array('v' => (float) $organized_data['Int Top']); 
      $temp[] = array('v' => (float) $organized_data['Int Bot']); 
      $temp[] = array('v' => (float) $organized_data['Int Shear']); 
      $temp[] = array('v' => (float) $organized_data['Ext Top']); 

      $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    // convert data into JSON format
    $jsonTable = json_encode($table);

    echo $jsonTable;
?>
