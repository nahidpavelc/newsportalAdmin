<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("que_option_edit"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/que_option/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("que_option_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">


          <div class="row">
            <form action="<?php echo base_url("admin/que_option/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Question ID</label>
                      <input name="question_id" value="<?= $edit_info->question_id; ?>" placeholder="Enter Question ID" class="form-control inner_shadow_teal" required="" type="number">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("option_type"); ?></label>
                      <select name="option_type" id="" class="form-control select2" style="widows: 100%;">
                        <option value=""><?php echo $this->lang->line("select"); ?></option>
                        <option value="Physics" <?php if ($edit_info->option_type == 'Physics') echo 'selected'; ?>><?php echo $this->lang->line("physics"); ?></option>
                        <option value="Bio-logy" <?php if ($edit_info->option_type == 'Bio-logy') echo 'selected'; ?>><?php echo $this->lang->line("bio-logy"); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("correct_option"); ?></label>
                      <select name="correct_option" id="" class="form-control select2" style="widows: 100%;">
                        <option value=""><?php echo $this->lang->line("select"); ?></option>
                        <option value="Option 1" <?php if ($edit_info->correct_option == 'Option 1') echo 'selected'; ?>><?php echo $this->lang->line("option_1"); ?></option>
                        <option value="Option 2" <?php if ($edit_info->correct_option == 'Option 2') echo 'selected'; ?>><?php echo $this->lang->line("option_2"); ?></option>
                        <option value="Option 3" <?php if ($edit_info->correct_option == 'Option 3') echo 'selected'; ?>><?php echo $this->lang->line("option_3"); ?></option>
                        <option value="Option 4" <?php if ($edit_info->correct_option == 'Option 4') echo 'selected'; ?>><?php echo $this->lang->line("option_4"); ?></option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_1") ?> </label>
                      <input name="option_1" value="<?= $edit_info->option_1 ?>" placeholder="Enter Option 1" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_2") ?> </label>
                      <input name="option_2" value="<?= $edit_info->option_2 ?>" placeholder="Enter Option 2" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_3") ?> </label>
                      <input name="option_3" value="<?= $edit_info->option_3 ?>" placeholder="Enter Option 3" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_4") ?> </label>
                      <input name="option_4" value="<?= $edit_info->option_4 ?>" placeholder="Enter Option 4" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
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

<script>
  //Read & Show User photo
  function readphoto1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#que_photo')
          .attr('src', e.target.result)
          .width(150)
          .height(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>