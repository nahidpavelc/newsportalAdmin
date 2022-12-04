<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("add_que_options"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/que_option/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("que_option_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url("admin/que_option/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-12">

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Question ID</label>
                      <select name="question_id" id="question_id" class="form-control select2">
                        <?php foreach($question_list as $key =>$value){?>
                          <option value="<?php echo $value->id?>"><?php echo $value->question_title?></option>
                        <?php }?>  
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("option_type"); ?></label>
                      <select name="option_type" id="" class="form-control select2" style="widows: 100%;" required="">
                        <option value=""><?php echo $this->lang->line("select"); ?></option>
                        <option value="Physics"><?php echo $this->lang->line("physics"); ?></option>
                        <option value="Bio-logy"><?php echo $this->lang->line("bio-logy"); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("correct_option"); ?></label>
                      <select name="correct_option" id="" class="form-control select2" style="widows: 100%;" required>
                        <option value=""><?php echo $this->lang->line("select"); ?></option>
                        <option value="Option 1"><?php echo $this->lang->line("option_1"); ?></option>
                        <option value="Option 2"><?php echo $this->lang->line("option_2"); ?></option>
                        <option value="Option 3"><?php echo $this->lang->line("option_3"); ?></option>
                        <option value="Option 4"><?php echo $this->lang->line("option_4"); ?></option>
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
                      <input name="option_1" placeholder="Enter Option 1" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_2") ?> </label>
                      <input name="option_2" placeholder="Enter Option 2" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_3") ?> </label>
                      <input name="option_3" placeholder="Enter Option 3" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> <?php echo $this->lang->line("option_4") ?> </label>
                      <input name="option_4" placeholder="Enter Option 4" class="form-control inner_shadow_teal" required="" type="text">
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