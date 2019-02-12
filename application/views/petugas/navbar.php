<?php
$method = $this->router->fetch_method();
if ($this->session->userdata('logged_in')['akses'] == '3') {
  $menu = $this->uri->segment(2, 0);
}elseif ($this->session->userdata('logged_in')['akses'] == '2') {
  $menu = $this->uri->segment(2, 0);
}elseif ($this->session->userdata('logged_in')['akses'] == '1') {
  $menu = $this->uri->segment(2, 0);
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width: 40px" > KLINIK DU'A</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">




    <?php
    if ($this->session->userdata('logged_in')['akses'] == '1') { ?>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?=($menu == 'dashboard') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Admin/dashboard">Dashboard</a>
      </li>
      <li class="nav-item <?=($menu == 'daftar_pasien') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Admin/pasien">Daftar Pasien</a>
      </li>
      <li class="nav-item <?=($menu == 'daftar_dokter') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Admin/dokter">Daftar Dokter</a>
      </li>
      <li class="nav-item <?=($menu == 'verifikasi') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Admin/verifikasi">Verifikasi</a>
      </li>
    </ul>





    <?php
    }elseif ($this->session->userdata('logged_in')['akses'] == '2') {?>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($menu == 'antrian'){echo 'active'; }else{echo '';}?>   ">
        <a class="nav-link" href="<?php echo base_url()?>Dokter/antrian">Antrian</a>
      </li>
      <li class="nav-item <?php if($menu == 'logistik'){echo 'active'; }else{echo '';}?>   ">
        <a class="nav-link" href="<?php echo base_url()?>Dokter/logistik_obat_oral">Logistik obat oral</a>
      </li>
      <li class="nav-item <?php if($menu == 'cariPasien') {echo 'active';}else{ echo '';}?>">
        <a class="nav-link" href="<?php echo base_url()?>Dokter/cariPasien">Cari Pasien</a>
      </li>
    </ul>





    <?php 
    }elseif ($this->session->userdata('logged_in')['akses'] == '3') { ?>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?=($menu == 'antrian') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Petugas/antrian">Antrian</a>
      </li>
      <li class="nav-item <?=($menu == 'cari') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Petugas/cari">Tambah Antrian</a>
      </li>
      <li class="nav-item <?=($menu == 'pendaftaran') ? 'active' : ''?>">
        <a class="nav-link" href="<?php echo base_url()?>Petugas/pendaftaran">Pendaftaran</a>
      </li>
    </ul>









    <?php } 
    if ($this->session->userdata('logged_in') !== array()) { ?>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url()?>Account/logout/"><?=$this->session->userdata('logged_in')['nama_user']?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url()?>Account/logout/">Sign Out</a>
      </li>
    </ul>
  <?php } ?>
  </div>
</nav>