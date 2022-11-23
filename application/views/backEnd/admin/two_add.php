<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("two_add"); ?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/two/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line("two_list"); ?> </a>
          </div>
        </div>

        <div class="box-body">

          <div class="row">
            <form action="<?php echo base_url("admin/two/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Name *</label>
                    <input name="name" placeholder="Name" class="form-control inner_shadow_teal" required="" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>User Id *</label>
                    <select name="user_id" id="user_id" class="form-control select2">
                      <option value="0">Select One</option>
                      <?php foreach($test1_list as $key =>$value) {?>
                        <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
                      <?php }?>  
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Phone </label>
                    <input name="phone" placeholder="Phone" class="form-control inner_shadow_teal" type="text">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label for="description"><?php echo $this->lang->line("description"); ?></label>
                    <textarea id="description" name="description" class="form-control"></textarea>
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

<!-- Description -->
<script type="text/javascript">
  CKEDITOR.replace('description');
</script>

<!-- <script>
  //Read & Show User photo
  function readphoto1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#photo')
          .attr('src', e.target.result)
          .width(150)
          .height(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script> -->