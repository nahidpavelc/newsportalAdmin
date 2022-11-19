<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-teal box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Journal Add </h3>
          <div class="box-tools pull-right">
            <a href="<?php echo base_url() ?>admin/journal/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Journal List </a>
          </div>
        </div>
        <div class="box-body">

          <div class="row">
            <form action="<?php echo base_url("admin/journal/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="col-md-8">

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Publish Date *</label>
                      <input name="published_date" value="<?= date('d M Y', strtotime($edit_info->published_date)); ?>" placeholder="Publish Date" class="form-control inner_shadow_teal date" required="" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Public/Private</label>
                      <select name="public_private" class="form-control">
                        <option value="1" <?php if ($edit_info->public_private == 1) echo 'selected'; ?>>Public/Publish</option>
                        <option value="2" <?php if ($edit_info->public_private == 2) echo 'selected'; ?>>Private/Hidden</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Title *</label>
                      <input name="title" value="<?= $edit_info->title; ?>" placeholder="Title " class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Volume *</label>
                      <input name="journal_volume" value="<?= $edit_info->journal_volume; ?>" placeholder="Journal Volume" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Introduction *</label>
                      <textarea name="journal_introduction" rows="4" class="form-control inner_shadow_teal" required><?= $edit_info->journal_introduction; ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Online Reading Link</label>
                      <input name="online_reading_link" value="<?= $edit_info->online_reading_link; ?>" placeholder="Online Reading Link" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Published Organization</label>
                      <input name="published_organization" value="<?= $edit_info->published_organization; ?>" placeholder="Published Organization" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Location</label>
                      <input name="location" value="<?= $edit_info->location; ?>" placeholder="Location" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Paid Type</label>
                      <select name="paid_type" id="paid_type" class="form-control select2">
                        <option value="1" <?php if ($edit_info->paid_type == "1") echo  "selected"; ?>>Paid</option>
                        <option value="2" <?php if ($edit_info->paid_type == "2") echo  "selected"; ?>>Free</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Total Read</label>
                      <input name="total_read" value="<?php echo $edit_info->total_read; ?>" placeholder="Total Read" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Type</label>
                      <select name="journal_type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="1" <?php if ($edit_info->journal_type == 1) echo 'selected'; ?>>Exclusive</option>
                        <option value="2" <?php if ($edit_info->journal_type == 2) echo 'selected'; ?>>Non Exclusive</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <div class="col-sm-12">
                    <label>Total Read</label>
                    <input name="total_read" value="<?= $edit_info->total_read; ?>" placeholder="Total Read" class="form-control inner_shadow_teal" type="text" readonly>
                  </div>
                </div>
              </div>


              <div class="col-md-4">
                <br>
                <div class="box box-teal">
                  <div class="box-header"> <label> Journal Cover Photo </label> </div>
                  <div class="box-body box-profile">
                    <center>
                      <img id="journals_picture_change" class="img-responsive" src="<?php echo base_url($edit_info->journal_cover_photo); ?>" alt="Cover Photo" style="max-width: 120px;"><small style="color: gray">width : 600px, Height : 400px</small>
                      <br>
                      <input type="file" name="journal_cover_photo" onchange="readpicture(this);">
                    </center>
                  </div>

                </div>
              </div>

              <div class="col-md-4">
                <br>
                <div class="box box-teal">
                  <div class="box-header">
                    <label> journal PDF *</label>
                    <?php if ($edit_info->journal_pdf) { ?>
                      <div class="box-tools pull-right">
                        <a target="_blank" href="<?php echo base_url('admin/download-file?file_path=') . ($edit_info->journal_pdf); ?>" class="btn bg-red btn-sm" style="color: white;"> <i class="fa fa-download"></i> Download </a>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="box-body box-profile">
                    <center>
                      <input type="file" name="journal_pdf">
                    </center>
                  </div>

                </div>

              </div>

              <div class="col-md-12">
                <br>
                <center style="margin-top: 0px;margin-bottom: 15px;">
                  <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;">Contact Information</span>
                </center>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Contact with Name</label>
                      <input name="contact_with_name" value="<?= $edit_info->contact_with_name; ?>" placeholder="Contact with Name" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Contact with Phone</label>
                      <input name="contact_with_phone" value="<?= $edit_info->contact_with_phone; ?>" placeholder="Contact with Phone" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Contact with pemail</label>
                      <input name="contact_with_pemail" value="<?= $edit_info->contact_with_pemail; ?>" placeholder="Contact with pemail" class="form-control inner_shadow_teal" type="email">
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-12">
                <br>
                <center style="margin-top: 0px;margin-bottom: 15px;">
                  <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;">Author Information</span>
                </center>

                <input type="hidden" name="showrowid" id="showrowid" value="3">
                <?php for ($i = 1; $i < 16; $i++) { ?>

                  <div id="trid<?= $i; ?>" style="<?php if ($i > 1) echo 'display: none'; ?>">
                    <div class="row" style=" box-shadow: 0px 0px 10px 0px #00c0ef; margin: 8px 53px 20px 55px; padding:20px 4px 20px 4px;">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="col-sm-12">
                              <label>Author</label>
                              <select name="author_id[]" class="form-control inner_shadow_info select2" style="width:100%">
                                <option value=""><?php echo $this->lang->line('select_one'); ?></option>
                                <?php foreach ($author_list as $key => $value) { ?>
                                  <option value="<?php echo $value->id; ?>"><?php echo $value->author_name; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="col-sm-12">
                              <label>Contribution Level</label>
                              <select name="contribution_level[]" class="form-control">
                                <option value="">Select Level</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-sm-12">
                              <label>Contribution Text</label>
                              <textarea name="contribution_text[]" id="contribution_text" rows="3" cols="10" class="form-control inner_shadow_teal"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              </div>

              <div class="col-md-12">
                <br>
                <center style="margin-top: 0px;margin-bottom: 15px;">
                  <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;">Old Author List</span>
                </center>


                <div class="box-body">

                  <table class="table table-bordered table-striped table_th_teal">
                    <thead>
                      <tr>
                        <th style="width: 5%;"><?php echo $this->lang->line("sl"); ?> </th>
                        <th style="width: 30%;">Author Name </th>
                        <th style="width: 25%;">Contribution Level</th>
                        <th style="width: 10%;"><?php echo $this->lang->line("action"); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sl = 1;
                      foreach ($author_info as $value) {
                      ?>
                        <tr>
                          <td><?php echo $sl++; ?></td>
                          <td><?= $value->author_name; ?></td>
                          <td><?php echo $value->contribution_level; ?></td>
                          <td>
                            <a href="<?php echo base_url() . 'admin/journal-authors/' . $value->id; ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                            <a href="<?php echo base_url() . 'admin/journal/delete-author/' . $value->id; ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                          </td>

                        </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-md-12">
                <center>
                  <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                  <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                  <a class="btn btn-sm btn-primary" onclick="makerowvisible();"><i class="fa fa-plus"></i> Add</a>
                </center>
              </div>
            </form>
          </div>
        </div>
      </div>


    </div>
</section>
<script>
  function readpicture(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#journals_picture_change')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<script>
  $(function() {

    $('.date').datepicker({

      autoclose: true,
      changeYear: true,
      changeMonth: true,
      dateFormat: "dd-mm-yy",
      yearRange: "-40:+10"
    });

  });
</script>

<script>
  function makerowvisible() {

    var nextrownumber = $("#showrowid").val();
    $("#trid" + Number(nextrownumber)).show();
    $("#showrowid").val(Number(nextrownumber) + 1);

  }
</script>