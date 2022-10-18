<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dao\KontenlandingDao;
use App\Dao\Masters\MitraDao;
use App\Http\Requests\Masters\KontenRequest;
use App\Http\Requests\Masters\MitraRequest;
use App\Models\Masters\Kontenlanding;


class KontenlandingController extends Controller
{
	private KontenlandingDao $KontenlandingDao;
	
	public function __construct(KontenlandingDao $KontenlandingDao)
    {
       	$this->KontenlandingDao = $KontenlandingDao;
    }
	
	public function index()
    {	
		$dataKontenList = $this->KontenlandingDao->getPaginate();		
		//print_r($dataKontenList);
        return view('pages.masters.kontenlanding.index',['dataKontenList' => $dataKontenList->data,]);
    }
	
    public function create()
    {
		 $jenisList = $this->KontenlandingDao->getJenis(0);	 
         return view('pages.masters.kontenlanding.create',['jenisList' => $jenisList->data,]);
    }
	
	public function store2(KontenRequest $request)
    {
		if($request->file('gambar')){
            $file= $request->file('gambar');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $filename);
            $data['gambar']= $filename;
        }
		
        $validated = $request->validated();//print_r($validated);	
        $insertKonten = $this->KontenlandingDao->insert($validated);
		
        if ($insertKonten->isOk) {
            return redirect()->back()->with('message', $insertKonten->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertKonten->message);
        }
    }
	
	public function store(KontenRequest $request)
	{
		//echo "konten store";
		$data = new Kontenlanding();
		//$validated = $request->validated();//print_r($validated);	
        //print_r($request->input('gambar_upload'));
		//print_r($request->file());
		if($request->file('gambar_upload')){
            $file= $request->file('gambar_upload');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $data['gambar']= $filename;
			//echo 'gambar OK';
        }       
		
        if($request->file('gambar')){
            $pathVideo = request()->file('gambar')->store('gambar/' . date('Y'), 'public');
			$data['gambar'] = $pathVideo;
			//echo 'gambar';
        }
		
		$validated = $request->validate([            
            'judul' => 'required|string',
            'isi' => 'nullable|string',
			'aktif' => 'nullable|string',
            'gambar' => 'nullable|string', // 5MB
            //'gambar_upload' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'tanggal' => 'required|date',
        ]);
		//print_r($request);
		$data['isi'] =    $validated['isi'];
		$data['aktif'] =  $validated['aktif'];
		$data['tanggal'] =  $validated['tanggal'];
		$data['judul'] =  $validated['judul'];
		$data->save();
		//$insertKonten = $this->KontenlandingDao->insert($validated);
		return redirect()->back()->with('message','sukses');
       
		
	}
	
	public function edit($id)
    {
       //$jenisList = $this->KontenlandingDao->getJenis(0);	 
		$jenisList = (object) array(		
			6 => array(
				'id' => 'banner', 'nama' => 'Banner'
			),
			0 => array(
				'id' => 'sambutan', 'nama' => 'Sambutan'
			),
			1 => array(
				'id' => 'pengumuman', 'nama' => 'Pengumuman'
			),
			2 => array(
				'id' => 'download', 'nama' => 'Download'
			),
			3 => array(
				'id' => 'pendaftaran', 'nama' => 'Pendaftaran'
			),
			4 => array(
				'id' => 'info', 'nama' => 'Info'
			),
			5 => array(
				'id' => 'dosen', 'nama' => 'Dosen'
			)			
			);
		$Aktif = (object) array(		
			1 => array(
				'id' => '1', 'nama' => 'Aktif'
			),
			0 => array(
				'id' => '0', 'nama' => 'Tidak Aktif'
			)
			);
		$kontenData = $this->KontenlandingDao->getById($id);
        return view('pages.masters.kontenlanding.edit',[
			 'jenisList' => $jenisList,
			 'kontenData' => $kontenData->data,
			 'Aktif' => $Aktif
		 ]);
    }
	
	public function update(KontenRequest $request, $id)
    {
       
		$validated = $request->validated();

        $updateKonten = $this->KontenlandingDao->update($id, $validated);
		
        if ($updateKonten->isOk) {
            return redirect()->back()->with('message', $updateKonten->message);
        } else {
           return redirect()->back()->withInput()->with('error', $updateKonten->message);
        }
    }	
	
	public function update2(KontenRequest $request, $id)
    {

		$data = Kontenlanding::find($id);
		
		if($request->file('gambar_upload')){
            $file= $request->file('gambar_upload');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $data->gambar = $filename;
		
        }       		
		
		$validated = $request->validate([            
            'judul' => 'required|string',
            'isi'   => 'nullable|string',
			'aktif' => 'nullable|string',
            'gambar' => 'nullable|string', // 5MB
            //'gambar_upload' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'tanggal' => 'required|date',
        ]);
		
		$data->aktif =  $validated['aktif'];
		$data->tanggal =  $validated['tanggal'];
		$data->judul =  $validated['judul'];
		$data->isi = $validated['isi'];
		//$updateKonten = $data->update()->where('id', $id);
		$data->update();
		$updateKonten = $data::where('id', $id);
		//$updateKonten = $this->KontenlandingDao->update($id, $data);
		
		return redirect()->back()->with('message', 'Sukses');
    }
	
	 public function destroy($id)
    {
        $deleteKonten = $this->KontenlandingDao->delete($id);
        return redirect()->back()->with($deleteKonten->isOk ? 'message' : 'error', $deleteKonten->message);
    }	
}
