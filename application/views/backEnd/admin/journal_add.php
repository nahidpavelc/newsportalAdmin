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
            <form action="<?php echo base_url("admin/journal/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="col-md-8">

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Publish Date *</label>
                      <input name="published_date" placeholder="Publish Date" class="form-control inner_shadow_teal date" required="" type="text" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Public/Private</label>
                      <select name="public_private" class="form-control">
                        <option value="1">Public</option>
                        <option value="2">Private</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Title *</label>
                      <input name="title" placeholder="Title " class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Volume *</label>
                      <input name="journal_volume" placeholder="Journal Volume" class="form-control inner_shadow_teal" required="" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Published Organization</label>
                      <input name="published_organization" placeholder="Published Organization" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Location</label>
                      <input name="location" placeholder="Location" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Paid Type</label>
                      <select name="paid_type" id="paid_type" class="form-control select2">
                        <option value="1">Paid</option>
                        <option value="2">Free</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Total Read</label>
                      <input name="total_read" placeholder="Total Read" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Introduction *</label>
                      <textarea name="journal_introduction" rows="2" class="form-control inner_shadow_teal" required></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label> Online Reading Link</label>
                      <input name="online_reading_link" placeholder="Online Reading Link" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-4">

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Journal Type</label>
                      <select name="journal_type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="1">Exclusive</option>
                        <option value="2">Non Exclusive</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">

                  <div class="box box-teal">
                    <div class="box-header"> <label> Journal Cover Photo </label> </div>
                    <div class="box-body box-profile">
                      <center>
                        <img id="journals_picture_change" class="img-responsive" src="<?php echo base_url('assets/uploads.png') ?>" alt="Cover Photo" style="width: 85px;"><small style="color: gray">width : 600px, Height : 400px</small>
                        <br>
                        <input type="file" name="journal_cover_photo" onchange="readpicture(this);">
                      </center>
                    </div>

                  </div>

                </div>

                <div class="col-md-12">

                  <div class="box box-teal">
                    <div class="box-header"> <label> journal PDF *</label> </div>
                    <div class="box-body box-profile">
                      <center>
                        <input type="file" name="journal_pdf" required>
                      </center>
                    </div>

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
                      <input name="contact_with_name" placeholder="Contact with Name" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Contact with Phone</label>
                      <input name="contact_with_phone" placeholder="Contact with Phone" class="form-control inner_shadow_teal" type="text">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label>Contact with pemail</label>
                      <input name="contact_with_pemail" placeholder="Contact with pemail" class="form-control inner_shadow_teal" type="email">
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
                        <div class="col-md-12">
                          <div class="box box-teal">
                            <div class="box-header"> <label> Contribution Pdf</label> </div>
                            <div class="box-body box-profile">
                              <center>
                                <input type="file" name="contribution_pdf[]" onchange="readpicture(this);">
                              </center>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                <?php } ?>
              </div>

              <div class="col-md-12">
                <center>
                  <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                  <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save'); ?></button>
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

  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#journals_picture_change1')
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