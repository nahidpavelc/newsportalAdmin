<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("question_edit"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/question/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("question_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">


          <div class="row">
            <form action="<?php echo base_url("admin/question/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-8">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Exam Id</label>
                      <input name="exam_id" value="<?= $edit_info->exam_id; ?>" placeholder="Exam Id" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Question Title *</label>
                      <input name="question_title" value="<?= $edit_info->question_title; ?>" placeholder="Question Title" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="title_one"><?php echo $this->lang->line("status"); ?></label>
                      <select name="status" class="form-control">
                        <option value="1">Select</option>
                        <option value="1" <?php if ($edit_info->status == 1) echo 'selected'; ?>>Publish</option>
                        <option value="0" <?php if ($edit_info->status == 0) echo 'selected'; ?>>Unpublish</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-md-4">
                <center>
                  <img name="que_photo" style="height:150px; width:150px; margin-bottom:10px;" src="<?php echo base_url($edit_info->question_photo); ?>" id="que_photo"><br>
                  <small>width : 400px, Height : 400px</small>
                  <input id="photo1" type="file" name="question_photo" onchange="readphoto1(this)">
                </center>
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