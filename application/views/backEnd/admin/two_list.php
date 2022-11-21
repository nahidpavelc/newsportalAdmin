<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> Two List </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/two/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> Add Two</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userListTable" class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 10%;"> Name</th>
                <th style="width: 10%;"> User No</th>
                <th style="width: 10%;"> Phone</th>
                <th style="width: 55%;"> Description</th>
                <!-- <th style="width: 10%;"> Photo</th> -->
                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>

              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($two_list as $value) {
              ?>
                <tr>
                  <td> <?= $sl++; ?> </td>
                  <td> <?= $value->name; ?> </td>
                  <td> <?= $value->user_id; ?> </td>
                  <td> <?= $value->phone; ?> </td>
                  <td> <?= $value->description; ?> </td>
                  <!-- <td>
                    <img src="<?= base_url($value->photo) ?>" alt="" width="50px" height="50px">
                  </td> -->
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