<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('manage_cubicle_names'); ?> </h3>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">

          <?php if (isset($cubicle_info)) { ?>
            <!-- Manage Edit  -->
            <div class="row">
              <div class="col-md-12">
                <form action="<?php echo base_url('admin/cubicle/edit/' . $cubicle_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px; margin: 18px;">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label for="title_one"><?php echo $this->lang->line("building_name"); ?> </label>
                          <input name="building name" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('building_name'); ?>" type="text" value="<?php echo $cubicle_info->building_name; ?>">
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_max_to_min'); ?></small>
                          <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" value="<?php echo $cubicle_info->priority; ?>" class="form-control inner_shadow_purple" type="number">
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12">
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
            <!-- Manage Add  -->
            <div class="row">
              <div class="col-md-12" style="margin:18px; ">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px;">
                    <div class="col-md-12" id="newField">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label for="title_one"><?php echo $this->lang->line("building_name"); ?>
                          </label>
                          <input name="building_name[]" id="building_name" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('building_name'); ?>" type="text">
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_min_to_max'); ?></small>
                          <input name="priority[]" id="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" class="form-control inner_shadow_purple" type="number">
                        </div>


                      </div>
                    </div>
                    <div id="addFieldTest"></div>

                    <div class="col-md-12">
                      <center>
                        <button type="reset" class="btn-sm btn btn-danger"> <?php echo $this->lang->line('reset'); ?> </button>
                        <button type="submit" class="btn btn-sm bg-teal" id="addSubmitForm"> <?php echo $this->lang->line('save'); ?> </button>

                        <span class="btn btn-sm bg-purple" onclick="add()" id="addField" class="btn btn-sm bg-purple"><i class="fa fa-plus" aria-hidden="true"></i></span>
                        <span class="btn btn-sm bg-purple" onclick="remove()" id="removeField" class="btn btn-sm bg-purple"><i class="fa fa-minus" aria-hidden="true"></i></span>

                      </center>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </form>
              </div>
            </div>
          <?php } ?>
          <!-- Manage List  -->
            <div class="row">
            <div class="col-sm-12">
              <div class="custom_table_box">
                <table id="userListTable" class="table table-bordered table-striped table_th_purple custom_table">
                  <thead>
                    <tr>
                      <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                      <th style="width: 60%;"><?php echo $this->lang->line('building_name'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('priority'); ?></th>

                      <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($cubicle_list as $key => $value) {
                    ?>
                      <tr>
                        <td><?php echo $key + 1; ?></td>

                        <td><?php echo $value->building_name; ?></td>
                        <td><?php echo $value->priority; ?></td>

                        <td>
                          <a href="<?= base_url('admin/cubicle/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                          <a href="<?= base_url('admin/cubicle/delete/' . $value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
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

<!-- profile picture change -->
<script>
  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#cubicle')
          .attr('src', e.target.result)
          .width(150)
          .height(84);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<!-- Test  -->
<script>
  $(document).ready(function() {

    $("#addField").click(function() {
      $("#addFieldTest").append(`
      
       <div class="col-md-12" id="newField">
         <div class="form-group">
           <div class="col-sm-6">
             <label for="title_one"><?php echo $this->lang->line("building_name"); ?>
             </label>
             <input name="building_name[]" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('building_name'); ?>" type="text">
             </div>
             <div class="col-sm-6">
             <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_min_to_max'); ?></small>
            <input name="priority[]" placeholder="<?php echo $this->lang->line('priority'); ?>" class="form-control inner_shadow_purple" type="number">
          </div>
        </div>
       </div>
      `);
    });
  });
</script>

<script>
  $(document).ready(function() {
    $("form").submit(function(event) {
      var formData = {
        building_name: $("#building_name").val(),
        priority: $("#priority").val(),
      };

      $.ajax({
        type: "POST",
        url: "admin/cubicle/add/",
        data: formData,
        dataType: "json",
        encode: true,
      }).done(function(data) {
        console.log(data);
      });

      event.preventDefault();
    });
  });
</script>