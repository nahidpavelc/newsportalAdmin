<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('photo_gallery_add'); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/photo-gallery/list" type="submit" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('photo_gallery_list'); ?> </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url("admin/photo-gallery/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-9">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('photo_album_id'); ?> *</label>
                      <select name="photo_album_id" id="photo_album_id" class="form-control select2">
                        <option value="0">Select a Photo Album</option>
                        <?php foreach ($photo_album_list as $key => $value) { ?>
                          <option value="<?php echo $value->id; ?>"><?php echo $value->album_title; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('title'); ?> *</label>
                      <input type="text" id="title" name="title" required='' placeholder="<?php echo $this->lang->line('title'); ?>" class="form-control inner_shadow_purple">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-purple">
                  <div class="box-header"> <label> <?php echo $this->lang->line('photo_file'); ?> </label> </div>
                  <div class="box-body box-profile">
                    <center>
                      <img id="marketing_reports_change" class="img-responsive" src="<?php echo base_url('assets/uploads.png') ?>" alt="Lecture Sheet Photo" style="width: 80px;"><small style="color: gray">width : 400px, Height : 400px</small>
                      <br>
                      <input type="file" name="photo_file" onchange="readpicture1(this);">
                    </center>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>

              <div class="col-md-12">
                <center>
                  <button type="reset" class="btn btn-sm bg-red"><?php echo $this->lang->line('reset') ?></button>
                  <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save') ?></button>
                </center>
              </div>

            </form>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
</section>
<script>
  // profile picture change
  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#marketing_reports_change')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }

  }
</script>