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
if ($profil->no_telp == null || $profil->ttd_dosen == null) {
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
if ($profil->ttd_dosen == null) {
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
      toastr.warning("Please put your signature in Setting Menu. You can upload your signature or draw your signature");
    });
  </script>
<?php
}
if (uri('1') == 'PracticumAssistant') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".mk").select2({
        placeholder: "Select Courses"
      });

      $(".tahun").select2({
        placeholder: "Select Year"
      });
    });
  </script>
<?php
}
if (uri('1') == 'LPJAsprak') {
  ?>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.dataTables').DataTable({
          pageLength: 10,
          responsive: true,
          dom: '<"html5buttons"B>lTfgitp',
          buttons: []
        });
      });
    </script>
  <?php
  }
if (uri('2') == 'ViewPresence') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/lightbox/ekko-lightbox.js"></script>
  <script>
    <?php
    $approve  = 0;
    $pending  = 0;
    $no_action  = 0;
    $jumlah = 0;
    $delete = 0;
    foreach ($bap as $b) {
      if ($b->approve_absen == '1') {
        $no_action = $no_action + 1;
      } elseif ($b->approve_absen == '2') {
        $approve = $approve + 1;
      } elseif ($b->approve_absen == '0') {
        $pending = $pending + 1;
      }
      $jumlah = $jumlah + 1;
    }
    ?>
    var jumlah = <?= $jumlah ?>;
    var belum = <?= $no_action ?>;
    var iya = <?= $approve ?>;
    var tahan = <?= $pending ?>;

    $(document).on("click", '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
    });

    function approve(id) {
      $.ajax({
        url: '<?= base_url('BAP/ApprovePresence/') ?>' + id,
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          if (response == 'true') {
            document.getElementById('button' + id).innerHTML = '';
            document.getElementById('button' + id).innerHTML = '<button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i> Approved</button>';
            iya = iya + 1;
            belum = belum - 1;
            if (iya == jumlah) {
              document.getElementById('refresh').innerHTML = '<a href="<?= base_url('BAP/ApproveBAP/' . substr(sha1($total->id_honor), 19, 9)) ?>"><button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approve BAP</button></a>';
            }
          }
        }
      });
    }

    function pending(id) {
      $.ajax({
        url: '<?= base_url('BAP/PendingPresence/') ?>' + id,
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          if (response == 'true') {
            document.getElementById('button' + id).innerHTML = '';
            document.getElementById('button' + id).innerHTML = '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-ban"></i> Pending</button>';
            tahan = tahan + 1;
            belum = belum - 1;
            if (tahan > 0 && belum == 0) {
              document.getElementById('refresh').innerHTML = '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-check"></i> Waiting to fix their presence</button>';
            }
          }
        }
      });
    }

    function hapus(id) {
      $.ajax({
        url: '<?= base_url('BAP/DeletePresence/') ?>' + id,
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          if (response == 'true') {
            document.getElementById('button' + id).innerHTML = '';
            document.getElementById('button' + id).innerHTML = '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-ban"></i> Deleted</button>';
            jumlah = jumlah - 1;
            if (iya == jumlah) {
              document.getElementById('refresh').innerHTML = '<a href="<?= base_url('BAP/ApproveBAP/' . substr(sha1($total->id_honor), 19, 9)) ?>"><button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approve BAP</button></a>';
            }
          }
        }
      })
    }
  </script>
<?php
}
if (uri('1') == 'Setting') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/html2canvas.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/numeric-1.2.6.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/bezier.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/jquery.signaturepad_dosen.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/json2.min.js"></script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    function opsi_ttd() {
      if (document.getElementById('draw').checked) {
        document.getElementById('tampil_field_draw').style.display = 'block';
        document.getElementById('tampil_field_upload').style.display = 'none';
      } else {
        document.getElementById('tampil_field_draw').style.display = 'none';
        document.getElementById('tampil_field_upload').style.display = 'block';
      }
    }

    $(document).ready(function() {
      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });

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
          swal({
            title: 'Success!',
            text: 'Your signature successfully saved',
            timer: 1500,
            type: 'success',
            showConfirmButton: false
          }, function() {
            $.ajax({
              url: '<?= base_url('Setting/SaveSignature') ?>',
              data: {
                img_data: img_data
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
if (uri('1') == 'HistoryLogin') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    });
  </script>
<?php
}
?>
</body>

</html>