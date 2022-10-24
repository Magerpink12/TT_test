<?php
include('../configuration/init.php');
if (isset($_GET['id'])) {
    $department = Department::find_by_id($_GET['id']);
    if($department){

        // echo $department->name;

        if ($department->delete()) {
            $message='<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                Department Was Successfully Deleted!
            </div>
            </div>';
            $session->message($message);
            header('Location: ../../index.php?page=dept');
        }else{
            $message='<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                Department Was Not Deleted!
            </div>
            </div>';
            $session->message($message);
            header('Location: ../../index.php?page=dept');
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
        Department Record Founded!
        </div>
        </div>';
        $session->message($message);
        header('Location: ../../index.php?page=dept');
    }
}


?>