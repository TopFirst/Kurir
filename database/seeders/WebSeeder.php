<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use App\Models\web_about;
use App\Models\web_general_info;
use App\Models\web_layanan;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(web_general_info::count()==0)
        {
            $wbi = web_general_info::create([
                'nama' => 'Aok Sinergi',
                'hp1' => '6285668190996',
                'hp2' => '6285668190996',
                'email1' => 'topik@aoksinergi.com',
                'email2' => 'contact@aoksinergi.com',
                'alamat1' => 'Buana Bukit Permata,',
                'alamat2' => 'Tembesi - Batam',
                'url_logo' => 'uploads/AOK_KURIR.png',
                'fb' => 'aoksinergi',
                'twitter' => 'aoksinergi',
                'ig' => 'aoksinergi',
                'yt' => 'aoksinergi'
                ]);
        }


        //seed layanan
       if(web_layanan::count()==0)
        {
            $services = [
                //layanan
                ['nama'=>'Pengiriman Cepat','sub_judul'=>'','tipe'=>'layanan','url_logo'=>'uploads/clock64.png','desc'=>'Pengiriman dengan durasi maksimal 24 jam untuk setiap paket baju, dokumen, boneka, dll.'],
                ['nama'=>'Harga Kompetitif','sub_judul'=>'','tipe'=>'layanan','url_logo'=>'uploads/best-price.png','desc'=>'Harga pengiriman standar untuk seluruh area batam, hanya Rp 10.000,-'],
                ['nama'=>'Terpercaya','sub_judul'=>'','tipe'=>'layanan','url_logo'=>'uploads/guarantee.png','desc'=>'Aok kurir telah dipercaya banyak online shop dan pelaku UMKM untuk mengirimkan berbagai jenis paket di seluruh area Batam.'],
                //gallery
                ['nama'=>'Foto1','sub_judul'=>'','tipe'=>'gallery','url_logo'=>'uploads/slider1.jpg','desc'=>''],
                ['nama'=>'Foto2','sub_judul'=>'','tipe'=>'gallery','url_logo'=>'uploads/slider2.jpg','desc'=>''],
                ['nama'=>'Foto3','sub_judul'=>'','tipe'=>'gallery','url_logo'=>'uploads/slider3.jpg','desc'=>''],
                ['nama'=>'Foto4','sub_judul'=>'','tipe'=>'gallery','url_logo'=>'uploads/slider4.jpg','desc'=>''],
                ['nama'=>'Foto5','sub_judul'=>'','tipe'=>'gallery','url_logo'=>'uploads/slider5.jpg','desc'=>''],
                //testimoni
                ['nama'=>'Andi Putri Pratiwi','sub_judul'=>'Akuntan','tipe'=>'testimoni','url_logo'=>'uploads/testimonial1.jpg','desc'=>'Jasa kurir batam paling aman!'],
                ['nama'=>'Mark Spenser','sub_judul'=>'HR Manager','tipe'=>'testimoni','url_logo'=>'uploads/testimonial2.jpg','desc'=>'Terima kasih Aok kurir, good job!'],
                ['nama'=>'Siti Tanjung','sub_judul'=>'Senior Engineer','tipe'=>'testimoni','url_logo'=>'uploads/testimonial3.jpg','desc'=>'Sistem talangan membuat nyaman! terima kasih Aok kurir'],
                ['nama'=>'Ahmad Tabuki','sub_judul'=>'Product Analyst','tipe'=>'testimoni','url_logo'=>'uploads/testimonial4.jpg','desc'=>'Mantap! pasti order ulang disini.'],
                ['nama'=>'Putra Teripang','sub_judul'=>'QA Manager','tipe'=>'testimoni','url_logo'=>'uploads/testimonial5.jpg','desc'=>'Kurir ramah, terima kasih Aok kurir!'],
                //client logo            
                ['nama'=>'deloit','sub_judul'=>'','tipe'=>'client','url_logo'=>'uploads/deloit.svg','desc'=>'Lorem ipsum dolor sit amet, pretium pretium tempor.Lorem ipsum16'],
                ['nama'=>'erricson','sub_judul'=>'','tipe'=>'client','url_logo'=>'uploads/erricson.svg','desc'=>'Lorem ipsum dolor sit amet, pretium pretium tempor.Lorem ipsum16'],
                ['nama'=>'netflix','sub_judul'=>'','tipe'=>'client','url_logo'=>'uploads/netflix.svg','desc'=>'Lorem ipsum dolor sit amet, pretium pretium tempor.Lorem ipsum16'],
                ['nama'=>'instagram','sub_judul'=>'','tipe'=>'client','url_logo'=>'uploads/instagram.svg','desc'=>'Lorem ipsum dolor sit amet, pretium pretium tempor.Lorem ipsum16'],
                ['nama'=>'coinbase','sub_judul'=>'','tipe'=>'client','url_logo'=>'uploads/coinbase.svg','desc'=>'Lorem ipsum dolor sit amet, pretium pretium tempor.Lorem ipsum16'],
                //contact logo            
                ['nama'=>'Hubungi Kami','sub_judul'=>'','tipe'=>'contact','url_logo'=>'uploads/contact.jpg','desc'=>'Untuk informasi & pertanyaan, hubungi kami sekarang'],
                //Web Top Info
                ['nama'=>'Cepat & Diandalkan','sub_judul'=>'<b>Jasa Pengiriman Lokal</b> Aok Kurir','tipe'=>'top_info','url_logo'=>'uploads/kurir.png',
                'desc'=>'<p>Aok Kurir selalu memberikan yang terbaik untuk semua customer kami.</p><p>Tetap semangat walaupun kondisi cuaca sedang tidak mendukung untuk mengantarkan paket.</p>'],
                //about gambar            
                ['nama'=>'Tentang Kami','sub_judul'=>'Jasa Pengiriman Lokal Terbaik','tipe'=>'about','url_logo'=>'uploads/kurir_400.png',
                'desc'=>'Aok Kurir adalah jasa pengiriman lokal batam terbaik sejak 2017. Saat ini telah melengkapi armada pengiriman yang menjangkau seluruh wilayah batam. Aok kurir juga telah dipercaya oleh banyak online shop dan pelaku UMKM Batam sebagai mitra terbaik untuk memastikan paket mereka sampai ditangan pelanggan.'],
                //Testimoni Head            
                ['nama'=>'Testimonial','sub_judul'=>'Kepercayaan adalah <br>harta terbaik','tipe'=>'testimoni_head','url_logo'=>'','desc'=>''],
                
            ];
            foreach ($services as $service) {
                web_layanan::create(['nama' => $service['nama'],'sub_judul' => $service['sub_judul'],'tipe' => $service['tipe'],'url_logo'=>$service['url_logo'],'desc' => $service['desc']]);
        }
        }
       //seed about
       if(web_about::count()==0)
        {
            $wa = web_about::create([
                'judul' => 'Proses Kerja',
                'subjudul1' => 'Pelajari mudahnya cara kami bekerja!',
                'subjudul2' => 'Kemudahan membawa kepuasan',
                'url_logo' => 'idea.png',
                'desc' => 'Lorem ipsum dolor sit amet,<br/>pretium pretium tempor.Lorem ipsum dolor sit amet, consectetur',
                'option1' => 'Lorem ipsum dolor sit amet, pretium pretium1',
                'option2' => 'Lorem ipsum dolor sit amet, pretium pretium2',
                'option3' => 'Lorem ipsum dolor sit amet, pretium pretium3'
                ]);
        }
       //seed application config
       if (!AppConfig::where('slug','pendapatan-owner')->exists()) {
        $ac = AppConfig::create([
            'slug' => 'pendapatan-owner',
            'parameter_name' => 'Pendapatan Owner',
            'parameter_value' => '2',
            'parameter_unit' => 'Rb',
            ]);
        }
       
        if (!AppConfig::where('slug','default-ongkir')->exists()) {
            $default_ongkir = AppConfig::create([
                'slug' => 'default-ongkir',
                'parameter_name' => 'Ongkir Dasar',
                'parameter_value' => '10',
                'parameter_unit' => 'Rb',
                ]);
         }
        if (!AppConfig::where('slug','cut-off-time')->exists()) {
            $default_ongkir = AppConfig::create([
                'slug' => 'cut-off-time',
                'parameter_name' => 'Cut-off Transaksi',
                'parameter_value' => '24',
                'parameter_unit' => 'Jam',
                ]);
         }

    }
}
