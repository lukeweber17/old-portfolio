<?php

class Civil {
    //private $db;

    protected function db_connection()
    {
            $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            return $connection;
    }

    public function insert_record($received_image,$received_data){
        //coneection to database
        $con = $this->db_connection();
        if($con)
        {
            $query = "insert into civilrecords (image_url,image_data) values ('".$received_image."','".$received_data."')";
            $result = mysqli_query($con,$query);
            $affected=mysqli_affected_rows($con);

            if($affected>=1)
            {
                $value = array('result' =>$result,'affected' =>$affected);

                // close db connection
                mysqli_close($con);
                return $value;
            }
            else
            {
                mysqli_close($con);
                return array('result' =>"false",'affected' =>$affected);
            }
        }
    }

    public function validate_admin($query){
        $con = $this->db_connection();

        if($con)
        {
            $result = mysqli_query($con,$query);
            $affected=mysqli_affected_rows($con);

            if($affected>=1)
            {
                $value= array('result' =>$result,'affected' =>$affected);

                // close db connection
                mysqli_close($con);

                return $value;
            }
            else
            {
                mysqli_close($con);
                return array('result' =>"false",'affected' =>$affected);
            }
        }
    }

}
?>