<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('video_gallery'); ?> </h3>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <?php if (isset($video_gallery_info)) { ?>
            <div class="row">
              <div class="col-md-12">
                <form action="<?php echo base_url('admin/video-gallery/edit/' . $video_gallery_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px; margin: 18px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("video_album_id"); ?> *</label>
                          <select name="video_album_id" id="video_album_id" class="form-control select2">
                            <option value="0">Select Video Album</option>
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
                          <label for="title_one"><?php echo $this->lang->line("youtube_video_link"); ?> *</label>
                          <input name="youtube_video_link" value="<?php echo $video_gallery_info->youtube_video_link; ?>" autocomplete="off" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('youtube_video_link'); ?>" required="" type="text">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("title"); ?> *</label>
                          <input name="title" autocomplete="off" value="<?php echo $video_gallery_info->title; ?>" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('title'); ?>" required="" type="text" ">
                                                </div>
                                            </div>
                                        </div>


                                        <div class=" col-md-12">
                          <center>
                            <button type="reset" class="btn-sm btn btn-danger"> <?php echo $this->lang->line('cancel'); ?> </button>
                            <button type="submit" class="btn btn-sm bg-teal"> <?php echo $this->lang->line('update'); ?> </button>
                          </center>
                        </div>
                      </div>
                      <div class="col-md-1"></div>
                </form>
              </div>
            </div>
          <?php } else { ?>
            <div class="row">
              <div class="col-md-12" style="margin:18px ;">
                <form action="<?php echo base_url('admin/video-gallery/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("video_album_id"); ?> *</label>
                          <select name="video_album_id" id="video_album_id" class="form-control select2">
                            <option value="0">Select Video Album</option>
                            <?php foreach ($video_album_list as $key => $value) { ?>
                              <option value="<?php echo $value->id; ?>"><?php echo $value->album_title; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("youtube_video_link"); ?> *</label>
                          <input name="youtube_video_link" autocomplete="off" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('youtube_video_link'); ?>" required="" type="text">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("title"); ?> *</label>
                          <input name="title" autocomplete="off" class="form-control inner_shadow_orange" placeholder="<?php echo $this->lang->line('title'); ?>" required="" type="text">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <center>
                        <button type="reset" class="btn-sm btn btn-danger"> <?php echo $this->lang->line('reset'); ?> </button>
                        <button type="submit" class="btn btn-sm bg-teal"> <?php echo $this->lang->line('save'); ?> </button>
                      </center>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </form>
              </div>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="custom_table_box">
                <table id="userListTable" class="table table-bordered table-striped table_th_orange custom_table">
                  <thead>
                    <tr>
                      <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('album'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('title'); ?></th>
                      <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($video_gallery_list as $key => $value) {
                    ?>

                      <tr>
                        <td><?php echo $key + 1; ?></td>

                        <td><?php echo $value->album_title; ?></td>
                        <td><?php echo $value->title; ?></td>



                        <td>
                          <a href="<?= base_url('admin/video-gallery/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                          <a href="<?= base_url('admin/video-gallery/delete/' . $value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class=" box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
</section>

<script type="text/javascript">
  $(function() {
    $("#userListTable").DataTable();
  });
</script>