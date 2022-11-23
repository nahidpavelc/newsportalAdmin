<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("two_edit"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/two/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("two_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">

          <div class="row">
            <form action="<?php echo base_url("admin/two/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Name *</label>
                    <input name="name" value="<?= $edit_info->name; ?>" placeholder="Name" class="form-control inner_shadow_teal" required="" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>User ID *</label>
                    <input name="user_id" value="<?= $edit_info->user_id; ?>" placeholder="User ID" class="form-control inner_shadow_teal" required="" type="number">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Phone *</label>
                    <input name="phone" value="<?= $edit_info->phone; ?>" placeholder="Phone" class="form-control inner_shadow_teal" required="" type="text">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label for="description"><?php echo $this->lang->line("description"); ?></label>
                    <textarea id="description" name="description" class="form-control">
                      <?php echo $edit_info->description; ?>
                    </textarea>
                  </div>
                </div>
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

<!-- Description -->
<script type="text/javascript">
  CKEDITOR.replace('description');
</script>