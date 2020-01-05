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
              //echo form_open( base_url( 'lawyer/imageUpload' ), array( 'id' => 'user-form', 'class' => 'user-form' ) ); 
              ?>
              <?php echo form_open_multipart('lawyer/uploadImage');?>
                <div class="card-body">
                   
                  
                    
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                   
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="Submit" class="btn btn-primary">Submit</button>
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
      function saveUser(e) {
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
      }
      </script>