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
                <th style="width: 10%;"> Exam ID</th>
                <th style="width: 55%;"> Question</th>
                <th style="width: 10%;"> Photo</th>
                <th style="width: 10%;"> Status</th>
                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>

              </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              foreach ($question_list as $value) {
              ?>
                <tr>
                  <td style="vertical-align: middle;"> <?= $sl++; ?> </td>
                  <td style="text-align:center; vertical-align:middle"> <?= $value->exam_id; ?> </td>
                  <td style=" vertical-align:middle"> <?= $value->question_title; ?> </td>
                  <td>
                    <img src="<?= base_url($value->question_photo) ?>" alt="" width="80px" height="80px">
                  </td>
                  <td style="vertical-align: middle;"> <?php if ($value->status == 1) {
                          echo '<span class="label bg-green">Publish</span>';
                        } else {
                          echo '<span class="label bg-red">Unpublish</span>';
                        } ?>
                  </td>

                  <td style="vertical-align: middle;">
                    <a href="<?php echo base_url('admin/question/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/question/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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