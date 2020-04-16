<div class="footer">
  <div>
    <strong>Copyright</strong> SIM Laboratorium Team &copy; 2017
  </div>
</div>
</div>
</div>
<!-- Mainly scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/pace/pace.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/toastr/toastr.min.js"></script>
<?php
if ($profil->kontak_asprak == null || $profil->ttd_asprak == null || $profil->id_bank == null || $profil->norek_asprak == null) {
?>
  <script>
    $(function() {
      toastr.options = {
        "closeButton": false,
        "debug": false,
        "progressBar": false,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.warning("Please complete your personal information in Setting Menu");
    });
  </script>
<?php
}
?>
<?php
if (uri('2') == 'Schedule') {
?>
  <!-- Addon scripts -->
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/moment.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
<?php
}
if (uri('2') == 'PracticumAssistant' || uri('2') == 'Presence' || uri('2') == 'AddPresence' || uri('2') == 'BAP' || uri('2') == 'HistoryLogin') {
?>
  <!-- Addon scripts -->
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/clockpicker/clockpicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script>
    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".jadwal").select2({
        placeholder: "Select a Schedule"
      });

      $(".matapraktikum").select2({
        placeholder: "Select Cource"
      });
      $(".periode_bap").select2({
        placeholder: "Select Month"
      });

      $('.clockpicker').clockpicker();

      $('#tanggal .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
    });
  </script>
<?php
}
?>
<?php
if (uri('2') == 'BAP') {
?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#matapraktikum").change(function() {
        var idMK = $(this).val();
        var bulan = document.getElementById('month').value;
        if (bulan != '') {
          bulan = bulan;
        }
        document.getElementById('course').value = idMK;
        $.ajax({
          url: "<?= base_url() ?>Asprak/ajaxBAP",
          method: "POST",
          data: {
            bulan: bulan,
            idMK: idMK
          },
          success: function(data) {
            $('#tampil').html(data);
          }
        });
      });

      $("#bulan").change(function() {
        var bulan = $(this).val();
        var idMK = document.getElementById('matapraktikum').value;
        document.getElementById('month').value = bulan;
        if (idMK != '') {
          document.getElementById('month').value = bulan;
          $.ajax({
            url: "<?= base_url() ?>Asprak/ajaxBAP",
            method: "POST",
            data: {
              bulan: bulan,
              idMK: idMK
            },
            success: function(data) {
              $('#tampil').html(data);
            }
          });
        }
      });
    });
  </script>
<?php
}
?>
<?php
if (uri('2') == 'Setting') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/html2canvas.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/numeric-1.2.6.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/bezier.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/jquery.signaturepad.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/json2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#signArea').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90
      });

      $("#btnClearSign").click(function(e) {
        $('#signArea').signaturePad().clearCanvas();
      });
    });

    $("#btnSaveSign").click(function(e) {
      html2canvas([document.getElementById('sign-pad')], {
        onrendered: function(canvas) {
          var canvas_img_data = canvas.toDataURL('image/png');
          var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
          var nim_asprak = document.getElementById('nim_asprak').value;
          swal({
            title: 'Success!',
            text: 'Your signature successfully saved',
            timer: 1500,
            type: 'success',
            showConfirmButton: false
          }, function() {
            $.ajax({
              url: '<?= base_url('Asprak/SaveSignature') ?>',
              data: {
                img_data: img_data,
                nim_asprak: nim_asprak
              },
              type: 'post',
              dataType: 'json',
              success: function(response) {
                window.location.reload();
              }
            });
          });
        }
      });
    });

    function hapus_ttd() {
      var nim_asprak = document.getElementById('nim_asprak').value;
      swal({
        title: 'Are you sure?',
        text: 'Do you want to delete your signature',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        closeOnConfirm: false
      }, function() {
        swal({
          title: 'Deleted!',
          text: 'Your signature has been deleted',
          timer: 1500,
          type: 'success',
          showConfirmButton: false
        }, function() {
          $.ajax({
            url: '<?= base_url('Asprak/DeleteSignature') ?>',
            data: {
              nim_asprak: nim_asprak
            },
            type: 'post',
            dataType: 'json',
            success: function(response) {
              window.location.reload();
            }
          });
        });
      });
    }
  </script>
<?php
}
?>
<script>
  window.setTimeout(function() {
    $(".msg").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3500);

  $(document).ready(function() {
    <?php
    if (uri('2') == 'Setting') {
    ?>
      $(".nama_bank").select2({
        placeholder: "Select a Bank Name",
      });
    <?php
    }
    if (uri('2') == 'Schedule') {
    ?>
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false,
        contentHeight: 600,
        eventSources: ['<?= base_url('Asprak/ajaxJadwal') ?>'],
        axisFormat: 'H:mm',
        timeFormat: {
          agenda: 'H:mm'
        }
      });

      $('#calendar').fullCalendar('changeView', 'agendaWeek');
    <?php
    }
    ?>

  });
</script>
</body>

</html>