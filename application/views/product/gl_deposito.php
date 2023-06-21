<?php 
  $CI = get_instance();
?>
<style type="text/css">
.table th, .table td {
    border-top: 1px solid #fff;
    border-bottom: 1px solid #ddd;
    line-height: 12px;
    padding: 5px;
    text-align: left;
    vertical-align: top;
    font: 12px Tahoma;
}
</style>
<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
            <input type="checkbox" class="header" checked value="" />
            <span class="color-mode-label">Fixed Header</span>
            </label>                   
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title">
      Product Setup <small>GL Deposito</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">GL Deposito Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>GL Deposito</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="produk_deposito">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#produk_deposito .checkboxes" /></th>
               <th width="10%">Kode Produk</th>
               <th width="14%">Deskripsi</th>
               <th width="14%">GL Saldo</th>
               <th width="14%">GL Biaya</th>
               <th width="14%">GL Admin</th>
               <th width="14%">GL Admin</th>
               <th width="14%">GL Admin</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Tambah GL deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk deposito Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_deposit_gl_code" id="product_deposit_gl_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Description<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="description" id="description" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_saldo" id="gl_saldo" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_bagihasil" id="gl_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pajak Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_pajak_bagihasil" id="gl_pajak_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Zakat Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_zakat_bagihasil" id="gl_zakat_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Admin<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_adm" id="gl_adm" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->



<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit GL deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="product_deposit_gl_id" name="product_deposit_gl_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk deposito Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_deposit_gl_code" id="product_deposit_gl_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Description<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="description" id="description" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_saldo" id="gl_saldo" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_bagihasil" id="gl_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pajak Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_pajak_bagihasil" id="gl_pajak_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Zakat Bagi Hasil<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_zakat_bagihasil" id="gl_zakat_bagihasil" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Admin<span class="required">*</span></label>
               <div class="controls">
                  <select name="gl_adm" id="gl_adm" class="large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>       
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>    
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'produk_deposito';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#produk_deposito .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#produk_deposito .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        $("#rencana").hide();
      });


      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              product_deposit_gl_code: {
                  required: true,
                  minlength: 4,
                  maxlength: 5
              },
              description: {
                  required: true
              },
              gl_saldo: {
                  required: true
              },
              gl_bagihasil: {
                  required: true
              },
              gl_pajak_bagihasil: {
                  required: true
              },
              gl_zakat_bagihasil: {
                  required: true
              },
              gl_adm: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"product/add_produk_gl_deposito",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
                }else{
                  success1.hide();
                  error1.show();
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });


       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var product_deposit_gl_id = $(this).attr('product_deposit_gl_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_deposit_gl_id:product_deposit_gl_id},
          url: site_url+"product/get_gl_deposito_by_product_id",
          success: function(response)
          {
            $("#product_deposit_gl_id, #form_edit").val(response.product_deposit_gl_id); 
            $("#product_deposit_gl_code, #form_edit").val(response.product_deposit_gl_code); 
            $("#description, #form_edit").val(response.description); 
            $("#gl_saldo, #form_edit").val(response.gl_saldo); 
            $("#gl_bagihasil, #form_edit").val(response.gl_bagihasil); 
            $("#gl_pajak_bagihasil, #form_edit").val(response.gl_pajak_bagihasil); 
            $("#gl_zakat_bagihasil, #form_edit").val(response.gl_zakat_bagihasil); 
            $("#gl_adm, #form_edit").val(response.gl_adm); 
          }
        });

      });



      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              product_deposit_gl_code: {
                  required: true,
                  minlength: 4,
                  maxlength: 5
              },
              description: {
                  required: true
              },
              gl_saldo: {
                  required: true
              },
              gl_bagihasil: {
                  required: true
              },
              gl_pajak_bagihasil: {
                  required: true
              },
              gl_zakat_bagihasil: {
                  required: true
              },
              gl_adm: {
                  required: true
              }
          },

          
          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"product/edit_produk_gl_deposito",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#produk_deposito_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var product_deposit_gl_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          product_deposit_gl_id[$i] = $(this).val();

          $i++;

        });

        if(product_deposit_gl_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"product/delete_produk_gl_deposito",
              dataType: "json",
              data: {product_deposit_gl_id:product_deposit_gl_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      // begin first table
      $('#produk_deposito').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"product/datatable_produk_gl_deposito",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false }
            ,null
            ,null
            ,null
            ,null
            ,null
            ,null
            ,null
            ,{ "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
              "sLengthMenu": "_MENU_ records per page",
              "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
              }
          },
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0]
              }
          ]
      });

      


      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

