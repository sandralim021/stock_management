<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Profile</h1>
 <!-- Generate Report -->
 <div class="card shadow mb-4">
    <div class="card-header">
        Profile Information
    </div>
    <div class="card-body">
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php elseif($this->session->flashdata('error')): ?>
        <div class="alert alert-error" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <form id="profile_form">
        <div class="form-group row justify-content-center">
            <label for="fname" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" value="<?php echo $this->session->userdata('fname')?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" value="<?php echo $this->session->userdata('lname')?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-5">
                <input type="email" class="form-control" id="email" name="email" autocomplete="off" value="<?php echo $this->session->userdata('email')?>">
            </div>
        </div>
        <hr>
        <div class="form-group row justify-content-center">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" value="<?php echo $this->session->userdata('username')?>"">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label for="password" class="col-sm-2 col-form-label">Change Password</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="password" name="password" placeholder="fill up here if you want to change your password">
            </div>
        </div>
        <div align="center">
            <button type="submit" class="btn btn-primary">Update Changes</button>
        </div>
    </form>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){
        <?php if($this->session->flashdata('success')): ?>
			$('.alert-success').fadeIn().delay(2000).fadeOut('slow');
		<?php elseif($this->session->flashdata('error')): ?>
			$('.alert-error').fadeIn().delay(2000).fadeOut('slow');
		<?php endif; ?>
        
        $('#profile_form').submit(function (e){
            e.preventDefault();
            var form = $(this).serialize();
            var id = <?php echo $this->session->userdata('user_id'); ?>

            $.ajax({
                url: '<?php echo base_url(); ?>profile/update_profile/'+id,
                data: form,
                dataType: 'json',
                type: 'post',
                success: function(response){
                    if(response.success == true){
                        location.reload();
                    }
                    else{
                        $.each(response.messages, function(index, value) {
                        var id = $("#"+index);
                        id.closest('.form-control')
                        .removeClass('is-invalid')
                        .removeClass('is-valid')
                        .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                        
                        id.after(value);

                    });
                    }
                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                }
            });
            
        });

    });
</script>