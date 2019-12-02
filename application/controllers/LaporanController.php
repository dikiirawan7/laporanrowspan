<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\Reader\ReaderInterface;
use PhpOffice\PhpWord\Writer\WriterInterface;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Dompdf\Dompdf;


class LaporanController extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('word');
    }

    public function index(){
        $data['kelamin']= $this->db->select('nama,jkl,COUNT(jkl) as count',false)->from('ktp')->group_by('jkl')->get()->result();
       
        echo json_encode($data);
    }
    public function latih()
    {
        $this->db->distinct('jkl');
        $this->db->select('*');
         $this->db->from('ktp');
        $data=$this->db->get()->result();

        echo json_encode($data);
    }

    public function laporanku()
    {
        $data['kelamin']= $this->db->select('jkl,COUNT(jkl) as count',false)->from('ktp')->group_by('jkl')->order_by('id','desc')->get()->result();
        $data['semua']= $this->db->order_by('id','desc')->get('ktp')->result();

        $this->load->view('laporan',$data);
    }

    public function lihat()
    {
        $data['semua']= $this->db->order_by('id','desc')->get('ktp')->result();
        $this->load->view('laporan',$data);
    }

    public function mengerti()
    {
        //ini ada where bulan
        $data['kelamin']= $this->db->select("A.*,(Select COUNT(jkl) from ktp where jkl=A.jkl) as jumlah from ktp A where A.bulan='januari' order by A.jkl",false)->get()->result();
        $this->load->view('laporan',$data);
    }
    public function pentingrowspan()
    {
        $data['kelamin']= $this->db->select('A.*,(Select COUNT(jkl) from ktp where jkl=A.jkl) as jumlah from ktp A order by A.jkl',false)->get()->result();
        echo json_encode($data);
    }

    public function mengertidua()
    {
        //ini hanya ada order by
        $data['kelamin']= $this->db->select("A.*,(Select COUNT(jkl) from ktp where jkl=A.jkl) as jumlah from ktp A order by A.jkl",false)->get()->result();
        $this->load->view('laporan',$data);
    }

    public function phpof(){
       
        $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');
    
    
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="file.xlsx"');
    $writer->save("php://output");

    }

    public function baca(){
        $inputFileType = 'Xlsx';
        $inputFileName = 'folder/format.xlsx';

        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Advise the Reader to load all Worksheets  **/
        $reader->setLoadAllSheets();
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        
        $writer->save("folder/oke.pdf");
        //$mpdf = new \Mpdf\Mpdf();
        //$mpdf->Output('folder/oke.pdf', 'F');


        
        }

    public function bacaword(){
        $inputFileType = 'Word2007';
        $inputFileName = 'folder/coba.docx';


        //$reader = \PhpOffice\PhpWord\IOFactory::createReader($inputFileType);
        //$spreadsheet= $reader->load($inputFileName);
        
        //create pdf// kesalahan disini karena mpdf itu milik phpspreadsheet, bukan phpword
        //$pdfWriter = PHPWord_IOFactory::createWriter($spreadsheet , 'PDF');
        //$pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($spreadsheet , 'PDF');
            
        //$pdfWriter->save("apaaja.pdf");
        //$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter( $spreadsheet, 'HTML');
        //$objWriter->save('helloWorld.pdf');
        //$phpWord = \PhpOffice\PhpWord\IOFactory::load('folder/coba.docx');
        //$htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
        //$htmlWriter->save('test.html');

        //harus require dompdf dulu
        //ini belum berhasil untuk convert docx to pdf kalau ada file gambar didalamnya
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        // Any writable directory here. It will be ignored.
        Settings::setPdfRendererPath('.');

        $phpWord = IOFactory::load($inputFileName, 'Word2007');
        $phpWord->save('folder/lain.pdf', 'PDF');

        //ini bisa asal gambar di dalam file tipe jpg,png
       // \PhpOffice\PhpWord\Settings::setPdfRendererPath('.');
       // \PhpOffice\PhpWord\Settings::setPdfRendererName('MPDF');
       // $phpWord = \PhpOffice\PhpWord\IOFactory::load($inputFileName);
       // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
       // $xmlWriter->save('result.pdf');  
        
    }

    public function docxpdf(){

        Gears\Pdf::convert('/folder/coba.docx', 'folder/coba.pdf');
    }

}

?>