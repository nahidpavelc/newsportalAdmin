<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line("photo_album_list"); ?></h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url("admin/photo-album/add"); ?>" class="btn bg-purple btn-sm" style="color: white; "><i class="fa fa-plus"></i> <?php echo $this->lang->line('photo_album_add') ?> </a>
          </div>
        </div>
        <div class="box-body">
          <div class="custom_table_box">
            <table id="userListTable" class="table table-bordered table-striped table_th_teal custom_table" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                  <th style="width: 15%;"><?php echo $this->lang->line('album_title'); ?></th>
                  <th style="width: 15%;"><?php echo $this->lang->line('priority'); ?></th>
                  <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>

                </tr>
              </thead>
              <tbody>
                <?php

                foreach ($photo_album_list as $key => $value) {
                ?>
                  <tr>

                    <td><?php echo ++$new_serial; ?></td>
                    <td><?php echo $value->album_title; ?></td>
                    <td><?php echo $value->priority; ?></td>


                    <td>
                      <a href="<?php echo base_url('admin/photo-album/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                      <a href="<?php echo base_url('admin/photo-album/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                    </td>

                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="col-lg-12">
              <center>
                <?php echo $links; ?>
              </center>
            </div>
          </div>
        </div>
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