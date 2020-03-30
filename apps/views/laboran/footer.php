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
<!-- Addon scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/chartJs/Chart.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
  window.setTimeout(function() {
    $(".msg").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3500);

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

    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });
  });

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
</script>
</body>

</html>