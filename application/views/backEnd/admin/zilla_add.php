<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('zilla_add'); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/zilla/list" type="submit" class="btn bg-orange btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('zilla_list'); ?> </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url("admin/zilla/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('division_name'); ?> *</label>
                      <select name="divission_id" id="divission_id" class="form-control select2">
                        <option value="0">Select a Division</option>
                        <?php foreach ($division_list as $key => $value) { ?>
                          <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('name_bangla'); ?> *</label>
                      <input type="text" id="name" name="name" required='' placeholder="<?php echo $this->lang->line('name'); ?>" class="form-control inner_shadow_purple">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label><?php echo $this->lang->line('name_en'); ?> *</label>
                      <input type="text" id="name_en" name="name_en" required='' placeholder="<?php echo $this->lang->line('name_en'); ?>" class="form-control inner_shadow_purple">
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