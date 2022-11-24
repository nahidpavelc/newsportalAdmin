<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("one_add"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/one/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("one_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">


          <div class="row">
            <form action="<?php echo base_url("admin/one/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-8">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Name *</label>
                      <input name="name" placeholder="Name" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Email *</label>
                      <input name="email" placeholder="Email" class="form-control inner_shadow_teal" required="" type="email">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Phone *</label>
                      <input name="phone" placeholder="Phone" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("status"); ?></label>
                      <select name="status" id="" class="form-control select2" style="widows: 100%;">
                        <option value="1"><?php echo $this->lang->line("active"); ?></option>
                        <option value="0"><?php echo $this->lang->line("inactive"); ?></option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-md-4">
                <center>
                  <img name="photo" style="height:150px; width:150px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo"><br>
                  <small>width : 400px, Height : 400px</small>
                  <input id="photo" type="file" name="photo" onchange="readphoto1(this)">
                </center>
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
  //Read & Show User photo
  function readphoto1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#photo')
          .attr('src', e.target.result)
          .width(150)
          .height(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>