<?php

namespace App\Http\Controllers;

use App\OtherExpenses;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Carbon\Carbon;
use Auth;
use PDF;

class OtherExpensesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['title']          = 'Data Pengeluaran Lain Lain - PUDEMAS';
		$data['page']           = 'Data Pengeluaran Lain Lain';

		return view('other_expenses')->with($data);
	}

	public function getOtherExpenses()
	{
		try {
			$data                   = OtherExpenses::OtherExpenses()->orderBy('date', 'DESC')->get();     

			return Datatables::of($data)
			->editColumn('date', function($data) {
				return Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
			})
			->addColumn('action', function ($data) {
				/*if (Auth::id() == 2) {
					return '
					<button type="button" id="'.$data->id.'" date="'.Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y').'" created_by="'.$data->created_by.'" subject="'.$data->subject.'" amount="'.$data->amount.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
					<button type="button" id="'.$data->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
				}elseif (Auth::id() == $data->id_created_by) {
					return '
					<button type="button" id="'.$data->id.'" date="'.Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y').'" created_by="'.$data->created_by.'" subject="'.$data->subject.'" amount="'.$data->amount.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
					<button type="button" id="'.$data->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
				}else {
					return ' ';
				}*/

				return '
				<button type="button" id="'.$data->id.'" date="'.Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y').'" created_by="'.$data->created_by.'" subject="'.$data->subject.'" amount="'.$data->amount.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$data->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
				
			})
			->rawColumns(['action'])
			->make(true);  
		} catch (\Exception $e) {
			dd($e->getMessage());
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeOtherExpenses(Request $request)
	{
		try {
			$attributeNames             = array(
				'subject'               => 'Perihal',
				'amount'                => 'Jumlah',
				'date'                  => 'Tanggal'
			);

			$validator                  = Validator::make($request->all(), [
				'subject'               => 'required|min:5',
				'amount'                => 'required|numeric',
			]);

			$validator->setAttributeNames($attributeNames);

			if($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert                     = new OtherExpenses();
			$insert->subject            = $request->subject;
			$insert->amount             = $request->amount;
			$insert->date               = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
			$insert->created_by         = Auth::id();
			$insert->save();

			return redirect()->back()->with('success', 'Data Berhasil Disimpan');

		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\OtherExpenses  $otherExpenses
	 * @return \Illuminate\Http\Response
	 */
	public function show(OtherExpenses $otherExpenses)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\OtherExpenses  $otherExpenses
	 * @return \Illuminate\Http\Response
	 */
	public function edit(OtherExpenses $otherExpenses)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\OtherExpenses  $otherExpenses
	 * @return \Illuminate\Http\Response
	 */
	public function updateOtherExpenses(Request $request)
	{
		try {
			$attributeNames             = array(
				'subject'               => 'Perihal',
				'amount'                => 'Jumlah',
				'date'                  => 'Tanggal'
			);

			$validator                  = Validator::make($request->all(), [
				'subject'               => 'required|min:5',
				'amount'                => 'required|numeric',
			]);

			$validator->setAttributeNames($attributeNames);

			if($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$data                     = OtherExpenses::find($request->id);
			$data->subject            = $request->subject;
			$data->amount             = $request->amount;
			$data->date               = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
			$data->created_by         = Auth::id();
			$data->save();

			return redirect()->back()->with('success', 'Data Berhasil Diubah');

		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\OtherExpenses  $otherExpenses
	 * @return \Illuminate\Http\Response
	 */
	public function destroyOtherExpenses(Request $request)
	{
		try {
			$expenses           = OtherExpenses::find($request->id);
			$expenses->Delete();

			return redirect()->back()->with('success', 'Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	/* Report */
	public function reportExpenses()
	{
		$data 			= OtherExpenses::OtherExpenses()
		->orderBy('date', 'DESC')
		->get();

		$pdf = PDF::loadView('report.expenses', compact('data'));

        return $pdf->stream('expenses-report-'.Carbon::now());
	}
}
