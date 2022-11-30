<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> Que Options List</h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/que_option/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line("que_option_add"); ?> </a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userListTable" class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="width: 4%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 12%;"> Question ID</th>
                <th style="width: 13%;"> Option Type</th>
                <th style="width: 12%;"> Option 1 </th>
                <th style="width: 12%;"> Option 2 </th>
                <th style="width: 12%;"> Option 3 </th>
                <th style="width: 12%;"> Option 4 </th>
                <th style="width: 13%;"> Correct Option</th>
                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($que_option_list as $value) {
              ?>
                <tr>
                  <td style="vertical-align: middle;"> <?= $sl++; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->question_id; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->option_type; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->option_1; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->option_2; ?></td>
                  <td style="vertical-align: middle;"> <?= $value->option_3; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->option_4; ?> </td>
                  <td style="vertical-align: middle;"> <?= $value->correct_option; ?> </td>

                  <td style="vertical-align: middle;">
                    <a href="<?php echo base_url('admin/que_option/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/que_option/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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