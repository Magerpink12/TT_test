<?php
include('../configuration/init.php');
if (isset($_GET['id'])) {
    $faculty = Faculty::find_by_id($_GET['id']);
    if($faculty){
        echo $faculty->name;

        if ($faculty->delete()) {
            $message='<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>A Co-ordinator Was Successfully Deleted!
            </div>
            </div>';
            $session->message($message);
            header('Location: ../../index.php?page=faculty');
        }else{
            $message='<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>A Co-ordinator Was Successfully Deleted!
            </div>
            </div>';
            $session->message($message);
            header('Location: ../../index.php?page=faculty');
        }
    }else{
        $message='<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="alert-icon">
            <i class="far fa-fw fa-bell"></i>
        </div>
        <div class="alert-message">
            <strong>No Co-ordinator Record Founded!
        </div>
        </div>';
        $session->message($message);
        header('Location: ../../index.php?page=faculty');
    }
}


?>