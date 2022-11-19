<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("add_college"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/college/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("college_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">


          <div class="row">
            <form action="<?php echo base_url("admin/college/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Name *</label>
                      <input name="name" placeholder="Name" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Short Name *</label>
                      <input name="short_name" placeholder="Short Name" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Priority *</label>
                      <input name="priority" placeholder="Priority" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
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
  //Read & Show User photo
  function readphoto1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#photo_1')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>