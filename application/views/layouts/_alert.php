<?php 
    $success = $this->session->flashdata('success');
    $error = $this->session->flashdata('error');
    $warning = $this->session->flashdata('warning');
    // session akan di sesuaikan di controller

    if($success){
        $alert_status = 'alert-success'; //nama class alert
        $status = 'Success!';
        $message = $success;
    }

    if($error){
        $alert_status = 'alert-danger'; //nama class alert
        $status = 'Error!';
        $message = $error;
    }

    if($warning){
        $alert_status = 'alert-warning'; //nama class alert
        $status = 'Warning!';
        $message = $warning;
    }
?>

<?php if($success || $error || $warning):?>
<!-- <?php //<?php echo $namaVariable> == <?= $namaVariable> versi lebih singkat ?> -->
<div class="row">
    <div class="col-md-12">
        <div class="alert <?= $alert_status?> alert-dismissible fade show" role="alert">
            <strong><?= $status?></strong> <?= $message?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
<?php endif ?>