<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

use function Termwind\render;

class SliderController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all()); ésta linea sirve para hacer pruebas de envío de datos o volcamiento de datos desde un formulario
        $request->validate([
           'banner' => ['required', 'image', 'max:2000'],
           'type' => ['string', 'max:200'],
           'title' => ['required', 'max:200'],
           'starting_price' =>  ['max:200'],
           'btn_url' => ['url'],
           'serial' => ['required', 'integer'],
           'status' => ['required']
        ]);

        $slider = new Slider();

        /*** Handle file upload ***/
        $imagePath = $this->uploadImage($request, 'banner', 'uploads');

        $slider->banner = $imagePath;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        toastr('Created Successfuly!', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all()); ésta linea sirve para hacer pruebas de envío de datos o volcamiento de datos desde un formulario
        $request->validate([
            'banner' => ['nullable', 'image', 'max:2000'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' =>  ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required']
        ]);

        $slider = Slider::findOrFail($id);

         /*** Handle file upload ***/
        $imagePath = $this->updateImage($request, 'banner', 'uploads', $slider->banner);

        //$slider->banner = $imagePath;*****Ésta linea me estaba quitando la imagen cuando actualizaba en editor***
        $slider->banner = empty(!$imagePath) ? $imagePath : $slider->banner; //Solución al problema que quitaba la imagen cuando se actualizaba edición
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        toastr('Update Successfuly!', 'success');

        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        //dd($slider); ******dd sirve para hacer prueba de volcamiento de datos.
        $this->deleteImage($slider->banner);
        $slider->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfuly!']);
    }
}
