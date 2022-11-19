<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-teal box-solid">
        <div class="box-header">
          <h3 class="box-title">Journal List</h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url("admin/journal/add"); ?>" class="btn btn-sm bg-red" style="color: white; "><i class="fa fa-plus"></i> Add Journal </a>
          </div>
        </div>

        <div class="row" style="box-shadow: 0px 0px 10px 0px teal; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
          <form action="<?php echo base_url('admin/journal/list') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Published Date</label>
                    <input type="text" name="published_date" placeholder="Published Date" class="form-control inner_shadow_teal date" autocomplete="off" value="<?php if ($search['published_date']) echo date("d-M-Y", strtotime($search['published_date'])); ?>">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Title </label>
                    <input type="text" name="title" placeholder="Title of Journal" class="form-control inner_shadow_teal" value="<?= $search['title']; ?>">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Author</label>
                    <select name="author_id" class="form-control select2">
                      <option value="">Select Author</option>
                      <?php foreach ($author_list as $authors) { ?>
                        <option value="<?= $authors->id; ?>" <?php if ($search['author_id'] == $authors->id) echo 'selected'; ?>><?= $authors->author_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-sm btn bg-purple">Search</button>
              </center>
            </div>
          </form>

        </div>

        <div class="box-body">


          <table class="table table-bordered table-striped table_th_teal">
            <thead>
              <tr>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;"><?php echo $this->lang->line("sl"); ?> </th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;">Publish Date </th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 35%;">Title</th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;">Journal Volume</th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 15%;">Published Organization</th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;">Status</th>
                <th style="background: #85c2c1; border: 1px solid #85c2c1; width: 10%;"><?php echo $this->lang->line("action"); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sl = $new_sl + 1;
              foreach ($journals_list as $value) {
              ?>
                <tr>
                  <td><?php echo $sl++; ?></td>
                  <td><?php echo date('d M, Y', strtotime($value->published_date)); ?></td>
                  <td><?php echo $value->title; ?></td>
                  <td><?php echo $value->journal_volume; ?></td>
                  <td><?php echo $value->published_organization; ?></td>
                  <td>
                    <?php if ($value->public_private == 1) {
                      echo '<span class="label bg-green">Public/Show</span>';
                    } else {
                      echo '<span class="label bg-red">Private/Hide</span>';
                    } ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url() . 'admin/journal/edit/' . $value->id; ?>" class="btn btn-sm bg-green"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url() . 'admin/journal/delete/' . $value->id; ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                  </td>

                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <p><?php if (count($journals_list) > 0) echo $links; ?></p>
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>


</section>


<script>
  $(function() {

    $('.date').datepicker({

      autoclose: true,
      changeYear: true,
      changeMonth: true,
      dateFormat: "dd-mm-yy",
      yearRange: "-10:+10"
    });

  });
</script>