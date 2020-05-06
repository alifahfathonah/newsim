<div class="footer">
  <div>
    <strong>Copyright</strong> SIM Laboratorium Team &copy; 2017
  </div>
</div>
</div>
</div>
<!-- Mainly scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/moment.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/pace/pace.min.js"></script>
<!-- Addon scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/chartJs/Chart.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
  window.setTimeout(function() {
    $(".msg").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3500);

  function hanya_angka(event) {
    var angka = (event.which) ? event.which : event.keyCode
    if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
      return false;
    return true;
  }

  <?php
  if (isset($komplain)) {
  ?>
    $(function() {
      var line_data = {
        labels: ['', <?php
                      foreach ($komplain as $k) {
                        echo "'" . $k->bulan . "', ";
                      }
                      ?>],
        datasets: [{
          label: 'Complaint(s)',
          backgroundColor: 'rgba(26,179,148,0.5)',
          borderColor: "rgba(26,179,148,0.7)",
          pointBackgroundColor: "rgba(26,179,148,1)",
          pointBorderColor: "#fff",
          data: [0, <?php
                    foreach ($komplain as $k) {
                      echo $k->jumlah . ',';
                    }
                    ?>]
        }]
      };

      var line_option = {
        responsive: true,
        legend: {
          display: false
        }
      };

      var ctx = document.getElementById("grafik_komplain").getContext("2d");
      new Chart(ctx, {
        type: 'line',
        data: line_data,
        options: line_option
      });
    });
  <?php
  }
  ?>

  var tanggal_sekarang = new Date();
  tanggal_sekarang.setDate(tanggal_sekarang.getDate());
  $(document).ready(function() {
    $('#date_picker .input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true,
      startDate: tanggal_sekarang
    });

    $('#tanggal_komplain .input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true
    });

    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });

    <?php
    if (uri('1') == 'StockLists') {
    ?>
      $('.stock_lists').DataTable({
        pageLength: 10,
        responsive: true,
        <?php
        if (isset($id_lab)) {
          echo "'ajax': '" . base_url('StockLists/ajaxStockLists/' . $id_lab) . "',";
        } else {
          echo "'ajax': '" . base_url('StockLists/ajaxStockLists') . "',";
        }
        ?> 'columns': [{
          "data": "no"
        }, {
          "data": "barcode"
        }, {
          "data": "tools"
        }, {
          "data": "lab"
        }, {
          "data": "qty"
        }, {
          "data": "condition"
        }, {
          "data": "spesification"
        }, {
          "data": "action"
        }],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    <?php
    }
    ?>

    <?php
    if (uri('2') == 'JournalAssistant') {
    ?>
      $('.kegiatan_aslab_full').DataTable({
        pageLength: 10,
        responsive: true,
        'ajax': '<?= base_url('LaboratoryAssistant/ajaxKegiatanAslab') ?>',
        'columns': [{
            'data': 'no'
          },
          {
            'data': 'tanggal'
          },
          {
            'data': 'nama'
          },
          {
            'data': 'aktivitas'
          }
        ],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    <?php
    }
    ?>

    $(".laboratorium").select2({
      placeholder: "Select a Laboratory",
    });

    $(".periode").select2({
      placeholder: "Select a Periode of Journal",
    });

    $('.dataTables').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: []
    });

    $('.daftar_lab').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: []
    });

    $('.kegiatan_aslab').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: []
    });

    $('.peminjaman').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: []
    });

    $('.history_login').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: []
    });

    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    <?php
    if (uri('1') == 'Schedule') {
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
        eventSources: [
          <?php
          if ($id_lab) {
            echo "'" . base_url('Schedule/ajaxJadwal/' . $id_lab) . "'";
          } else {
            echo "'" . base_url('Schedule/ajaxJadwal') . "'";
          }
          ?>
        ]
      });

      $('#calendar').fullCalendar('changeView', 'agendaDay');
    <?php
    }
    ?>
  });
</script>
</body>

</html>