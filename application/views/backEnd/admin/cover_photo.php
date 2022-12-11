<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('cover_photo'); ?> </h3>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <?php if (isset($cover_photo_info)) { ?>
            <!-- edit info  -->
            <div class="row">
              <div class="col-md-12">
                <form action="<?php echo base_url('admin/cover_photo/edit/' . $cover_photo_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px; margin: 18px;">
                    <div class="col-md-8">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("weblink"); ?> *</label>
                          <input name="weblink" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('weblink'); ?>" type="url" value="<?php echo $cover_photo_info->weblink; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_max_to_min'); ?></small>
                          <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" value="<?php echo $cover_photo_info->priority; ?>" class="form-control inner_shadow_purple" type="number">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="box box-purple">
                        <div class="box-header"> <label> <?php echo $this->lang->line('photo_file'); ?> </label> </div>
                        <div class="box-body box-profile">
                          <center>
                            <img id="cover_photo" class="img-responsive" src="<?php if (file_exists($cover_photo_info->photo)) echo base_url($cover_photo_info->photo);
                                                                              else echo base_url('assets/upload.png') ?>" alt="Lecture Sheet Photo" style="width: 150px; Height:84px"><small style="color: gray">width : 400px, Height : 400px</small>
                            <br>
                            <input type="file" name="photo" onchange="readpicture1(this);">
                          </center>
                        </div>
                      </div>

                      <div class="col-md-12">
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
            <!-- Add info  -->
            <div class="row">
              <div class="col-md-12" style="margin:18px ;">
                <form action="<?php echo base_url('admin/cover_photo/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px;">
                    <div class="col-md-8">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("weblink"); ?></label>
                          <input name="weblink" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('weblink'); ?>" type="url">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_min_to_max'); ?></small>
                          <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" class="form-control inner_shadow_purple"  type="number">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="box box-purple">
                        <div class="box-header"> <label> <?php echo $this->lang->line('photo_file'); ?> </label> </div>
                        <div class="box-body box-profile">
                          <center>
                            <img id="cover_photo" class="img-responsive" src="<?php echo base_url('assets/upload.png') ?>" alt="Lecture Sheet Photo" style="width: 150px; Height: 84px;"><small style="color: gray">width : 400px, Height : 400px</small>
                            <br>
                            <input type="file" name="photo" onchange="readpicture1(this);">
                          </center>
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
          <!-- List info  -->
          <div class="row">
            <div class="col-sm-12">
              <div class="custom_table_box">
                <table id="userListTable" class="table table-bordered table-striped table_th_purple custom_table">
                  <thead>
                    <tr>
                      <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('cover_photo'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('weblink'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('priority'); ?></th>
                      <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sl = 1;
                    foreach ($cover_photo_list as $key => $value) {
                    ?>
                      <tr>
                        <td style="vertical-align: middle;"> <?= $sl++; ?> </td>
                        <td>
                          <img src="<?php if (file_exists($value->photo)) echo base_url($value->photo) ?>" alt="photo" style="width:90px;height:51px">
                          <!-- <img src="<php= base_url($value->photo) ?>" alt="" width="150px" height="84px"> -->
                        </td>
                        <td><?= $value->weblink; ?></td>
                        <td><?= $value->priority; ?></td>

                        <td>
                          <a href="<?= base_url('admin/cover_photo/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                          <a href="<?= base_url('admin/cover_photo/delete/' . $value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
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

<script>
  // profile picture change
  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#cover_photo')
          .attr('src', e.target.result)
          .width(150)
          .height(84);
      };

      reader.readAsDataURL(input.files[0]);
    }

  }
</script>