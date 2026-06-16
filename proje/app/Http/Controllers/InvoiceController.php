<?php
/*
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{


    public function urun_goruntule($url) {
        $urun = DB::table('products')->where('url', $url)->where('deleted', 0)->first();

        if ($urun) {
            return view('product_view', compact('urun'));
        }else{
            abort(404);
        }
    }

    public function urun_al(Request $request, $url)
    {
        $request->validate([
            'ad' => 'required',
            'soyad' => 'required',
            'eposta' => 'required|email',
            'telefon' => 'required',
        ]);

        $urun = DB::table('products')->where('url', $url)->where('deleted', 0)->first();
        if (!$urun) {
            abort(404);
        }

        $customer=DB::table('customers')->where('email', $request->input('eposta'))->first();
        if (!$customer) {
            $customerid = DB::table('customers')->insertGetId([
                'name' => $request->input('ad'),
                'surname' => $request->input('soyad'),
                'idn' => "11111111111",
                'email' => $request->input('eposta'),
                'phone' => $request->input('telefon'),
                'address' => $request->input('adres', ''),
                'customer_type' => 1,
                'deleted' => 0,
                'notes' => "Ürün alımı sonucu oluştu."
            ]);

            if (!$customerid) {
                return redirect()->back()->with("error", "Bir sorun oluştu.");
            }
        }else{
            $customerid = $customer->id;
        }

        $body='[{"name":"'.$urun->baslik.'","quantity":"1","price":"'.$urun->fiyat.'","total":'.$urun->fiyat.'}]';

        $invoiceid=rand(0,9999999);
        $faturaid=DB::table('invoices')->insertGetId([
            'invoiceid' => $invoiceid,
            'type' => 'urun',
            'external_id' => $urun->id,
            'cid' => $customerid,
            'body' => $body,
            'note' => $urun->baslik." ürünü için oluşturulan fatura...",
            'status' => 0,
            'total' => $urun->fiyat,
            'tax_rate' => $urun->kdv,
            'created_time' => time()
        ]);

        if ($faturaid) {
            return redirect(route("fatura.show", [$faturaid, $invoiceid]));
        }else{
            return redirect()->back()->with("error", "Bir sorun oluştu.");
        }

    }

    public function fatura_data(Request $request) {
        $query = DB::table('invoices')
            ->leftJoin('customers', 'invoices.cid', '=', 'customers.id')
            ->select(
                'invoices.*',
                'customers.name',
                'customers.surname',
                'customers.email',
                'customers.phone'
            );

        $totalRecords = DB::table('invoices')->count();

        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('invoices.id', 'like', "%{$search}%")
                    ->orWhere('invoices.invoiceid', 'like', "%{$search}%")
                    ->orWhere('customers.name', 'like', "%{$search}%")
                    ->orWhere('customers.surname', 'like', "%{$search}%")
                    ->orWhere('customers.email', 'like', "%{$search}%")
                    ->orWhere('customers.phone', 'like', "%{$search}%");
            });
        }

        $filteredRecords = $query->count();

        if ($request->has('order')) {
            $columnIndex = $request->input('order.0.column');
            $columnName = $request->input("columns.{$columnIndex}.data");
            $columnOrder = $request->input('order.0.dir');

            $sortableColumns = [
                'id' => 'invoices.id',
                'musteri_adi' => 'customers.name',
                'tarih' => 'invoices.created_time',
                'tutar' => 'invoices.total',
                'durum' => 'invoices.status'
            ];

            if (array_key_exists($columnName, $sortableColumns)) {
                $query->orderBy($sortableColumns[$columnName], $columnOrder);
            }
        } else {
            $query->orderBy('invoices.id', 'desc');
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $faturalar = $query->offset($start)->limit($length)->get();


        $data = [];
        foreach ($faturalar as $fatura) {
            $durumBadge = ($fatura->status == 1)
                ? '<span class="badge bg-success">Ödendi</span>'
                : '<span class="badge bg-warning">Bekliyor</span>';

            $goruntule=route("fatura.show", [$fatura->id, $fatura->invoiceid]);
            $duzenle=route("fatura.edit", $fatura->id);
            $sil=route("fatura.sil", $fatura->id);

            if($fatura->type=="pos") {
                $tur="Sanal Pos";
            }elseif ($fatura->type=="urun") {
                $tur="Ürün";
            }else{
                $tur="Fatura";
            }


            $data[] = [
                'id'          => $fatura->id,
                'musteri_adi' => $fatura->name . " " . $fatura->surname,
                'tarih'       => date('d.m.Y H:i', $fatura->created_time + 10800),
                'tutar'       => number_format($fatura->total, 2, ',', '.') . ' ₺',
                'tur' => $tur,
                'durum'       => $durumBadge,
                'islemler'    => '<button onclick="window.open('."'$goruntule'".')" class="btn btn-sm btn-info" title="İncele"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-primary" onclick="window.location.href='."'$duzenle'".'" title="Düzenle"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="window.location.href='."'$sil'".'" title="Sil"><i class="fas fa-trash"></i></button>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data"            => $data
        ]);
    }

    public function faturalar(Request $request)
    {



        return view('invoices');
    }

    public function fatura()
    {
        $musteriler=DB::table('customers')->get();

        return view('invoice', compact('musteriler'));
    }

    public function fatura_edit($id, Request $request)
    {
        $musteriler=DB::table('customers')->get();
        $fatura=DB::table('invoices')->where('id', $id)->first();
        $musterim=$musteriler->where('id', $fatura->cid)->first();

        return view('invoice_view', compact('musteriler', 'fatura', 'musterim'));
    }

    public function fatura_show($id, $invoiceid)
    {
        $invoice=DB::table('invoices')->where('id', $id)->where('invoiceid', $invoiceid)->first();

        if (!$invoice) {
            abort(404);
        }

        $customer=DB::table('customers')->where('id', $invoice->cid)->first();

        $gateways=DB::table('gateways')->where('status', 1)->get();

        return view('payment', compact('invoice', 'customer', 'gateways'));
    }



    public function fatura_guncelle(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required',
            'notes' => 'nullable',
        ]);

        $customer_id = $request->input('customer_id');
        $musteri=DB::table('customers')->where('id', $customer_id)->first();

        if (!$musteri) {
            return redirect()->back()->with("error", "Müşteri bulunamadı.");
        }

        $body=$request->input('items');
        $total=0;
        foreach ($body as $item) {
            $son[]=[
                "name" => $item['name'],
                "quantity" => $item['quantity'],
                "price" => $item['price'],
                "total" => $item['quantity'] * $item['price'],
            ];
            $total+=$item['quantity'] * $item['price'];
        }
        $bodyson=json_encode($son);
        $tax=$request->input('tax_rate');


        $guncelle = DB::table('invoices')
            ->where('id', $id)
            ->update([
                'tax_rate'        => $tax,
                'cid'         => $customer_id,
                'body'      => $bodyson,
                'note'          => $request->input('notes'),
                'total'        => $total,
            ]);

        if ($guncelle) {
            return redirect(route('faturalar'));
        }else{
            return redirect()->back()->with('error', "Bilinmeyen bir hata oluştu.");
        }
    }

    public function fatura_sil($id, Request $request)
    {
        $customer=DB::table('invoices')->where('id',$id)->first();

        if ($customer) {
            $musteri=DB::table('invoices')->where('id',$id)->delete();
            if ($musteri) {
                return redirect(route('faturalar'));
            }else{
                return redirect()->back()->with('error', "Bilinmeyen bir hata oluştu..");
            }
        }else{
            return redirect()->back()->with('error', "Böyle bir müşteri bulunamadı.");
        }
    }

    public function fatura_store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required',
            'notes' => 'nullable',
        ]);

        $customer_id = $request->input('customer_id');
        $musteri=DB::table('customers')->where('id', $customer_id)->first();

        if (!$musteri) {
            return redirect()->back()->with("error", "Müşteri bulunamadı.");
        }

        $body=$request->input('items');
        $total=0;
        foreach ($body as $item) {
            $son[]=[
                "name" => $item['name'],
                "quantity" => $item['quantity'],
                "price" => $item['price'],
                "total" => $item['quantity'] * $item['price'],
            ];
            $total+=$item['quantity'] * $item['price'];
        }
        $bodyson=json_encode($son);
        $tax=$request->input('tax_rate');


        $olustur=DB::insert("INSERT into invoices (tax_rate, invoiceid, cid, body, note, status, total, created_time) values (?, ?,?,?,?,?,?,?)", [$tax,rand(0,9999999),$customer_id,$bodyson,$request->input('notes'),0,$total,time()]);
        if ($olustur) {
            return redirect(route('faturalar'));
        }else{
            return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu lütfen daha sonra tekrar deneyin.");
        }

    }

    public function musteri_data(Request $request) {
        $query = DB::table('customers')->where('deleted', 0);

        $totalRecords = DB::table('customers')->where('deleted', 0)->count();

        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('idn', 'like', "%{$search}%");
            });
        }

        $filteredRecords = $query->count();

        if ($request->has('order')) {
            $columnIndex = $request->input('order.0.column');
            $columnName = $request->input("columns.{$columnIndex}.data");
            $columnOrder = $request->input('order.0.dir');

            $sortableColumns = [
                'id' => 'id',
                'ad_soyad' => 'name',
                'email' => 'email',
                'telefon' => 'phone',
                'tip' => 'customer_type'
            ];

            if (array_key_exists($columnName, $sortableColumns)) {
                $query->orderBy($sortableColumns[$columnName], $columnOrder);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $musteriler = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($musteriler as $musteri) {

            if ($musteri->customer_type == 1) {
                $tipBadge = '<span class="badge" style="background-color:#4f46e5; color:white;">Bireysel</span>';
                $gosterilecekAd = $musteri->name . " " . $musteri->surname;
            } else {
                $tipBadge = '<span class="badge" style="background-color:#10b981; color:white;">Kurumsal</span>';
                $gosterilecekAd = $musteri->name . " " . $musteri->surname;
                if (!empty($musteri->company)) {
                    $gosterilecekAd .= '<br><small style="color:#a0aec0;">' . $musteri->company . '</small>';
                }
            }

            $goruntule=route('musteri.goruntule', $musteri->id);
            $duzenle=route('musteri.duzenle', $musteri->id);
            $sil=route('musteri.sil', $musteri->id);

            $data[] = [
                'id'          => $musteri->id,
                'ad_soyad'    => $gosterilecekAd,
                'email'       => $musteri->email ?? '-',
                'telefon'     => $musteri->phone ?? '-',
                'tip'         => $tipBadge,
                'islemler'    => '<button onclick="window.location.href='."'$goruntule'".'" class="btn btn-sm btn-info" title="İncele"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-primary" onclick="window.location.href='."'$duzenle'".'" title="Düzenle"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="window.location.href='."'$sil'".'" title="Sil"><i class="fas fa-trash"></i></button>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data"            => $data
        ]);
    }

    public function musteri_goruntule(Request $request, $id)
    {
        $customer=DB::table('customers')->where('id',$id)->first();

        if ($customer) {
            $goruntule=1;

            return view('customer_view', compact('customer', 'goruntule'));
        }else{
            return redirect()->back()->with('error', "Böyle bir müşteri bulunamadı.");
        }
    }

    public function musteri_sil(Request $request, $id)
    {
        $customer=DB::table('customers')->where('id',$id)->first();

        if ($customer) {
            $musteri=DB::update("update customers set deleted=1 where id='".$customer->id."'");
            if ($musteri) {
                return redirect(route('musteriler'));
            }else{
                return redirect()->back()->with('error', "Bilinmeyen bir hata oluştu..");
            }
        }else{
            return redirect()->back()->with('error', "Böyle bir müşteri bulunamadı.");
        }

    }

    public function musteri_duzenle(Request $request, $id)
    {
        $customer=DB::table('customers')->where('id',$id)->first();

        if ($customer) {

            return view('customer_view', compact('customer'));
        }else{
            return redirect()->back()->with('error', "Böyle bir müşteri bulunamadı.");
        }
    }

    public function musteriler()
    {

        return view('customers');
    }

    public function urunler(Request $request)
    {

        return view('products');
    }

    public function urun_duzenle($id)
    {
        $urun=DB::table('products')->where('id',$id)->first();

        if ($urun) {

            return view('product_edit', compact('urun'));
        }else{
            return redirect()->back()->with('error', "Böyle bir ürün bulunamadı.");
        }
    }

    public function urun_guncelle($id, Request $request)
    {
        $request->validate([
            'baslik' => 'required',
            'fiyat' => 'required',
            'url' => 'required',
            'kdv' => 'required',
            'stok' => 'required',
            'resim' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $urun = DB::table('products')->where('id', $id)->first();

        if (!$urun) {
            return redirect()->back()->with('error', "Böyle bir ürün bulunamadı.");
        }

        $resimYolu = $urun->resim;

        if ($request->hasFile('resim')) {
            if ($urun->resim && file_exists(public_path($urun->resim))) {
                unlink(public_path($urun->resim));
            }
            $dosyaAdi = time() . '.' . $request->file('resim')->getClientOriginalExtension();
            $request->file('resim')->move(public_path('storage'), $dosyaAdi);
            $resimYolu =  $dosyaAdi;
        }

        $guncelle = DB::table('products')
            ->where('id', $id)
            ->update([
                'baslik'   => $request->input('baslik'),
                'fiyat'    => $request->input('fiyat'),
                'url'      => $request->input('url'),
                'kdv'      => $request->input('kdv'),
                'stok'     => $request->input('stok'),
                'resim'    => $resimYolu,
                'aciklama' => $request->input('aciklama', ''),
                'ozellikler'=> $request->input('ozellikler', '')
            ]);

        if ($guncelle !== false) {
            return redirect(route('urunler'));
        } else {
            return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu lütfen daha sonra tekrar deneyin.");
        }
    }

    public function urun_sil(Request $request, $id)
    {
        $customer=DB::table('products')->where('id',$id)->first();

        if ($customer) {
            if ($customer->resim && file_exists(public_path($customer->resim))) {
                unlink(public_path('storage/'.$customer->resim));
            }
            $musteri=DB::update("update products set deleted=1 where id='".$customer->id."'");
            if ($musteri) {
                return redirect(route('urunler'));
            }else{
                return redirect()->back()->with('error', "Bilinmeyen bir hata oluştu..");
            }
        }else{
            return redirect()->back()->with('error', "Böyle bir ürün bulunamadı.");
        }

    }

    public function urun_ekle(Request $request)
    {
        return view('product');
    }

    public function urun_store(Request $request)
    {
        $request->validate([
           'baslik' => 'required',
           'fiyat' => 'required',
           'url' => 'required',
           'kdv' => 'required',
           'stok' => 'required',
            'resim' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $resimYolu = null;
        if ($request->hasFile('resim')) {
            $dosyaAdi = time() . '.' . $request->file('resim')->getClientOriginalExtension();
            $request->file('resim')->move(public_path('storage'), $dosyaAdi);
            $resimYolu = $dosyaAdi;
        }

        if ($resimYolu) {

            $olustur = DB::table('products')->insert([
                'baslik'   => $request->input('baslik'),
                'fiyat'    => $request->input('fiyat'),
                'url'      => $request->input('url'),
                'kdv'      => $request->input('kdv'),
                'stok'     => $request->input('stok'),
                'resim'    => $resimYolu,
                'aciklama' => $request->input('aciklama', ''),
                'ozellikler'=> $request->input('ozellikler', ''),
                'deleted'  => 0
            ]);

            if ($olustur) {
                return redirect(route('urunler'));
            } else {
                return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu lütfen daha sonra tekrar deneyin.");
            }


        }else{
            return redirect()->back()->with("error", "Resim dosyası yüklenemedi.");
        }


    }

    public function urun_data(Request $request) {
        $query = DB::table('products')->where('deleted', 0);

        $totalRecords = DB::table('products')->where('deleted', 0)->count();

        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('baslik', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('aciklama', 'like', "%{$search}%");
            });
        }

        $filteredRecords = $query->count();

        if ($request->has('order')) {
            $columnIndex = $request->input('order.0.column');
            $columnName = $request->input("columns.{$columnIndex}.data");
            $columnOrder = $request->input('order.0.dir');

            $sortableColumns = [
                'id'    => 'id',
                'adi'   => 'baslik',
                'url'   => 'url',
                'kdv'   => 'kdv',
                'fiyat' => 'fiyat'
            ];

            if (array_key_exists($columnName, $sortableColumns)) {
                $query->orderBy($sortableColumns[$columnName], $columnOrder);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $urunler = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($urunler as $urun) {
            $goruntule = route('urun.goruntule', $urun->url);
            $duzenle = route('urun.duzenle', $urun->id);
            $sil = route('urun.sil', $urun->id);

            $data[] = [
                'id'       => $urun->id,
                'adi'      => $urun->baslik,
                'url'      => $urun->url ?? '-',
                'kdv'      => '%' . $urun->kdv,
                'fiyat'    => number_format($urun->fiyat, 2, ',', '.') . ' ₺',
                'islemler' => '<button onclick="window.location.href=\''.$goruntule.'\'" class="btn btn-sm btn-info" title="İncele"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-primary" onclick="window.location.href=\''.$duzenle.'\'" title="Düzenle"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="window.location.href=\''.$sil.'\'" title="Sil"><i class="fas fa-trash"></i></button>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data"            => $data
        ]);
    }
    public function musteri()
    {

        return view('customer');
    }

    public function musteri_guncelle(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'company' => 'nullable',
            'tax_no' => 'nullable',
            'tax_office' => 'nullable',
            'website' => 'nullable',
            'address' => 'nullable',
            'district' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'customer_type' => 'required'
        ]);

        $fullname = trim($request->input('name'));
        $email = $request->input('email');
        $phone = $request->input('phone');
        $company = $request->input('company');
        $tax_no = $request->input('tax_no');
        $tax_office = $request->input('tax_office');
        $website = $request->input('website');

        $address = $request->input('address');
        $district = $request->input('district');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');
        $customer_type = $request->input('customer_type');

        $parcalar = explode(' ', $fullname);

        if (count($parcalar) > 1) {
            $lastname = array_pop($parcalar);
            $name = implode(' ', $parcalar);
        } else {
            $name = $fullname;
            $lastname = '';
        }
        $notes=$request->input('notes');


        $guncelle = DB::table('customers')
            ->where('id', $id)
            ->update([
                'notes'        => $notes,
                'city'         => $city,
                'name'         => $name,
                'surname'      => $lastname,
                'idn'          => $tax_no,
                'email'        => $email,
                'phone'        => $phone,
                'address'      => $address,
                'company'      => $company,
                'tax_office'   => $tax_office,
                'website'      => $website,
                'customer_type'=> $customer_type,
                'postal_code'  => $postal_code,
                'district'     => $district
            ]);

        if ($guncelle) {
            return redirect(route('musteriler'));
        }else{
            return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu lütfen daha sonra tekrar deneyin.");
        }

    }



    public function musteri_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'company' => 'nullable',
            'tax_no' => 'nullable',
            'tax_office' => 'nullable',
            'website' => 'nullable',
            'address' => 'nullable',
            'district' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'customer_type' => 'required'
        ]);

        $fullname = trim($request->input('name'));
        $email = $request->input('email');
        $phone = $request->input('phone');
        $company = $request->input('company');
        $tax_no = $request->input('tax_no');
        $tax_office = $request->input('tax_office');
        $website = $request->input('website');

        $address = $request->input('address');
        $district = $request->input('district');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');
        $customer_type = $request->input('customer_type');

        $parcalar = explode(' ', $fullname);

        if (count($parcalar) > 1) {
            $lastname = array_pop($parcalar);
            $name = implode(' ', $parcalar);
        } else {
            $name = $fullname;
            $lastname = '';
        }
        $notes=$request->input('notes');


        $olustur=DB::insert("insert into customers (notes, city, name, surname, idn, email, phone, address, company, tax_office, website, customer_type, postal_code, district) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$notes,$city,$name,$lastname,$tax_no,$email,$phone,$address,$company,$tax_office,$website,$customer_type,$postal_code,$district]);
        if ($request->input('invoice') and $olustur) {
            return redirect(route('fatura'));
        }elseif ($request->input('edit') and $olustur) {
            return redirect(route('fatura.edit', $request->input('invid')));
        }
        if ($olustur) {
            return redirect(route('musteriler'));
        }else{
            return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu lütfen daha sonra tekrar deneyin.");
        }
    }


}
