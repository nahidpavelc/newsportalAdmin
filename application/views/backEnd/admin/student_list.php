<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> Author List</h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/student/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> Add Author</a>
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
                <th style="width: 10%;"> Address</th>
                <th style="width: 15%;"> Description</th>
                <th style="width: 8%;"> Photo-1</th>
                <th style="width: 8%;"> Photo-2</th>
                <th style="width: 8%;"> Photo-3</th>
                <th style="width: 8%;"> Photo-4</th>
                <th style="width: 8%;"><?php echo $this->lang->line('action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($authors_list as $value) {
              ?>
                <tr>
                  <td> <?= $sl++; ?> </td>
                  <td> <?= $value->first_name; ?><?= $value->last_name; ?> </td>
                  <td> <?= $value->email; ?> </td>
                  <td> <?= $value->phone; ?> </td>
                  <td> <?= $value->address; ?> </td>
                  <td> <?= $value->description; ?> </td>
                  <td>
                    <img src="<?= base_url($value->photo_1) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td>
                    <img src="<?= base_url($value->photo_2) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td>
                    <img src="<?= base_url($value->photo_3) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td>
                    <img src="<?= base_url($value->photo_4) ?>" alt="" width="50px" height="50px">
                  </td>
                  <td>
                    <a href="<?php echo base_url('admin/student/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/student/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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