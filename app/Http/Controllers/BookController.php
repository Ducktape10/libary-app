<?php

namespace App\Http\Controllers;


use App\Models\Genre;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Auth;
use Gate;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_libarian')->only(['create', 'store', 'edit', 'update', 'delete']);
        $this->middleware('is_reader')->only(['borrow']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $books = $request->title ? Book::where('title', 'like', '%' . $request->title . '%')->paginate(9) : Book::paginate(9);
        $count = $request->title ? Book::where('title', 'like', '%' . $request->title . '%')->count() : Book::count();
        $title = $request->title;
        $page = $request->page;

        return view('books.index', [
                'books' => $books,
                'booksCount' => $count,
                'booksAllCount' => Book::count(),
                'page' => $page,
                'title' => $title,
                'userCount' => User::count(),
                'genres' => Genre::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create', [
            'genres' => Genre::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date_format:Y-m-d|before:tomorrow',
                'pages' => 'required|numeric|min:1',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i',
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'attachment' => 'nullable|file|mimes:jpg,png,bmp|max:1024',
                'in_stock' => 'required|integer|numeric|min:0|max:3000'
            ],
            [
                'title.required' => 'A címet meg kell adni.',
                'title.min' => 'A cím legalább :min karakter legyen.',
                'title.max' => 'A cím legfeljebb :max karakter lehet.',

                'authors.required' => 'A szerzőt meg kell adni.',
                'authors.min' => 'A szerző legalább :min karakter legyen.',
                'authors.max' => 'A szerző legfeljebb :max karakter lehet.',

                'released_at.required' => 'A kiadás dátumot meg kell adni.',
                'released_at.before' => 'A kiadás dátuma legkésőbb mai nap lehet.',

                'pages.required' => 'Az oldalszámot meg kell adni.',
                'pages.min' => 'Az oldalszám legalább :min legyen.',

                'isbn.required' => 'Az ISBN számot meg kell adni.',
                'isbn.regex' => 'Az ISBN formátuma nem helyes.',

                'in_stock.required' => 'A készletszámot meg kell adni.',
                'in_stock.integer' => 'A készletszámnak egész értéknek kell lenni.',
                'in_stock.min' => 'A készletszám legalább :min legyen.',
                'in_stock.max' => 'A készletszám legfeljebb :min lehet.'
            ]
        );

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileExtension = $file->getClientOriginalExtension();
            //Log::critical(Book::orderBy('created_at', 'desc')->take(1)->get()[0]);
            $lastBook = Book::orderBy('created_at', 'desc')->take(1)->get()[0];
            $lastId = $lastBook->id;
            $newName = 'cover_' . ($lastId + 1) . '.' . $fileExtension;//$file->hashName();
            Storage::disk('book_covers')->put($newName, $file->get());
            $data['cover_image'] = $newName;
        }

        $book = Book::create($data);

        $book->genres()->attach($request->genres);

        $request->session()->flash('book-created', $book->title);
        return redirect()->route('books.create');
    }

    public function attachment($id) {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit', [
            'book' => $book,
            'genres' => Genre::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date_format:Y-m-d|before:tomorrow',
                'pages' => 'required|numeric|min:1',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i',
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'attachment' => 'nullable|file|mimes:jpg,png,bmp|max:1024|prohibited_unless:remove_cover,null',
                'remove_cover' => 'nullable|boolean',
                'in_stock' => 'required|integer|numeric|min:0|max:3000'
            ],
            [
                'title.required' => 'A címet meg kell adni.',
                'title.min' => 'A cím legalább :min karakter legyen.',
                'title.max' => 'A cím legfeljebb :max karakter lehet.',

                'authors.required' => 'A szerzőt meg kell adni.',
                'authors.min' => 'A szerző legalább :min karakter legyen.',
                'authors.max' => 'A szerző legfeljebb :max karakter lehet.',

                'released_at.required' => 'A kiadás dátumot meg kell adni.',
                'released_at.before' => 'A kiadás dátuma legkésőbb mai nap lehet.',

                'pages.required' => 'Az oldalszámot meg kell adni.',
                'pages.min' => 'Az oldalszám legalább :min legyen.',

                'isbn.required' => 'Az ISBN számot meg kell adni.',
                'isbn.regex' => 'Az ISBN formátuma nem helyes.',

                'attachment.prohibited_unless' => 'Nem lehet egyszerre feltölteni és törölni borítót.',

                'in_stock.required' => 'A készletszámot meg kell adni.',
                'in_stock.integer' => 'A készletszámnak egész értéknek kell lenni.',
                'in_stock.min' => 'A készletszám legalább :min legyen.',
                'in_stock.max' => 'A készletszám legfeljebb :min lehet.'
            ]
        );

        if ($request->remove_cover) {
            //if (isset($request['remove_cover']) == 1) {
            Storage::disk('book_covers')->delete($book->cover_image);
            $data['cover_image'] = null;
            //}
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileExtension = $file->getClientOriginalExtension();

            $newName = 'cover_' . $book->id . "." . $fileExtension;

            Storage::disk('book_covers')->delete($newName);

            Storage::disk('book_covers')->put($newName, $file->get());
            $data['cover_image'] = $newName;
        }

        $book->update($data);

        $book->genres()->sync($request->genres);

        $request->session()->flash('book-updated', $book->name);
        return redirect()->route('books.edit', $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        Book::destroy($id);
        Session::flash('book-deleted', $book->title);
        return redirect()->route('books.index');
    }

    /**
     * Show the form for borrow.
     *
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    public function borrow($id)
    {
        return view('borrows.create', ['book' => Book::find($id)]);
    }
}
