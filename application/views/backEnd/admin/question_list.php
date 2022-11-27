<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> Question List</h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/question/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> Add Question</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userListTable" class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 10%;"> Name</th>
                <th style="width: 10%;"> Email</th>
                <th style="width: 10%;"> Phone</th>
                <th style="width: 10%;"> Status</th>
                <th style="width: 10%;"> Photo</th>
                <th style="width: 8%;"><?php echo $this->lang->line('action'); ?></th>

              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($one_list as $value) {
              ?>
                <tr>
                  <td> <?= $sl++; ?> </td>
                  <td> <?= $value->name; ?> </td>
                  <td> <?= $value->email; ?> </td>
                  <td> <?= $value->phone; ?> </td>
                  <td> <?php if ($value->status == 1) {
                          echo '<span class="label bg-green">Active</span>';
                        } else {
                          echo '<span class="label bg-red">Inactive</span>';
                        } ?> </td>
                  <td>
                    <img src="<?= base_url($value->photo) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td>
                    <a href="<?php echo base_url('admin/one/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/one/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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