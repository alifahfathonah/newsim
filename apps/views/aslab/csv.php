<html>

<head>
  <title>Coba CSV</title>
</head>

<body>
  <form method="post" action="<?= base_url('Laboran/simpanJadwalCSV') ?>" enctype="multipart/form-data">
    <input type="file" name="file_csv" accept=".csv">
    <button type="submit" name="submit">Submit</button>
  </form>
</body>

</html>