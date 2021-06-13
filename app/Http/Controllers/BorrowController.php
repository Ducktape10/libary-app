<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    const status = ['PENDING', 'ACCEPTED', 'REJECTED', 'RETURNED'];
    const statusModify = ['ACCEPTED', 'REJECTED', 'RETURNED'];
    public function __construct()
    {
        $this->middleware('is_libarian')->only(['edit', 'update']);
        $this->middleware('is_reader')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $currentStatus = 'PENDING';
            $statusGet = $request->status;
            if (in_array($statusGet, BorrowController::status)) {
                $currentStatus = $statusGet;
            } else if ($statusGet == 'LATE') {

            }

            if ($user->is_libarian) {
                $borrows = Borrow::where('status', '=', $currentStatus)->paginate(15);

                return view('borrows.index', [
                    'borrows' => $borrows
                ]);
            }
            $borrows = Borrow::where('reader_id', '=', $user->id)->where('status', '=', $currentStatus)->get();

            return view('borrows.index', [
                'borrows' => $borrows
            ]);
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'text' => 'max:255',
            ],
            [
                'text.max' => 'A Megjegyzés legfeljebb :max karakter lehet.'
            ]
        );

        $borrows = Borrow::where('reader_id', '=', Auth::user()->id)->get();
        $duplicate = false;

        for ($i = 0; $i < $borrows->count() && !$duplicate; $i++) {
            $duplicate = $borrows[$i]->reader_id == Auth::user()->id &&
            $borrows[$i]->book_id == $request->bookId &&
            (
                $borrows[$i]->status == 'PENDING' ||
                $borrows[$i]->status == 'ACCEPTED'
            );
        }

        $book = Book::find($request->bookId);

        if (!$duplicate) {
            Borrow::create([
                'reader_id' => Auth::user()->id,
                'book_id' => $request->bookId,
                'reader_message' => $request->text,
                'status' => 'PENDING'
            ]);
            $request->session()->flash('borrow-created', $book->title);
        } else {
            $request->session()->flash('borrow-deny', $book->title);
        }

        return redirect()->route('books.show', $book);
    }

    public function attachment($id) {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->is_libarian == 1 || $borrow->reader == $user) {
                return view('borrows.show', [
                    'borrow' => $borrow
                ]);
            }
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        return view('borrows.edit', [
            'borrow' => $borrow,
            'statuses' => self::statusModify
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {
        $validated = $request->validate(
            [
                'status' => 'required|in:ACCEPTED,REJECTED,RETURNED',
                'deadline' => 'nullable|date_format:Y-m-d',
                'request_processed_message' => 'max:255'
            ],
            [
                'required' => 'A(z) :attribute mezőt meg kell adni.',
                'request_processed_message.max' => 'A megjegyzés legfeljebb :max karakter lehet.'
            ]
        );

        if ($validated["status"] == 'ACCEPTED' || $validated["status"] == 'REJECTED') {
            $validated["request_managed_by"] = Auth::user()->id;
            $validated["request_processed_at"] = date('Y-m-d H:i:s');
        } else if ($validated["status"] == 'RETURNED') {
            $validated["return_managed_by"] = Auth::user()->id;
            $validated["returned_at"] = date('Y-m-d H:i:s');
        }

        $borrow->update($validated);

        $request->session()->flash('borrow-updated', true);
        return redirect()->route('borrows.show', $borrow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
