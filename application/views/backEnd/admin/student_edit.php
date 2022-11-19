<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Author Edit </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/author/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Author List </a>
          </div>
        </div>
        <div class="box-body">

          <div class="row">
            <form action="<?php echo base_url("admin/author/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12" style="margin-bottom: 20px;">
                <div class="col-md-6">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <label>First Name *</label>
                        <input name="first_name" value="<?= $edit_info->first_name; ?>" placeholder="First Name" class="form-control inner_shadow_teal" required="" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <label>Last Name *</label>
                        <input name="last_name" value="<?= $edit_info->last_name; ?>" placeholder="Last Name" class="form-control inner_shadow_teal" required="" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <label>Email *</label>
                        <input name="email" value="<?= $edit_info->email; ?>" placeholder="Email" class="form-control inner_shadow_teal" required="" type="email">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <label>Phone *</label>
                        <input name="phone" value="<?= $edit_info->phone; ?>" placeholder="Phone" class="form-control inner_shadow_teal" type="text" require="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <label>Address </label>
                        <input name="address" value="<?= $edit_info->address; ?>" placeholder="Address" class="form-control inner_shadow_teal" type="text">
                      </div>
                    </div>
                  </div>
                  <!-- All Images -->
                  <div class="col-md-12">
                    <div class="box box-teal">
                      <div class="box-header"> <label> Author Photo </label> </div>
                      <div class="box-body box-profile">
                        <!-- image_1-->
                        <div class="col-md-6">
                          <center>
                            <img name="photo_1" style="height:100px; width:100px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo_1"><br>
                            <small>width : 400px, Height : 400px</small>
                            <input id="photo_1" type="file" name="photo_1" onchange="readphoto1(this)">
                          </center>
                        </div>
                        <!-- image_2  -->
                        <div class="col-md-6">
                          <center>
                            <img name="photo_2" style="height:100px; width:100px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo_2"><br>
                            <small>width : 400px, Height : 400px</small>
                            <input id="photo_2" type="file" name="photo_2" onchange="readphoto2(this)">
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="box box-teal">
                      <div class="box-header"> <label> Author Photo </label> </div>
                      <div class="box-body box-profile">
                        <!-- image_3-->
                        <div class="col-md-6">
                          <center>
                            <img name="photo_3" style="height:100px; width:100px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo_3"><br>
                            <small>width : 400px, Height : 400px</small>
                            <input id="photo_3" type="file" name="photo_3" onchange="readphoto3(this)">
                          </center>
                        </div>
                        <!-- image_4  -->
                        <div class="col-md-6">
                          <center>
                            <img name="photo_4" style="height:100px; width:100px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo_4"><br>
                            <small>width : 400px, Height : 400px</small>
                            <input id="photo_4" type="file" name="photo_4" onchange="readphoto4(this)">
                          </center>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="description"><?php echo $this->lang->line("description"); ?></label>
                      <textarea id="description" name="description" class="form-control"><?php echo $edit_info->description; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-md-4">



              </div>

              <div class="col-md-12">
                <center>
                  <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                  <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                </center>
              </div>
            </form>
          </div>
        </div>
      </div>


    </div>
</section>
<!-- for Descrition  -->
<script type="text/javascript">
  CKEDITOR.replace('description');
</script>

<!-- For image fe=ield  -->
<script>
  function readpicture(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#authors_picture_change')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>