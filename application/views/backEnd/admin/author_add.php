
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Author Add  </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/author/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Author List  </a>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <form action="<?php echo base_url("admin/author/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">   
                            <div class="col-md-8">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Author Name *</label>
                                            <input name="author_name" placeholder="Author Name " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Author Phone *</label>
                                            <input name="author_phone" placeholder="Author Phone " class="form-control inner_shadow_teal" required="" type="tel" pattern="[0]{1}[1]{1}[3|4|5|6|7|8|9]{1}[0-9]{8}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Institution Name *</label>
                                            <input name="institute_name" placeholder="Institution Name" class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Designation</label>
                                            <input name="designation" placeholder="Designation" class="form-control inner_shadow_teal"  type="text">
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>Email</label>
                                        <input name="email" placeholder="Email" class="form-control inner_shadow_teal"  type="email">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                
                                <div class="box box-teal">
                                    <div class="box-header"> <label> Author Photo </label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="authors_picture_change" class="img-responsive" src="//placehold.it/400x400" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="author_photo" onchange="readpicture(this);">
                                        </center>
                                    </div>
                                    
                                </div>
                               
                            </div>

                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

     
    </div>
</section>
<script>
  
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#authors_picture_change')
            .attr('src', e.target.result)
            .width(100)
            .height(100);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>