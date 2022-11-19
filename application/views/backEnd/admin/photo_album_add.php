<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('photo_album_add'); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/photo-album/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('photo_album_list'); ?> </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url("admin/photo-album/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('album_title'); ?> *</label>
                      <input name="album_title" placeholder="<?php echo $this->lang->line('album_title'); ?>" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_max_to_min'); ?></small>
                      <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" class="form-control inner_shadow_teal" required="" type="number">
                    </div>
                  </div>
                </div>
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