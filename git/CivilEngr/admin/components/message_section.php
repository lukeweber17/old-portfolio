<?php 
if(isset($regerror)){
    echo '<div class="alert alert-danger">
    <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
    </button>
    <p class="text-small" align="center">' . $regerror . ' </p>
</div>';
}
if(isset($successmsg)){
    echo '<div class="alert alert-success">
    <button class="close" type="button" data-dismiss="alert"><span aria-hidden="true">&times;</span>
    </button>
    <p class="text-small" align="center">' . $successmsg . ' </p>
</div>';
}
?>