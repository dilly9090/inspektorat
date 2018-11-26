<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarTemuan;
use App\Models\DetailTemuan;
use App\Models\MasterDinas;
use App\Models\MasterBidangPengawasan;
use App\Models\MasterTemuan;
use App\Models\MasterSebab;
use App\Models\MasterRekomendasi;
class DaftarTemuanController extends Controller
{
    public function index()
    {
        $dinas=MasterDinas::all();
        $bidang=MasterBidangPengawasan::all();
        return view('backend.pages.daftar-temuan.index')
            ->with('dinas',$dinas)
            ->with('bidang',$bidang);
    }

    public function data($dinas_id=null,$tahun=null,$bidang_id=null)
    {
        $daftar=DaftarTemuan::where(['dinas_id'=>$dinas_id,'tahun'=>$tahun,'pengawasan_id'=>$bidang_id])->with(['pengawasan','aparat','dinas','daftar'])->get();
        $detail=DetailTemuan::with(['daftar','temuan','sebab','rekomendasi'])->get();
        $det=array();
        foreach($detail as $k=>$v)
        {
            $det[$v->daftar_id][]=$v;
        }
        // dd($det);
        return view('backend.pages.daftar-temuan.data')
            ->with('det',$det)
            ->with('dinas_id',$dinas_id)
            ->with('tahun',$tahun)
            ->with('bidang_id',$bidang_id)
            ->with('daftar',$daftar);
    }

    public function create()
    {
        $dinas=MasterDinas::all();
        $bidang=MasterBidangPengawasan::all();
        $temuan=MasterTemuan::all();
        $sebab=MasterSebab::all();
        $rekomendasi=MasterRekomendasi::all();
        return view('backend.pages.daftar-temuan.form')
            ->with('dinas',$dinas)
            ->with('temuan',$temuan)
            ->with('sebab',$sebab)
            ->with('rekomendasi',$rekomendasi)
            ->with('bidang',$bidang);
    }
    public function form_detail($id,$dinas_id,$tahun,$bidang_id)
    {
        if($id==-1)
            return redirect('list-temuan/create');

        $dinas=MasterDinas::where('id',$dinas_id)->get();
        $bidang=MasterBidangPengawasan::where('id',$bidang_id)->get();
        $temuan=MasterTemuan::all();
        $sebab=MasterSebab::all();
        $rekomendasi=MasterRekomendasi::all();
        $daftar=DaftarTemuan::find($id);
        return view('backend.pages.daftar-temuan.form-detail')
            ->with('dinas',$dinas)
            ->with('temuan',$temuan)
            ->with('sebab',$sebab)
            ->with('rekomendasi',$rekomendasi)
            ->with('daftar',$daftar)
            ->with('tahun',$tahun)
            ->with('bidang',$bidang);
    }
    public function edit($id)
    {
        $detail=DetailTemuan::find($id);
        $daftar=DaftarTemuan::find($detail->daftar_id);
        $dinas=MasterDinas::where('id',$daftar->dinas_id)->get();
        $bidang=MasterBidangPengawasan::where('id',$daftar->pengawasan_id)->get();
        $temuan=MasterTemuan::all();
        $sebab=MasterSebab::all();
        $rekomendasi=MasterRekomendasi::all();
        
        return view('backend.pages.daftar-temuan.form-edit')
            ->with('id',$id)
            ->with('dinas',$dinas)
            ->with('detail',$detail)
            ->with('temuan',$temuan)
            ->with('sebab',$sebab)
            ->with('rekomendasi',$rekomendasi)
            ->with('daftar',$daftar)
            ->with('tahun',$daftar->tahun)
            ->with('bidang',$bidang);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        list($tgl,$bln,$thn)=explode('/',$request->tgl_pengawasan);

        $aparat=MasterDinas::where('nama_dinas','like',"%Inspektorat%")->first();

        $cekdaftar=DaftarTemuan::where('no_pengawasan',$request->no_pengawasan)
                ->where('dinas_id',$request->dinas_id)
                ->where('tahun',$request->tahun)->first();

        if(is_null($cekdaftar))
        {
            $daftar=new DaftarTemuan;
            $daftar->aparat_id=$aparat->id;
            $daftar->dinas_id=$request->dinas_id;
            $daftar->tahun=$request->tahun;
            $daftar->pengawasan_id=$request->pengawasan_id;
            $daftar->no_pengawasan=$request->no_pengawasan;
            $daftar->tgl_pengawasan=$thn.'-'.$bln.'-'.$tgl;
            $daftar->save();

            $daftar_id=$daftar->id;
        }
        else
        {
            $daftar_id=$cekdaftar->id;
        }
        

        foreach($request->temuan as $k=>$v)
        {
            $detail=new DetailTemuan;
            $detail->flag=0;
            $detail->daftar_id=$daftar_id;
            $detail->temuan_id=$v;
            $detail->uraian_temuan=$request->uraian_temuan[$k];
            $detail->sebab_id=$request->sebab[$k];
            $detail->penyebab=$request->uraian_sebab[$k];
            $detail->rekomendasi_id=$request->rekomendasi[$k];
            $detail->uraian_rekomendasi=$request->uraian_rekomendasi[$k];
            $detail->save();
        }

        return redirect('list-temuan')
            ->with('success', 'Daftar Temuan berhasil Ditambahkan')
            ->with('dinas_id',$request->dinas_id)
            ->with('tahun',$request->tahun)
            ->with('pengawasan_id',$request->pengawasan_id);
        // echo nl2br($request->uraian_rekomendasi[0]);
    }

    public function update_detail(Request $request,$iddetail)
    {
        // dd($request->all());
        $detail=DetailTemuan::find($iddetail);
        $detail->flag=0;
        $detail->temuan_id=$request->temuan;
        $detail->uraian_temuan=$request->uraian_temuan;
        $detail->sebab_id=$request->sebab;
        $detail->penyebab=$request->uraian_sebab;
        $detail->rekomendasi_id=$request->rekomendasi;
        $detail->uraian_rekomendasi=$request->uraian_rekomendasi;
        $detail->save();
        

        return redirect('list-temuan')
            ->with('success', 'Daftar Temuan berhasil Diperbaharui')
            ->with('dinas_id',$request->dinas_id)
            ->with('tahun',$request->tahun)
            ->with('pengawasan_id',$request->pengawasan_id);
        // echo nl2br($request->uraian_rekomendasi[0]);
    }

    public function detail_destroy(Request $request)
    {
        $id=$request->id;
        $detail=DetailTemuan::find($id);
        $daftar=DaftarTemuan::find($detail->daftar_id);
        $detail->delete();
        return redirect('list-temuan')
            ->with('success', 'Hapus Detail Temuan berhasil')
            ->with('dinas_id',$daftar->dinas_id)
            ->with('tahun',$daftar->tahun)
            ->with('pengawasan_id',$daftar->pengawasan_id);
    }

    public function detail_verifikasi(Request $request)
    {
        $id=$request->id;
        $detail=DetailTemuan::find($id);
        $detail->flag=2;
        $detail->save();
        
        $daftar=DaftarTemuan::find($detail->daftar_id);
        
        return redirect('list-temuan')
            ->with('success', 'Verifikasi Detail Temuan berhasil')
            ->with('dinas_id',$daftar->dinas_id)
            ->with('tahun',$daftar->tahun)
            ->with('pengawasan_id',$daftar->pengawasan_id);
    }
}