<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script type="text/javascript" src="<?php echo base_url('assets/jquery.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.5')?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fancybox/source/jquery.fancybox.css?v=2.1.5')?>" media="screen" />
</head>
<body>
        <table border="1">
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Kelamin</td>

            </tr>
           <?php 
           $no=1;
           $jum=1;
           foreach($kelamin as $key){
           ?>
            <tr>
            <?php if($jum<=1){?>
            <td rowspan="<?php echo $key->jumlah?>"><?php echo $no++?></td>
            <td rowspan="<?php echo $key->jumlah?>"><?php echo $key->jkl?></td>
            <?php 
            $jum= $key->jumlah;
            }
            else{
                $jum = $jum - 1;
            }
            ?>
            <td><?php echo $key->nama?></td>
           </tr>
           <?php
                }    
                ?>
     


        </table>
        <a class='word' href="https://view.officeapps.live.com/op/view.aspx?src=https%3A%2F%2Fpaginingajax.000webhostapp.com%2Ffolder%2Fcoba.docx" >Coba preview</a>
        <a class='word' href="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url("folder/coba.docx");?>" >Coba preview</a>
        <a class='word' href="https://docs.google.com/viewer?url=https%3A%2F%2Fpaginingajax.000webhostapp.com%2Ffolder%2Fcoba.docx" >Coba dua</a>
        <a class='word' href="https://docs.google.com/viewerng/viewer?url=http%3A%2F%2Flocalhost%2Flaporanrowspan%2Ffolder%2Fcobadua.doc" >Coba dua</a>
        <a class="fancybox" href="https://view.officeapps.live.com/op/view.aspx?src=https%3A%2F%2Fpaginingajax.000webhostapp.com%2Ffolder%2Fcoba.docx">Open pdf</a>
        <a class="fancybox" href="https://view.officeapps.live.com/op/view.aspx?src=https%3A%2F%2Fpaginingajax.000webhostapp.com%2Ffolder%2Fformat.xlsx">Open xlsx</a>
        <a class="word" href="<?php echo base_url('assets/pdfjs/web/viewer.html?file=oke.pdf')?>">Open pdfjs</a>
        <a class="word" href="https://docs.google.com/viewer?url=https%3A%2F%2Fpaginingajax.000webhostapp.com%2Ffolder%2Fformat.xlsx&embedded=true">Open pdf 2</a>
</iframe>
        <h1>Tabel 2 </h1>
        <table border="1">
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Kelamin</td>

            </tr>
           <?php 
           $no=1;
           $jum=1;
           foreach($kelamin as $key){
           ?>
            <tr>
            <td><?php echo $no++?></td>
            <?php if($jum<=1){?>
            <td rowspan="<?php echo $key->jumlah?>"><?php echo $key->jkl?></td>
            <?php 
            $jum= $key->jumlah;
            }
            else{
                $jum = $jum - 1;
            }
            ?>
            <td><?php echo $key->nama?></td>
           </tr>
           <?php
                }    
                ?>
     


        </table>  
        <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http%3A%2F%2Flocalhost%2Flaporanrowspan%2Ffolder%2Fformat-laporan-pkl.docx' width='300px' height='300px' frameborder='1'>
</iframe>
        <a href="<?php echo base_url("assets/ViewerJS/#../folder/format-laporan-pkl.docx");?>">lihat</a>  
        <a href="<?php echo base_url("laporancontroller/phpof");?>">download</a>
        <button name="ubah" class="convert" href="<?php echo base_url('assets/pdfjs/web/viewer.html?file=oke.pdf')?>">Edit</button>
        <button onClick="klik_pdf()">Klik Pdf</button>
        
        <div class="oke">
        </div>
        <div class="oo">
        </div>
            <script>
            function klik_pdf(){
                var filenya= '<?php echo base_url("folder/Document1.pdf");?>';
                pdfjsLib.getDocument(filenya);
            }
            $(document).ready(function() {
                var ook= '<?php echo base_url("folder/format-laporan-pkl.docx");?>';
                var encodedUrl = encodeURIComponent('https://paginingajax.000webhostapp.com/folder/format-laporan-pkl.docx');
                var iFrameUrl = 'https://view.officeapps.live.com/op/view.aspx?src=' + encodedUrl;
                $('.fancybox').attr("href", iFrameUrl);
             

                $('.oke').text(iFrameUrl);
                $('.oo').text(ook);

                $(".fancybox").fancybox({
                    width  : 600,
                    height : 300,
                    type   :'iframe'
                });
                $(".word").fancybox({
                    width  : 600,
                    height : 300,
                    type   :'iframe'
                });

                
                $('.convert').click(function(e){
                e.preventDefault();
                $.ajax({
					url:"<?php echo base_url('laporancontroller/baca')?>",
					type:'GET',
					success:function(){
						$('.fancybox').attr("href", iFrameUrl);
							
					},
						error:function(jqXHR,textStatus,errorThrown){
							alert('gagal add atau update');
						}
				});
                });
               
                }); 
            </script>
</body>
</html>