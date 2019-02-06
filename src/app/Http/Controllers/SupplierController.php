<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Validator;
use PDF;
use Carbon\Carbon;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:master-suppliers');
    }

    public function index()
    {
        $data['title']      = 'Data Supplier - PUDEMAS';
        $data['page']       = 'Data Supplier';

        return view('supplier')->with($data);
    }

    public function getSupplier()
    {
        try {
            $Supplier       = Supplier::Supplier()->orderBy('name', 'ASC')->get();

            return Datatables::of($Supplier)
            ->addColumn('action', function ($Supplier) {
                return '
                <button type="button" id="'.$Supplier->id.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
                <button type="button" id="'.$Supplier->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }  
    }

    public function getSupplierById(Request $request)
    {
        $Supplier       = Supplier::find($request->id);
        $Supplier->get();

        return response()->json($Supplier);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSupplier(Request $request)
    {
        try {
            $attributeNames     = array(
                'name'          => 'Nama Supplier',
                'email'         => 'Email Supplier',
                'phone'         => 'Nomor Telepon',
                'address'       => 'Alamat Supplier',
            );

            $validator          = Validator::make($request->all(),[
                'name'          => 'required',
                'email'         => 'required|email',
                'phone'         => 'required|regex:/(08)[0-9]{9}/|max:13|min:11',
                'address'       => 'required|min:3',
            ]);

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                return redirect()->route('supplier')
                ->withErrors($validator)
                ->withInput();
            }

            $Supplier               = new Supplier();
            $Supplier->name         = $request->name;
            $Supplier->email        = $request->email;
            $Supplier->phone        = $request->phone;
            $Supplier->address      = $request->address;
            $Supplier->save();

            return redirect()->route('supplier')
            ->with('success', 'Data Supplier Berhasil Disimpan');
        } catch (\Exception $e) {
            return redirect()->route('supplier')
            ->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function updateSupplier(Request $request)
    {
        try {
            $attributeNames     = array(
                'name'          => 'Nama Supplier',
                'email'         => 'Email Supplier',
                'phone'         => 'Nomor Telepon',
                'address'       => 'Alamat Supplier',
            );

            $validator          = Validator::make($request->all(),[
                'name'          => 'required',
                'email'         => 'required|email',
                'phone'         => 'required|regex:/(08)[0-9]{9}/|max:13|min:11',
                'address'       => 'required|min:3',
            ]);

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                return redirect()->route('supplier')
                ->withErrors($validator)
                ->withInput();
            }

            $Supplier           = Supplier::find($request->id);
            $Supplier->name     = $request->name;
            $Supplier->email    = $request->email;
            $Supplier->phone    = $request->phone;
            $Supplier->address  = $request->address;
            $Supplier->save();

            return redirect()->route('supplier')
            ->with('success', 'Data Supplier Berhasil Diedit');
        } catch (\Exception $e) {
            return redirect()->route('supplier')
            ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroySupplier(Request $request)
    {
        try {
            $Supplier       = Supplier::find($request->id);
            $Supplier->Delete();

            return redirect()->route('supplier')
            ->with('success', 'Data Supplier Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->route('supplier')
            ->with('error', $e->getMessage());
        }
    }

    /* UTILITIES */

    public function selectSupplier(Request $request)
    {
        $select = [];
        try {
            if ($request->has('q')) {
                $search         = $request->q;
                $select         = DB::table('supplier')
                ->select('id','name as text')
                ->where('name', 'like', "%$search%")
                ->orderBy('name','asc')
                ->get();   
            }else {
                $select         = Supplier::select([
                    'id',
                    'name as text',
                ])
                ->orderBy('name','asc')
                ->get();
            }

            return response()->json($select);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /* Report */

    public function reportSupplier()
    {
        $supplier           = Supplier::Supplier()
        ->orderBy('name','ASC')
        ->get();

        $pdf = PDF::loadView('report.supplier', compact('supplier'));

        return $pdf->stream('supplier-report-'.Carbon::now());
    }
}
