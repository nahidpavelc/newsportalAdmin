<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Journal Add </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/journal/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Journal List </a>
          </div>
        </div>
        <div class="box-body">

          <div class="row">
            <form action="<?php echo base_url("admin/journal-authors/" . $author_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">
                <br>
                <center style="margin-top: 0px;margin-bottom: 15px;">
                  <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;">Author Information</span>
                </center>
                <div class="row" style=" box-shadow: 0px 0px 10px 0px #00c0ef; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label>Author</label>
                          <select name="author_id" class="form-control inner_shadow_info select2" style="width:100%">
                            <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                            <?php foreach ($author_list as $key => $value) { ?>
                              <option value="<?php echo $value->id; ?>" <?php if ($author_info->author_id == $value->id) echo 'selected'; ?>><?php echo $value->author_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label>Contribution Level</label>
                          <select name="contribution_level" class="form-control">
                            <option value="">Select Level</option>
                            <option value="1" <?php if ($author_info->contribution_level == "1") echo 'selected'; ?>> 1 </option>
                            <option value="2" <?php if ($author_info->contribution_level == "2") echo 'selected'; ?>> 2 </option>
                            <option value="3" <?php if ($author_info->contribution_level == "3") echo 'selected'; ?>> 3 </option>
                            <option value="4" <?php if ($author_info->contribution_level == "4") echo 'selected'; ?>> 4 </option>
                            <option value="5" <?php if ($author_info->contribution_level == "5") echo 'selected'; ?>> 5 </option>
                            <option value="6" <?php if ($author_info->contribution_level == "6") echo 'selected'; ?>> 6 </option>
                            <option value="7" <?php if ($author_info->contribution_level == "7") echo 'selected'; ?>> 7 </option>
                            <option value="8" <?php if ($author_info->contribution_level == "8") echo 'selected'; ?>> 8 </option>
                            <option value="9" <?php if ($author_info->contribution_level == "9") echo 'selected'; ?>> 9 </option>
                            <option value="10" <?php if ($author_info->contribution_level == "10") echo 'selected'; ?>> 10 </option>
                            <option value="11" <?php if ($author_info->contribution_level == "11") echo 'selected'; ?>> 11 </option>
                            <option value="12" <?php if ($author_info->contribution_level == "12") echo 'selected'; ?>> 12 </option>
                            <option value="13" <?php if ($author_info->contribution_level == "13") echo 'selected'; ?>> 13 </option>
                            <option value="14" <?php if ($author_info->contribution_level == "14") echo 'selected'; ?>> 14 </option>
                            <option value="15" <?php if ($author_info->contribution_level == "15") echo 'selected'; ?>> 15 </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label>Contribution Text</label>
                          <textarea name="contribution_text" rows="3" cols="10" class="form-control inner_shadow_teal"><?= $author_info->contribution_text; ?></textarea>
                        </div>
                      </div>
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
  function readpicture(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#journals_picture_change')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#journals_picture_change1')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>