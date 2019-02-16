<style type="text/css">
.tombol-proses{
    height: 24px;
    padding-top: 1px;
}
</style>

<script type="text/javascript">
    $(document).ready(function(){    
        loadstack();
    });

    function loadstack(){
        setTimeout(loadstack, 2000);
        $.get( "<?=base_url()?>Petugas/liveAntrian", function( data ) {
            var LiveAntrian = JSON.parse(data);
            var TableContentAntrian = '';
            var TableContentProsesAntrian = '';
            if (LiveAntrian.antrian != '') {
                var nomorAntrian = 1;
                for (var i in LiveAntrian.antrian ) {
                    TableContentAntrian += "<tr><td>"+nomorAntrian+"</td><td>"+LiveAntrian.antrian[i].nama+"</td><td>"+LiveAntrian.antrian[i].jam_datang+"</td><td>"+LiveAntrian.antrian[i].pembayaran+"</td><td><div class='btn-group' role='group' aria-label='Basic example'><a href='<?=base_url()?>Petugas/submitAntrian/proses/"+LiveAntrian.antrian[i].nomor_pasien+"' class='btn btn-success btn-sm tombol-proses'>Proses</a><a href='<?=base_url()?>Petugas/submitAntrian/hapus/"+LiveAntrian.antrian[i].nomor_pasien+"' class='btn btn-danger btn-sm tombol-proses'>Hapus</a></div></td></tr>";
                    nomorAntrian++;
                }
                // console.log(TableContentAntrian);
                // console.log('exec antrian');
            }
            $("#pasienAntri").html(TableContentAntrian);

            if (LiveAntrian.proses_antrian != '') {
                var nomorProsesAntrian = 1;
                for (var i in LiveAntrian.proses_antrian ) {
                    TableContentProsesAntrian += "<tr><td>"+nomorProsesAntrian+"</td><td>"+LiveAntrian.proses_antrian[i].nama+"</td><td>"+LiveAntrian.proses_antrian[i].pembayaran+"</td><td><a href='<?=base_url()?>Petugas/submitAntrian/hapus/"+LiveAntrian.proses_antrian[i].nomor_pasien+"' class='btn btn-danger btn-sm tombol-proses'>Hapus</a></td></tr>"
                    nomorProsesAntrian++;
                }
                // console.log(TableContentProsesAntrian);
                // console.log('exec antrian P');
            }
            $("#pasienDalamProses").html(TableContentProsesAntrian);
        });
    }
</script>

<h3 class="text-center mt-3">Antrian Pasien</h3>
<div class="row">
    <div class="col">
        <?=$this->session->flashdata("alert");?>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <h5 class="text-center mt-3">Pasien Antri</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jam Datang</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="pasienAntri">
            </tbody>
        </table>
    </div>
    <div class="col-4">
        <h5 class="text-center mt-3">Pasien Dalam Proses</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="pasienDalamProses">
            </tbody>
        </table>
    </div>
</div>