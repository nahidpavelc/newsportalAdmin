<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line("college_list"); ?></h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url('admin/college/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add_college"); ?></a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userListTable" class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 45%;"> Name</th>
                <th style="width: 30%;"> Short Name</th>
                <th style="width: 10%;"> Priority</th>
                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($authors_list as $value) {
              ?>
                <tr>
                  <td> <?= $sl++; ?> </td>
                  <td> <?= $value->name; ?> </td>
                  <td> <?= $value->short_name; ?> </td>
                  <td> <?= $value->priority; ?> </td>
                  <td style="text-align: center;">
                    <a href="<?php echo base_url('admin/college/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/college/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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