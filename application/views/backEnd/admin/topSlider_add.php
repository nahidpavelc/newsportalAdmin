<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("add_slider"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/cover_photo/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("cover_photo_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">


          <div class="row">
            <form action="<?php echo base_url("admin/slider/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-8">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("weblink") ?> * </label>
                      <input name="weblink" placeholder="Enter Weblink" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line("priority") ?> *</label>
                      <input name="priority" placeholder="Enter Priority" class="form-control inner_shadow_teal" type="num" required="">
                    </div>
                  </div>
                </div>

                <!-- <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>  *</label>
                      <select name="" id="" class="form-control select2" style="widows: 100%;">
                        <option value=""> Select value </option>
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                </div> -->

              </div>
              <div class="col-md-4">
                <center>
                  <img name="photo" style="height:150px; width:84px; margin-bottom:10px;" src="<?php echo base_url('assets/upload.png') ?>" id="photo"><br>
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
          .height(84);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>