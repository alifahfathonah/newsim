<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Model extends CI_Model
{

  function insertData($tabel, $data)
  {
    $this->db->insert($tabel, $data);
  }

  function updateData($tabel, $data, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->update($tabel, $data);
  }

  function deleteData($tabel, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->delete($tabel);
  }

  function profilLaboran($id)
  {
    return $this->db->get_where('laboran', array('nip_laboran' => $id));
  }

  function profilDosen($id)
  {
    return $this->db->get_where('dosen', array('id_dosen' => $id));
  }

  function hitungKomplain()
  {
    $this->db->select('count(idKomplain) komplain');
    $this->db->from('komplain');
    $this->db->where('diperbaikiOleh', null);
    return $this->db->get();
  }

  function hitungPeminjamanAlat()
  {
    $this->db->select('count(idPinjamAlat) pinjamalat');
    $this->db->from('peminjamanalat');
    $this->db->where('status != "Selesai"');
    return $this->db->get();
  }

  function hitungPeminjamanLab()
  {
    $this->db->select('count(idPinjamLab) pinjamlab');
    $this->db->from('peminjamanlab');
    $this->db->where('status != "Selesai"');
    return $this->db->get();
  }

  function hitungKomplainBelumSelesai()
  {
    $this->db->select('count(idKomplain) komplain_belum');
    $this->db->from('komplain');
    $this->db->where('statusKomplain', '0');
    $this->db->where('year(tglKomplain) = year(current_date())');
    $this->db->group_by('year(tglKomplain)');
    return $this->db->get();
  }

  function hitungKomplainSelesai()
  {
    $this->db->select('count(idKomplain) komplain_selesai');
    $this->db->from('komplain');
    $this->db->where('statusKomplain', '1');
    $this->db->where('year(tglKomplain) = year(current_date())');
    $this->db->group_by('year(tglKomplain)');
    return $this->db->get();
  }

  function hitungPeminjamanLabBelumSelesai()
  {
    $this->db->select('count(idPinjamLab) lab_belum');
    $this->db->from('peminjamanlab');
    $this->db->where('status != "Selesai"');
    $this->db->where('year(tglPinjam) = year(current_date())');
    $this->db->group_by('year(tglPinjam)');
    return $this->db->get();
  }

  function hitungPeminjamanLabSelesai()
  {
    $this->db->select('count(idPinjamLab) lab_selesai');
    $this->db->from('peminjamanlab');
    $this->db->where('status = "Selesai"');
    $this->db->where('year(tglPinjam) = year(current_date())');
    $this->db->group_by('year(tglPinjam)');
    return $this->db->get();
  }

  function hitungPeminjamanAlatBelumSelesai()
  {
    $this->db->select('count(idPinjamAlat) alat_belum');
    $this->db->from('peminjamanalat');
    $this->db->where('status != "Selesai"');
    $this->db->where('year(tglPinjam) = year(current_date())');
    $this->db->group_by('year(tglPinjam)');
    return $this->db->get();
  }

  function hitungPeminjamanAlatSelesai()
  {
    $this->db->select('count(idPinjamAlat) alat_selesai');
    $this->db->from('peminjamanalat');
    $this->db->where('status = "Selesai"');
    $this->db->where('year(tglPinjam) = year(current_date())');
    $this->db->group_by('year(tglPinjam)');
    return $this->db->get();
  }

  function grafikKomplain()
  {
    $this->db->select('date_format(tglKomplain, "%b") bulan, count(idKomplain) jumlah');
    $this->db->from('komplain');
    $this->db->where('year(tglKomplain) = year(curdate())');
    $this->db->group_by('date_format(tglKomplain, "%b")');
    $this->db->order_by('tglKomplain', 'asc');
    return $this->db->get();
  }

  function daftarPengumuman()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }

  function daftarLaboratorium()
  {
    $this->db->select('*');
    $this->db->from('laboratorium');
    $this->db->order_by('namaLab', 'asc');
    return $this->db->get();
  }

  function dataStockList($id)
  {
    $this->db->where('substring(sha1(idAlat), 7, 4) = "' . $id . '"');
    return $this->db->get('alatlab');
  }

  function daftarLabPraktikum()
  {
    return $this->db->order_by('namaLab', 'asc')->get_where('laboratorium', array('tipeLab' => 'Practicum Lab'));
  }

  function daftarLabRiset()
  {
    return $this->db->order_by('namaLab', 'asc')->get_where('laboratorium', array('tipeLab' => 'Research Lab'));
  }

  function detailLaboratorium($id)
  {
    $this->db->where('substring(sha1(idLab), 7, 4) = "' . $id . '"');
    return $this->db->get('laboratorium');
  }

  function pjAslab($id, $periode)
  {
    $this->db->select('aslab.namaLengkap');
    $this->db->from('aslab');
    $this->db->join('asistenlab', 'aslab.idAslab = asistenlab.idAslab');
    $this->db->where('substring(sha1(asistenlab.idLab), 7, 4) = "' . $id . '"');
    $this->db->where('aslab.tahunAjaran', $periode);
    $this->db->order_by('aslab.namaLengkap', 'asc');
    return $this->db->get();
  }

  function daftarInventarisLab($id)
  {
    $this->db->select('alatlab.namaAlat, sum(alatlab.jumlah) jumlah, alatlab.kondisi, alatlab.catatan');
    $this->db->from('laboratorium');
    $this->db->join('alatlab', 'laboratorium.idLab = alatlab.idLab');
    $this->db->where('substring(sha1(laboratorium.idLab), 7, 4) = "' . $id . '"');
    $this->db->group_by('alatlab.namaAlat');
    return $this->db->get();
  }

  function daftarMataKuliah()
  {
    return $this->db->order_by('kode_mk')->get('matakuliah');
  }

  function daftarAsprak()
  {
    // return $this->db->get('asprak');
    $this->db->select('asprak.nim_asprak, asprak.nama_asprak, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('daftarasprak');
    $this->db->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak');
    $this->db->join('daftar_mk', 'daftarasprak.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    return $this->db->get();
  }

  function daftarLaporanAsprak()
  {
    $this->db->select('laporan_praktikum.id_laporan_praktikum, date_format(laporan_praktikum.tanggal_upload, "%Y-%m-%d") tanggal, date_format(laporan_praktikum.tanggal_upload, "%H:%i:%s") jam, laporan_praktikum.nama_file, laporan_praktikum.catatan_revisi, laporan_praktikum.status_laporan, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('laporan_praktikum');
    $this->db->join('daftar_mk', 'laporan_praktikum.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->order_by('laporan_praktikum.status_laporan', 'asc');
    return $this->db->get();
  }

  function daftarLaporanAsprak_Tahun_MK($id_ta, $kode_mk)
  {
    $this->db->select('laporan_praktikum.id_laporan_praktikum, date_format(laporan_praktikum.tanggal_upload, "%Y-%m-%d") tanggal, date_format(laporan_praktikum.tanggal_upload, "%H:%i:%s") jam, laporan_praktikum.nama_file, laporan_praktikum.catatan_revisi, laporan_praktikum.status_laporan, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('laporan_praktikum');
    $this->db->join('daftar_mk', 'laporan_praktikum.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->where('daftar_mk.id_ta', $id_ta);
    $this->db->where('daftar_mk.kode_mk', $kode_mk);
    $this->db->order_by('laporan_praktikum.status_laporan', 'asc');
    return $this->db->get();
  }

  function daftarLaporanAsprak_Tahun($id_ta)
  {
    $this->db->select('laporan_praktikum.id_laporan_praktikum, date_format(laporan_praktikum.tanggal_upload, "%Y-%m-%d") tanggal, date_format(laporan_praktikum.tanggal_upload, "%H:%i:%s") jam, laporan_praktikum.nama_file, laporan_praktikum.catatan_revisi, laporan_praktikum.status_laporan, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('laporan_praktikum');
    $this->db->join('daftar_mk', 'laporan_praktikum.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->where('daftar_mk.id_ta', $id_ta);
    $this->db->order_by('laporan_praktikum.status_laporan', 'asc');
    return $this->db->get();
  }

  function daftarAslab($tahun)
  {
    return $this->db->order_by('namaLengkap', 'asc')->get_where('aslab', array('tahunAjaran' => $tahun));
  }

  function daftarPJAslab()
  {
    $this->db->select('laboratorium.namaLab, asistenlab.idAslab');
    $this->db->from('laboratorium');
    $this->db->join('asistenlab', 'laboratorium.idLab = asistenlab.idLab');
    return $this->db->get();
  }

  function kegiatanAslab($id)
  {
    $this->db->select('idJurnal, date_format(aslabMasuk, "%Y-%m-%d") aslabMasuk, date_format(aslabMasuk, "%H:%i") masuk, if (aslabKeluar, date_format(aslabKeluar, "%H:%i"), "-") keluar, jurnal');
    $this->db->from('jurnalaslab');
    $this->db->where('substring(sha1(idAslab), 7, 4) = "' . $id . '"');
    $this->db->order_by('aslabMasuk', 'desc');
    return $this->db->get();
  }

  function kegiatanAslabBulan($id, $periode)
  {
    $this->db->select('idJurnal, date_format(aslabMasuk, "%Y-%m-%d") aslabMasuk, date_format(aslabMasuk, "%H:%i") masuk, if (aslabKeluar, date_format(aslabKeluar, "%H:%i"), "-") keluar, jurnal');
    $this->db->from('jurnalaslab');
    $this->db->where('substring(sha1(idAslab), 7, 4) = "' . $id . '"');
    $this->db->where($periode);
    $this->db->order_by('aslabMasuk', 'desc');
    return $this->db->get();
  }

  function detailAslab($id)
  {
    $this->db->where('substring(sha1(idAslab), 7, 4) = "' . $id . '"');
    return $this->db->get('aslab');
  }

  function detailPJAslab($id)
  {
    $this->db->select('laboratorium.namaLab, laboratorium.idLab, substring(sha1(asistenlab.idAslab), 7, 4) idAslab, asistenlab.idLab');
    $this->db->from('laboratorium');
    $this->db->join('asistenlab', 'laboratorium.idLab = asistenlab.idLab');
    $this->db->where('substring(sha1(asistenlab.idAslab), 7, 4) = "' . $id . '"');
    return $this->db->get();
  }

  function jadwalLab()
  {
    $this->db->select('concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke, prodi.color');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('prodi', 'jadwal_lab.id_prodi = prodi.id_prodi');
    return $this->db->get();
  }

  function jadwalPerLab($id)
  {
    $this->db->select('concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke, prodi.color');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('prodi', 'jadwal_lab.id_prodi = prodi.id_prodi');
    $this->db->where('substring(sha1(jadwal_lab.id_lab), 7, 4) = "' . $id . '"');
    return $this->db->get();
  }

  function daftarInventaris()
  {
    // $this->db->select('alatlab.idAlat, alatlab.namaAlat, laboratorium.namaLab');
    // $this->db->from('alatlab');
    // $this->db->from('laboratorium', 'alatlab.idLab = laboratorium.idLab');
    // $this->db->order_by('alatlab.namaAlat');
    // return $this->db->get();
    $data = $this->db->query("select a.idAlat, a.namaAlat, b.namaLab from alatlab a join laboratorium b on a.idLab = b.idLab order by a.namaAlat");
    return $data;
  }

  function peminjamanAlat()
  {
    $this->db->select('peminjamanalat.idPinjamAlat, peminjamanalat.namaPeminjam, alatlab.namaAlat, peminjamanalat.alasan, peminjamanalat.tglPinjam, peminjamanalat.tglKembali, peminjamanalat.catatan, peminjamanalat.status');
    $this->db->from('peminjamanalat');
    $this->db->join('alatlab', 'peminjamanalat.idAlat = alatlab.idAlat');
    $this->db->order_by('peminjamanalat.status');
    $this->db->order_by('peminjamanalat.tglPinjam', 'desc');
    return $this->db->get();
  }

  function detailPeminjamanAlat($id)
  {
    $this->db->where('substring(sha1(idPinjamAlat), 7, 4) = "' . $id . '"');
    return $this->db->get('peminjamanalat');
  }

  function peminjamanLab()
  {
    $this->db->select('peminjamanlab.idPinjamLab, laboratorium.namaLab, peminjamanlab.namaPeminjam, peminjamanlab.alasan, peminjamanlab.tglPinjam, peminjamanlab.tglKembali, peminjamanlab.catatan, peminjamanlab.status');
    $this->db->from('peminjamanlab');
    $this->db->join('laboratorium', 'peminjamanlab.idLab = laboratorium.idLab');
    $this->db->order_by('peminjamanlab.status');
    $this->db->order_by('peminjamanlab.tglPinjam', 'desc');
    return $this->db->get();
  }

  function detailPeminjamanLab($id)
  {
    $this->db->where('substring(sha1(idPinjamLab), 7, 4) = "' . $id . '"');
    return $this->db->get('peminjamanlab');
  }

  function daftarKomplain()
  {
    $this->db->select('komplain.idKomplain, komplain.tglKomplain, komplain.tglDiatasi, laboratorium.namaLab, komplain.namaAlat, komplain.jenisInforman, komplain.catatanKomplain, komplain.solusi, komplain.diperbaikiOleh');
    $this->db->from('komplain');
    $this->db->join('laboratorium', 'komplain.idLab = laboratorium.idLab');
    $this->db->order_by('komplain.statusKomplain', 'asc');
    $this->db->order_by('komplain.tglKomplain', 'desc');
    return $this->db->get();
  }

  function detailKomplain($id)
  {
    $this->db->where('substring(sha1(idKomplain), 7, 4) = "' . $id . '"');
    return $this->db->get('komplain');
  }

  function laporanAslab($id)
  {
    $this->db->select('laporan_aslab.id_laporan_aslab, date_format(laporan_aslab.tanggal_upload, "%Y-%m-%d") tanggal_upload, laporan_aslab.nama_file, laporan_aslab.catatan_revisi, laporan_aslab.status_laporan, laboratorium.namaLab');
    $this->db->from('laporan_aslab');
    $this->db->join('laboratorium', 'laporan_aslab.id_lab = laboratorium.idLab');
    $this->db->join('aslab', 'laporan_aslab.id_aslab = aslab.idAslab');
    $this->db->where('laporan_aslab.id_aslab', $id);
    return $this->db->get();
  }

  function daftarPeriode()
  {
    return $this->db->get('tahun_ajaran');
  }

  function daftarTarif()
  {
    return $this->db->get('tarif');
  }

  function akunDosen($id)
  {
    return $this->db->get_where('users', array('idUser' => $id));
  }

  function profilAslab($id)
  {
    return $this->db->get_where('aslab', array('idAslab' => $id));
  }

  function akunAslab($id)
  {
    return $this->db->get_where('users', array('idAslab' => $id));
  }

  function daftarBAP($id_dosen, $id_daftar_mk)
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, asprak.nim_asprak, asprak.nama_asprak, LEFT(periode.rentang_akhir, 2) bulan');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('asprak', 'honor.nim_asprak = asprak.nim_asprak');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->where('honor.id_dosen', $id_dosen);
    $this->db->where('honor.approve_dosen', '0');
    $this->db->where('daftar_mk.id_daftar_mk', $id_daftar_mk);
    return $this->db->get();
  }

  function previewBAPAsprak($nim, $id_daftar_mk, $between)
  {
    $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot, presensi_asprak.video, presensi_asprak.approve_absen, asprak.ttd_asprak');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk');
    $this->db->join('asprak', 'presensi_asprak.nim_asprak = asprak.nim_asprak');
    $this->db->where('presensi_asprak.nim_asprak', $nim);
    $this->db->where('daftar_mk.id_daftar_mk', $id_daftar_mk);
    $this->db->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $between);
    $this->db->order_by('tanggal', 'asc');
    return $this->db->get();
  }

  function tampilProdiBAP($id)
  {
    $this->db->select('prodi.strata, prodi.nama_prodi, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi');
    $this->db->where('honor.id_daftar_mk', $id);
    return $this->db->get();
  }

  function daftarProdi()
  {
    return $this->db->get('prodi');
  }

  function daftarLaboran()
  {
    return $this->db->get('laboran');
  }

  function daftarPertanggungan()
  {
    // return $this->db->select('pk.no_pk, left(pk.no_pk, 2) kode_pk, pk.kode_prodi, periode.bulan, pk.total, pk.tanggal_pengajuan, pk.tanggal_cair, pk.status_pk')->from('pk')->join('periode', 'pk.id_periode = periode.id_periode')->order_by('pk.no_pk', 'desc')->get();
    return $this->db->query('select pk.no_pk, left(pk.no_pk, 2) kode_pk, pk.kode_prodi, periode.bulan, pk.total, pk.tanggal_pengajuan, pk.tanggal_cair, pk.status_pk from pk join periode on pk.id_periode = periode.id_periode order by pk.no_pk desc');
  }

  function daftarPengambilanHonorAsprak()
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, asprak.nim_asprak, asprak.nama_asprak, asprak.norek_asprak, asprak.linkaja_asprak, periode.bulan, honor.nominal, honor.opsi_pengambilan, honor.status');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('asprak', 'honor.nim_asprak = asprak.nim_asprak');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->where('honor.status != "0"');
    $this->db->order_by('honor.status', 'asc');
    $this->db->order_by('honor.id_honor', 'desc');
    return $this->db->get();
  }

  function daftarPengambilanHonorAslab()
  {
    $this->db->select('honor_aslab.id_honor_aslab, honor_aslab.nominal, honor_aslab.opsi_pengambilan, aslab.nim, aslab.namaLengkap, periode.bulan');
    $this->db->from('honor_aslab');
    $this->db->join('aslab', 'honor_aslab.id_aslab = aslab.idAslab');
    $this->db->join('periode', 'honor_aslab.id_periode = periode.id_periode');
    $this->db->order_by('honor_aslab.id_honor_aslab', 'desc');
    return $this->db->get();
  }

  function daftarHonorAslab($id)
  {
    $this->db->select('honor_aslab.id_honor_aslab, honor_aslab.jam, honor_aslab.nominal, honor_aslab.status_honor, honor_aslab.opsi_pengambilan, aslab.nim, aslab.namaLengkap, periode.bulan, tahun_ajaran.ta');
    $this->db->from('honor_aslab');
    $this->db->join('aslab', 'honor_aslab.id_aslab = aslab.idAslab');
    $this->db->join('periode', 'honor_aslab.id_periode = periode.id_periode');
    $this->db->join('tahun_ajaran', 'honor_aslab.id_ta = tahun_ajaran.id_ta');
    $this->db->where('honor_aslab.id_aslab', $id);
    return $this->db->get();
  }
}
