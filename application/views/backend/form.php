  <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
                <?php echo validation_errors(); ?>
              <!-- /.card-header -->
              <!-- form start -->
                <?php
              echo form_open_multipart( base_url( 'lawyer/save_user' ), array( 'id' => 'user-form', 'class' => 'user-form' ) ); ?>
                <div class="card-body">
                  <div class="form-group">
<!--                    <label for="exampleInputEmail1">Email address</label>-->
                     <?php echo form_label('Email Addresss :', 'exampleInputEmail1'); ?>
                      <?php
                      $data= array(
                          'name' => 'email',
                          'placeholder' => 'Enter email',
                          'class' => 'form-control',
                          'id' => 'mail_id',
                          'value' => set_value('email')
                      );
                      echo form_input($data);
                      ?>
                      <?php echo form_error('username'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>">
                      <?php echo form_error('password'); ?>
                  </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control"  placeholder="Confirm Password" name="passconf" value="<?php echo set_value('passconf'); ?>">
                        <?php echo form_error('passconf'); ?>
                    </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="photo">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1"  name="check_me_out">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-primary" onclick="saveUser(event)">Submit</button>
                </div>
                <?php echo form_close();?>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <!-- right column -->

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div>
  <script>
     /* function saveUser(e) {
          e.preventDefault();
         // var form = $('#become_lawyer_form')[0];
         // var formData = new FormData(form);
          $.ajax({
              type: "POST",
              url:  '<?= base_url() ?>lawyer/save_user',
              //  url: 'http://localhost/lawyer/ws/become-lawyer',
              data: $("#user-form").serialize(),
              //data: formData,
              //cache:false,
              //contentType: false,
              //processData: false,
              beforeSend: function () {
                 // var message = '<div class="alert alert-success"><strong>Please wait .....</strong></div>';
                 // $(".form_message").html(message);
                  // $('#maskregitr').mask("Please wait .....");
              },
              success: function (response) {
                  console.log(response);
                  //var result = JSON.parse(response);
                  //console.log(result);
                 // $.each(response, function(key, value) {
                       console.log(value);
                    //  $('#input-' + key).addClass('is-invalid');

                      //$('#input-' + key).parents('.form-group').find('#error').html(value);
                 // });
                  //console.log(response);

              },
              error: function (jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } */


      function saveUser(e) {
          e.preventDefault();
          var form = $('#user-form')[0];
          var formData = new FormData(form);
          $.ajax({
              type: "POST",
              url: '<?= base_url() ?>lawyer/save_user',
              data: formData,
              cache:false,
              contentType: false,
              processData: false,
              beforeSend: function () {
                  // $('#maskregitr').mask("Please wait .....");
              },
              success: function (response) {
                 console.log(response);

              },
              error: function (jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
      </script>