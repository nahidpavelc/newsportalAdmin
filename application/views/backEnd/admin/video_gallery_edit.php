<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('video_gallery_edit'); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/video-gallery/list" type="submit" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('video_gallery_list'); ?> </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url("admin/video-gallery/edit/" . $video_gallery_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('video_album_id'); ?> *</label>
                      <select name="video_album_id" id="video_album_id" class="form-control select2">
                        <option value="0">Select a Video Album</option>
                        <?php foreach ($video_album_list as $key => $value) { ?>
                          <option value="<?php echo $value->id; ?>" <?php if ($video_gallery_info->video_album_id == $value->id) echo "selected"; ?>><?php echo $value->album_title; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('youtube_video_link'); ?> *</label>
                      <input type="text" id="youtube_video_link" value="<?php echo $video_gallery_info->youtube_video_link; ?>" name="youtube_video_link" required='' placeholder="<?php echo $this->lang->line('youtube_video_link'); ?>" class="form-control inner_shadow_purple">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('title'); ?> *</label>
                      <input type="text" id="title" name="title" value="<?php echo $video_gallery_info->title; ?>" required='' placeholder="<?php echo $this->lang->line('title'); ?>" class="form-control inner_shadow_purple">
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