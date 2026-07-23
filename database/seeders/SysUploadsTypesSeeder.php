<?php


  namespace Database\Seeders;

  
  use Illuminate\Database\Seeder;


  use App\Models\SysUploadsType;



  class SysUploadsTypesSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {


      $types = [

        
        // [

        //   'tbl_sys_uploads_type_icon'        => '',
        //   'tbl_sys_uploads_type_mine'        => '',
        //   'tbl_sys_uploads_type_name'        => '',
        //   'tbl_sys_uploads_type_title'       => '',
        //   'tbl_sys_uploads_type_description' => "",
        //   'tbl_sys_uploads_type_locked'      => true,
        
        // ],
        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/png',
          'tbl_sys_uploads_type_name'        => 'png',
          'tbl_sys_uploads_type_title'       => 'Imagem PNG',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem no formato PNG.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/jpeg',
          'tbl_sys_uploads_type_name'        => 'jpg',
          'tbl_sys_uploads_type_title'       => 'Imagem JPG',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem no formato JPG.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/jpeg',
          'tbl_sys_uploads_type_name'        => 'jpeg',
          'tbl_sys_uploads_type_title'       => 'Imagem JPEG',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem no formato JPEG.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/gif',
          'tbl_sys_uploads_type_name'        => 'gif',
          'tbl_sys_uploads_type_title'       => 'Imagem GIF',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem no formato GIF.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/webp',
          'tbl_sys_uploads_type_name'        => 'webp',
          'tbl_sys_uploads_type_title'       => 'Imagem WEBP',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem no formato WEBP.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/bmp',
          'tbl_sys_uploads_type_name'        => 'bmp',
          'tbl_sys_uploads_type_title'       => 'Imagem BMP',
          'tbl_sys_uploads_type_description' => 'Arquivo de imagem Bitmap.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-image',
          'tbl_sys_uploads_type_mine'        => 'image/svg+xml',
          'tbl_sys_uploads_type_name'        => 'svg',
          'tbl_sys_uploads_type_title'       => 'Imagem SVG',
          'tbl_sys_uploads_type_description' => 'Imagem vetorial SVG.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-pdf',
          'tbl_sys_uploads_type_mine'        => 'application/pdf',
          'tbl_sys_uploads_type_name'        => 'pdf',
          'tbl_sys_uploads_type_title'       => 'Documento PDF',
          'tbl_sys_uploads_type_description' => 'Documento Adobe PDF.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-word',
          'tbl_sys_uploads_type_mine'        => 'application/msword',
          'tbl_sys_uploads_type_name'        => 'doc',
          'tbl_sys_uploads_type_title'       => 'Documento Word',
          'tbl_sys_uploads_type_description' => 'Documento Microsoft Word.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-word',
          'tbl_sys_uploads_type_mine'        => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
          'tbl_sys_uploads_type_name'        => 'docx',
          'tbl_sys_uploads_type_title'       => 'Documento Word DOCX',
          'tbl_sys_uploads_type_description' => 'Documento Microsoft Word OpenXML.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-excel',
          'tbl_sys_uploads_type_mine'        => 'application/vnd.ms-excel',
          'tbl_sys_uploads_type_name'        => 'xls',
          'tbl_sys_uploads_type_title'       => 'Planilha Excel',
          'tbl_sys_uploads_type_description' => 'Planilha Microsoft Excel.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-excel',
          'tbl_sys_uploads_type_mine'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          'tbl_sys_uploads_type_name'        => 'xlsx',
          'tbl_sys_uploads_type_title'       => 'Planilha Excel XLSX',
          'tbl_sys_uploads_type_description' => 'Planilha Microsoft Excel OpenXML.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-csv',
          'tbl_sys_uploads_type_mine'        => 'text/csv',
          'tbl_sys_uploads_type_name'        => 'csv',
          'tbl_sys_uploads_type_title'       => 'Arquivo CSV',
          'tbl_sys_uploads_type_description' => 'Arquivo de valores separados por vírgula.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-powerpoint',
          'tbl_sys_uploads_type_mine'        => 'application/vnd.ms-powerpoint',
          'tbl_sys_uploads_type_name'        => 'ppt',
          'tbl_sys_uploads_type_title'       => 'Apresentação PowerPoint',
          'tbl_sys_uploads_type_description' => 'Apresentação Microsoft PowerPoint.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-powerpoint',
          'tbl_sys_uploads_type_mine'        => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
          'tbl_sys_uploads_type_name'        => 'pptx',
          'tbl_sys_uploads_type_title'       => 'Apresentação PowerPoint PPTX',
          'tbl_sys_uploads_type_description' => 'Apresentação Microsoft PowerPoint OpenXML.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-zipper',
          'tbl_sys_uploads_type_mine'        => 'application/zip',
          'tbl_sys_uploads_type_name'        => 'zip',
          'tbl_sys_uploads_type_title'       => 'Arquivo ZIP',
          'tbl_sys_uploads_type_description' => 'Arquivo compactado ZIP.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-zipper',
          'tbl_sys_uploads_type_mine'        => 'application/x-rar-compressed',
          'tbl_sys_uploads_type_name'        => 'rar',
          'tbl_sys_uploads_type_title'       => 'Arquivo RAR',
          'tbl_sys_uploads_type_description' => 'Arquivo compactado RAR.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-zipper',
          'tbl_sys_uploads_type_mine'        => 'application/x-7z-compressed',
          'tbl_sys_uploads_type_name'        => '7z',
          'tbl_sys_uploads_type_title'       => 'Arquivo 7Z',
          'tbl_sys_uploads_type_description' => 'Arquivo compactado 7-Zip.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-lines',
          'tbl_sys_uploads_type_mine'        => 'text/plain',
          'tbl_sys_uploads_type_name'        => 'txt',
          'tbl_sys_uploads_type_title'       => 'Arquivo TXT',
          'tbl_sys_uploads_type_description' => 'Arquivo de texto simples.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-code',
          'tbl_sys_uploads_type_mine'        => 'application/json',
          'tbl_sys_uploads_type_name'        => 'json',
          'tbl_sys_uploads_type_title'       => 'Arquivo JSON',
          'tbl_sys_uploads_type_description' => 'Arquivo de dados JSON.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-code',
          'tbl_sys_uploads_type_mine'        => 'application/xml',
          'tbl_sys_uploads_type_name'        => 'xml',
          'tbl_sys_uploads_type_title'       => 'Arquivo XML',
          'tbl_sys_uploads_type_description' => 'Arquivo XML.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-audio',
          'tbl_sys_uploads_type_mine'        => 'audio/mpeg',
          'tbl_sys_uploads_type_name'        => 'mp3',
          'tbl_sys_uploads_type_title'       => 'Áudio MP3',
          'tbl_sys_uploads_type_description' => 'Arquivo de áudio MP3.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-audio',
          'tbl_sys_uploads_type_mine'        => 'audio/wav',
          'tbl_sys_uploads_type_name'        => 'wav',
          'tbl_sys_uploads_type_title'       => 'Áudio WAV',
          'tbl_sys_uploads_type_description' => 'Arquivo de áudio WAV.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-video',
          'tbl_sys_uploads_type_mine'        => 'video/mp4',
          'tbl_sys_uploads_type_name'        => 'mp4',
          'tbl_sys_uploads_type_title'       => 'Vídeo MP4',
          'tbl_sys_uploads_type_description' => 'Arquivo de vídeo MP4.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

        [
          'tbl_sys_uploads_type_icon'        => 'file-video',
          'tbl_sys_uploads_type_mine'        => 'video/webm',
          'tbl_sys_uploads_type_name'        => 'webm',
          'tbl_sys_uploads_type_title'       => 'Vídeo WEBM',
          'tbl_sys_uploads_type_description' => 'Arquivo de vídeo WEBM.',
          'tbl_sys_uploads_type_locked'      => true,
        ],

      ];


      foreach ($types as $type) {
        
        SysUploadsType::create($type);
        
      }

      
    }



  }

