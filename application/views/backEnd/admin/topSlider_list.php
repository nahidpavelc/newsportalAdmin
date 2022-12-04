<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('slider_list')?> </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/slider/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_slider') ?></a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userListTable" class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="width: 5%;">   <?php echo $this->lang->line('sl'); ?></th>

                <th style="width: 10%;">  <?php echo $this->lang->line('photo')?> </th>
                <th style="width: 10%;">  <?php echo $this->lang->line('priority')?></th>
                <th style="width: 60%;">  <?php echo $this->lang->line('weblink')?></th>

                <th style="width: 15%;text-align: center;">  <?php echo $this->lang->line('action'); ?>  </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($slider_list as $value) {
              ?>
                <tr>
                  <td style="vertical-align: middle;"> <?= $sl++; ?> </td>

                  <td style="vertical-align: middle;">
                    <img src="<?= base_url($value->photo) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td style="vertical-align: middle;"> <?= $value->priority; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->weblink; ?> </td>

                  <td style="vertical-align: middle; text-align: center;">
                    <a href="<?php echo base_url('admin/slider/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/slider/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</section>

<script type="text/javascript">
  $(function() {
    $("#userListTable").DataTable();
  });
</script>