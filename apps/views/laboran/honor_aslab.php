<html>

<head>
  <title>Coba CSV</title>
</head>

<body>
  <form method="post" action="<?= base_url('Coba/simpanHonorAslab') ?>" enctype="multipart/form-data">
    <input type="file" name="file_csv" accept=".csv">
    <button type="submit" name="submit">Submit</button>
  </form>
</body>

</html>