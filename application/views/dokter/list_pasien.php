<div class="mt-3" style="width: 90%; margin-left: 5% ">
    <div class="mt-3 mb-3">
        <?=$this->session->flashdata("alert");?>
    </div>
    <table id="tabel-list-pasien" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Nomor Pasien</th>
                <th>Pembayaran</th>
                <th>Nama</th>
                <th>TTL</th>
                <th>Usia</th>
                <th>Alamat</th>
                <th>Tanggal datang</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pasien as $key => $value) { ?>
                <tr >
                    <td><?=$value->nomor_pasien?></td>
                    <td><?=$value->pembayaran?></td>
                    <td><?=$value->nama?></td>
                    <td><?=$value->tempat_lahir.", ".date('d M Y',strtotime($value->tanggal_lahir))?></td>
                    <td><?=$value->usia?></td>
                    <td>
                        <?php 
                        echo $value->jalan." ";


                        if ($value->kelurahan !== '013 Lain-lain') {
                            echo "Kelurahan ".substr($value->kelurahan, 3)." ";
                        }else{
                            if ($value->kelurahan_lain !== null) {
                                echo "Kelurahan ".$value->kelurahan_lain." ";
                            }else{
                                echo " ";
                            }
                        }

                        if ($value->kecamatan !== 'other') {
                            echo "Kecamatan ".$value->kecamatan." ";
                        }else{
                            if ($value->kecamatan_lain !== null) {
                                echo "Kecamatan ".$value->kecamatan_lain." ";
                            }else{
                                echo " ";
                            }
                        }
                        
                        if ($value->kota !== 'other') {
                            echo $value->kota." ";
                        }else{
                            echo $value->kota_lain." ";
                        }

                        ?>
                    </td>
                    <td><?=date('d M y',strtotime($value->tanggal_datang))?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="<?=base_url()?>detail-rekam-medis-pasien/<?=$value->id?>" class="btn btn-success">RM</a>
                            <a href="<?=base_url()?>edit-identitas-pasien/<?=$value->id?>" class="btn btn-primary">Edit</a>
                            <a href="<?=base_url()?>hapus-pasien/<?=$value->id?>" class="btn btn-secondary">Hapus</a>
                        </div>
                    </td>
                </tr>

            <?php }
            ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tabel-list-pasien').DataTable({
                stateSave: true,
                dom: 'Bfrtip',
                columnDefs: [
                {
                    orderable: false,
                    targets: []
                }
                ],
                buttons: [
                {
                    extend : 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6]
                    }
                }
                ]
            });
        } );
    </script>
</div>