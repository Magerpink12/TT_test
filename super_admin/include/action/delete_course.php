<?php
include('../configuration/init.php');
function notification($type, $msg) {

    $message = '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
   <div class="alert-icon">
       <i class="far fa-fw fa-bell"></i>
   </div>
   <div class="alert-message">
       ' . $msg . '
   </div>
   </div>';

   return $message;
}

if (isset($_GET['id'])) {
    $course = Course::find_by_id($_GET['id']);
    if($course){

        // echo $course->name;

        if ($course->delete()) {
            $message=notification('warning','A Course Was Successfully Deleted!');
            $session->message($message);
            header('Location: ../../index.php?page=courses');
        }else{
            $message=notification('danger','A Course Was Not Deleted!');

            $session->message($message);
            header('Location: ../../index.php?page=courses');
        }
    }else{
        $message=notification('danger','No Course Record Founded!');
        $session->message($message);
        header('Location: ../../index.php?page=courses');
    }
}


?>