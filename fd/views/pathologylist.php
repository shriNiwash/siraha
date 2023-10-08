<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pathology</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .karan{
        width:100%;
    }
    .full-page-modal {
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.5); /* Semi-transparent background overlay */
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1050; /* Ensure it's above other content */
}

.full-page-modal .modal-dialog {
  max-width: 100%;
  margin: 0;
}

</style>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pathology</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <form class="d-flex" role="search">
        <?php if($status=="1") { ?>
            <a  class="btn btn-primary btn-sm" style="margin-right:4px;" href="<?php echo base_url('pathology') ?>" >New Invoice</a>


     <?php   }if($status=="0"){ ?>
        <a  class="btn btn-danger btn-sm " style="margin-right:4px;" href="<?php echo base_url('pathology/old_report') ?>" > Old Report</a>


      <?php  } ?>

        <button  class="btn btn-outline-success" id="logout" type="button">Logout</button>
      </form>

  </div>
</nav>

<section class="sectionfordata">
<table class="table table-striped" id="myTable">
  <thead>
    <tr>
      <th scope="col">Bill NO</th>
      <th scope="col">Merge Bill Number</th>
      <th scope="col">HIS Number</th>
      <th scope="col">Reporting Date</th>
      <th scope="col">Tests</th>
      <th scope="col">Patient Name</th>
      <th scope="col">Billed By</th>
      <th scope="col">Refrence Doctor</th>
      <th scope="col">Is Printed</th>
    </tr>
  </thead>
  <tbody>
  <?php  if(!empty($result)) { foreach ($result as $value) { ?>
    <tr>
       <td><?= $prefix.$value->id; ?></td>

        <td><?= $value->merge_bill_id; ?></td>
        <td><?= $value->case_reference_id; ?></td>
        <td><?= $value->date; ?></td>
        <td><?= $value->id; ?></td>
        <td><?= $value->patient_name; ?></td>
        <td><?= $value->billed_by_name; ?></td>
        <td><?= $value->doctor_name; ?></td>
        <?php if($status=="1") { ?>

            <td><a class="btn btn-danger print_parameter" data-bill-id="<?php echo $value->id; ?>" style="padding-left: 8px;padding-right: 8px;padding-bottom: 4px;padding-top: 4px;font-size: 15px;">Reprint</a><a href='javascript:void(0)'  data-loading-text='please wait' data-record-id="<?php echo $value->id; ?>"  class='btn btn-default  view_detail' data-toggle='tooltip' title='view' ><i class='fa fa-reorder'></i></a></td>

     <?php   }if($status=="0"){ ?>
        <td><a class="btn btn-success bulk_report_entry" data-bill-id="<?php echo $value->id; ?>" style="padding-left: 8px;padding-right: 8px;padding-bottom: 4px;padding-top: 4px;font-size: 15px;">Entry</a><a href='javascript:void(0)'  data-loading-text='please wait' data-record-id="<?php echo $value->id; ?>"  class='btn btn-default  view_detail' data-toggle='tooltip' title='view' ><i class='fa fa-reorder'></i></a></td>


      <?php  } ?>
    </tr>
<?php } }?>

  </tbody>
</table>
</section>

<footer class="footer footer-alt fw-medium">
  <span class="bg-body"> | 3.2.1 | Tez Healthcare Login : <?php echo $username; ?></span>
</footer>
<div class="modal fade full-page-modal" id="viewDetailReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  pup100" role="document" >
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(to right,#dbd756,#306589 100%);color:#fff;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Bill Details</h1>
        <div class="modalicon"  >
            <div id='action_detail_report_modal'>
            </div>
          </div>
        <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:white;"></button>
      </div>
      <div class="modal-body" >

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="reportEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(to right,#dbd756,#306589 100%);color:#fff;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Report Entry</h1>
        <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:white;"></button>

      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addReportbulkModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <form action="<?php echo base_url('pathology/updatebulkreport') ?>" method="POST" id="form-report_param">
      <div class="modal-header" style="background:linear-gradient(to right,#dbd756,#306589 100%);color:#fff;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Edit Report</h1>
        <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:white;"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">save</button>
      </div>
     </form>
    </div>
  </div>
</div>


<div class="modal fade" id="collectionModal" role="dialog" aria-labelledby="myModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog" style="pointer-events:auto;" role="document">
    <div class="modal-content modal-media-content">
      <form action="<?php echo base_url('pathology/updatecollection') ?>" method="POST" id="form-sample-collected">
        <div class="modal-header" style="background: linear-gradient(to right, #dbd756, #306589 100%); color: #fff;">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Sample Collection</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
        </div>
        <h4 class="modal-title"><?php echo $this->lang->line('sample_collection'); ?></h4>
        </div>
        <div class="modal-body " style="background:#8fd6b0;">
          <input type="hidden" name="pathology_report_id" value="0"id="re_id">
          <input type="hidden" name="pathology_bill_id" value="0"id="pa_id">
          <div class="form-group">
            <label>Sample Collected Person Name</label><small class="req"> *</small>
            <select class="form-control" name="collected_by" id="collected_by" required>
              <option value="">Select</option>
              <?php if (!empty($pathologist)) {
                foreach ($pathologist as $dkey => $dvalue) {
              ?>
                  <option value="<?php echo $dvalue->id; ?>"><?php echo $dvalue->name . " " . $dvalue->surname . " (" . $dvalue->employee_id . ")" ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Collected Date</label><small class="req"> *</small>
            <input type="date" required class="form-control" name="collected_date" id="datepicker">
          </div>
          <div class="form-group">
            <label>Pathology Center</label><small class="req"> *</small>
            <input type="text" class="form-control" required name="pathology_center" id="pathology_center">
          </div>
        </div>
        <div id="error-messages"></div>

        <div class="modal-footer" style="background:linear-gradient(to right, #dbd756, #306589 100%);">
          <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="collectionbulkModal" role="dialog" aria-labelledby="myModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog" style="pointer-events:auto;" role="document">
    <div class="modal-content modal-media-content">
      <form action="<?php echo base_url('pathology/updatecollection') ?>" method="POST" id="form-sample-collected">
        <div class="modal-header" style="background: linear-gradient(to right, #dbd756, #306589 100%); color: #fff;">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Sample Collection</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
        </div>
        <h4 class="modal-title"><?php echo $this->lang->line('sample_collection'); ?></h4>
        </div>
        <div class="modal-body " style="background:#8fd6b0;">
          <!-- <input type="hidden" name="pathology_report_id" value="0"id="re_id"> -->
          <!-- <input type="" name="pathology_bill_id" value="0"id="pa_id" class="pa_id"> -->
          <div class="form-group">
            <label>Sample Collected Person Name</label><small class="req"> *</small>
            <select class="form-control" name="collected_by" id="collected_by" required>
              <option value="">Select</option>
              <?php if (!empty($pathologist)) {
                foreach ($pathologist as $dkey => $dvalue) {
              ?>
                  <option value="<?php echo $dvalue->id; ?>"><?php echo $dvalue->name . " " . $dvalue->surname . " (" . $dvalue->employee_id . ")" ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Collected Date</label><small class="req"> *</small>
            <input type="date" required class="form-control" name="collected_date" id="datepicker">
          </div>
          <div class="form-group">
            <label>Pathology Center</label><small class="req"> *</small>
            <input type="text" class="form-control" required name="pathology_center" id="pathology_center">
          </div>
        </div>
        <div id="error-messages"></div>

        <div class="modal-footer" style="background:linear-gradient(to right, #dbd756, #306589 100%);">
          <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                searching: true,
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
<script>

    $(document).on('click','.view_detail',function(){
    var id=$(this).data('recordId');
    PatientPathologyDetails(id,$(this));
  });

  function PatientPathologyDetails(id,btn_obj){
    jQuery.ajax({
      url: '<?php echo base_url('pathology/getPatientPathologyDetails') ?>',
      type: "POST",
      data: {id : id},
      dataType: 'json',
      success: function (res) {
        $('#viewDetailReportModal .modal-body').html(res.page);
        $('#viewDetailReportModal #action_detail_report_modal').html(res.actions);
        $('#viewDetailReportModal').modal('show');
      },

      error: function(xhr) { // if error occured
        console.log(xhr.responseText);

        alert("Error Occurred");

      }
    });
  }

//   $(document).on('click','.view_detail',function(){
//     var id=$(this).data('recordId');
//     pathologyEntry(id,$(this));
//   });

  function pathologyEntry(id,btn_obj){
    jQuery.ajax({
      url: '<?php echo base_url('pathology/getPathologyEntry') ?>',
      type: "POST",
      data: {id : id},
      dataType: 'json',
      success: function (res) {

        $('#viewDetailReportModal .modal-body').html(res.page);
        $('#viewDetailReportModal').modal('show');
      },

      error: function(xhr) { // if error occured
        console.log(xhr.responseText);

        alert("Error Occurred");

      }
    });
  }

  $(document).on('click','#select_all', function () {
  if (this.checked) {
    $('.checkbox').each(function () {
      this.checked = true;
    });
  } else {
    $('.checkbox').each(function () {
      this.checked = false;
    });
  }
});
function print_report_individual(report_id,testid){
    jQuery.ajax({
      url: '<?php echo base_url('pathology/getprintreport') ?>',

      type: "POST",
      data: {report_id :report_id, testid :testid},
      dataType: 'json',
      beforeSend: function() {
      },
      success: function (res) {
        popup(res.page);
      },
      error: function(xhr) {
        alert("Error Occured");
      },
      complete: function() {
      }
    // });
      });
  }
  $(document).on('click','.print_parameter',function(){
  var id=$(this).data('bill-id');
  var $this = $(this);

  $.ajax({
    url: '<?php echo base_url('pathology/printtestparameterdetail') ?>',

    type: "POST",
    data: {'id': id},
    dataType: 'json',
    beforeSend: function() {
      $this.button('loading');
    },
    success: function (data) {
      popup(data.page);
    },

    error: function(xhr) { // if error occured
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
      $this.button('reset');

    },
    complete: function() {
      $this.button('reset');

    }
  });
});
  function print_pathology_report(category_id,pid){

    jQuery.ajax({
      url: '<?php echo base_url('pathology/getprinteddatapath') ?>',

      type: "POST",
      data: {pid : pid, cid :category_id},
      dataType: 'json',
      beforeSend: function() {
      },
      success: function (res) {
        popup(res.page);
      },

      error: function(xhr) {
        alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

      },
      complete: function() {
      }
    // });
      });
  }
    $(document).on('submit','#form-sample-collected',function(e){
      e.preventDefault();
      var pathology_bill_id=$('#pa_id').val();
      var clicked_btn =  $("button[type=submit]",$(this));
      var form = $(this);
      var url = form.attr('action');
      $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
          clicked_btn.button('loading');
        },
        success: function (res) {
          // console.log(res);
          if(res.status=="success"){
            clicked_btn.button('reset');
            $('#collectionModal').modal('hide');
            $('#collectionbulkModal').modal('hide');

            PatientPathologyDetails(pathology_bill_id,clicked_btn);
          }
        },
        error: function(xhr) { // if error occured
          alert("error occured");
          clicked_btn.button('reset');
        },
        complete: function() {
          clicked_btn.button('reset');
        }
      });
    });
    $(document).on('click','.bulk_sample_collection',function(){
  var bill_id=$(this).data('bill_id');
  var bulk_sample=$('#bulk_sample');
    var $this = $(this);
  $.ajax({
    url: '<?php echo base_url('pathology/bulk_sample') ?>',

    type: "POST",
    data: {'bill_id': bill_id,'is_bill': 'yes'},
    dataType:"JSON",
    beforeSend: function(){
    $this.button('loading');
    },
    success: function (res) {
      console.log(res);
      $("collectionbulkModal #collected_by").val(res.collection_specialist);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_report_id"]').val(res.id);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_bill_id"]').val(res.pathology_bill_id);
      $('#collectionbulkModal #pa_id').val(bill_id);
      $("#collectionbulkModal .modal-body").find('input[name="pathology_center"]').val(res.pathology_center);
      $("#collectionbulkModal .modal-body").find('input[name="collected_date"]').val(res.collection_date);
      $('#collectionbulkModal').modal('show');
      bulk_sample.removeClass('modal_loading');
    },
    error: function () {
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
      $this.button('reset');
    },  complete: function(){
      $this.button('reset');
    }
  });
});


    $(document).on('submit','#form-report_param',function(e){
        e.preventDefault();
        var pathology_bill_id=$(this).find('input[name="pathology_bill_id"]').val();
        var clicked_btn =  $("button[type=submit]",$(this));
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
          url: $(this).attr('action'),
          type: "POST",
          data: new FormData(this),
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
            clicked_btn.button('loading');
          },
          success: function (data) {
            if (data.status == "success") {

              var bill_id=data.bill_id;
              $('#addReportModal').modal('hide');
              $('#addReportbulkModal').modal('hide');
              PatientPathologyDetails(pathology_bill_id,clicked_btn);
              print_report(bill_id);
            }
            clicked_btn.button('reset');
          },
          error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            clicked_btn.button('reset');
          },
          complete: function() {
            clicked_btn.button('reset');
          }
        });
      });
      function print_report(id){
        var $this = $('.print_parameter');
        $.ajax({
          url: '<?php echo base_url('pathology/printtestparameterdetail') ?>',

          type: "POST",
          data: {'id': id},
          dataType: 'json',
          beforeSend: function() {
            $this.button('loading');
          },
          success: function (data) {
            popup(data.page);
          },

          error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

          },
          complete: function() {
            $this.button('reset');

          }
        });
      }




  function popup(data)
{
  var base_url = '<?php echo base_url() ?>';
  var frame1 = $('<iframe />');
  frame1[0].name = "frame1";
  frame1.css({"position": "absolute", "top": "-1000000px"});
  $("body").append(frame1);
  var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
  frameDoc.document.open();
  //Create a new HTML document.
  frameDoc.document.write('<html>');
  frameDoc.document.write('<head>');
  frameDoc.document.write('<title></title>');
  frameDoc.document.write('</head>');
  frameDoc.document.write('<body >');
  frameDoc.document.write(data);
  frameDoc.document.write('</body>');
  frameDoc.document.write('</html>');
  frameDoc.document.close();
  setTimeout(function () {
    window.frames["frame1"].focus();
    window.frames["frame1"].print();
    frame1.remove();
    if (frame1.remove()) {
    }
  }, 500);
  return true;
}

$(document).on('click','.add_collection',function(){
    $('#collected_by').val('');
    var id=$(this).data('recordId');
    var modal_view=$('#collectionModal');
    var $this = $(this);
    $.ajax({
      url: '<?php echo base_url('pathology/getsamplecollect') ?>',

      type: "POST",
      data: {id : id},
      dataType: 'json',
      beforeSend: function() {
        $this.button('loading');
      },
      success: function (res) {
        $("#collected_by").val(res.collection_specialist);
        $("#collectionModal .modal-body").find('input[name="pathology_report_id"]').val(res.id);
        $("#collectionModal .modal-body").find('input[name="pathology_bill_id"]').val(res.pathology_bill_id);
        $("#collectionModal .modal-body").find('input[name="pathology_center"]').val(res.pathology_center);
        $("#collectionModal .modal-body").find('input[name="collected_date"]').val(res.collection_date);
        $('#collectionModal').modal('show');
      },

      error: function(xhr) { // if error occured
        alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
        $this.button('reset');

      },
      complete: function() {
        $this.button('reset');

      }
    });
  });



  $(document).on('click','.bulk_report_print', function () {
  let obj =  [];
  var case_id = $(this).data('case_id');
  var id = $(this).data('bill_id');
    $.each($("input[class='checkbox']:checked"), function () {
    var bill_id = $(this).data('bill_id');
    var test_id = $(this).data('test_id');
    item = {};
    item ["bill_id"] = bill_id;
    item ["test_id"] = test_id;
    obj.push(item);
  });
  if (obj.length == 0) {
      $('.checkbox').each(function () {
        this.checked = true;
      });

    $.each($("input[class='checkbox']:checked"), function () {
    var bill_id = $(this).data('bill_id');
    var test_id = $(this).data('test_id');
    item = {};
    item ["bill_id"] = bill_id;
    item ["test_id"] = test_id;
    obj.push(item);
  });
}
  $.ajax({
    url: '<?php echo base_url('pathology/bull_report_printing') ?>',

    type: 'post',
    data: {'datae':JSON.stringify(obj),case_id:case_id,id:id},
    dataType:"json",
    success: function (res) {
      popup(res.page);
    },
    error: function(xhr) { // if error occured
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

    },
    complete: function() {
    }
  });
});

$(document).on('click','.bulk_report_entry',function(){
  var bill_id=$(this).data('bill-id');
  var bulk_report_entry=$('#bulk_report_entry');
  var $this = $(this);
  $.ajax({
    url: '<?php echo base_url('pathology/bulk_report_entry') ?>',

    type: "POST",
    data: {bill_id: bill_id,is_bill: 'yes'},
    dataType:"JSON",
    beforeSend: function(){
      $this.button('loading');
    },
    success: function (res) {
      $('#addReportbulkModal .modal-body').html(res.page);
    //   $('#addReportbulkModal .filestyle').dropify();
      $('#addReportbulkModal').modal('show');
      bulk_report_entry.removeClass('modal_loading');
    },
    error: function () {
      alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
      $this.button('reset');    },  complete: function(){
        $this.button('reset');

      }
    });
  });

  $(document).on('click','#logout',function(){
    $.ajax({
      url: '<?php echo base_url('pathology/logout') ?>',
      type: 'post',
      dataType:"json",
      success: function (res) {
        window.location.href = '/';
      },
      error: function(xhr) {
        alert("Error Occured");

      },
      complete: function() {
      }
    });
  })


</script>
