<?php

namespace App\Http\Requests;

use App\Book;
use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'author_id' => 'required',
        ];
    }

    public function store()
    {
        Book::create([
            'title' => $this->title,
            'author_id' => $this->author_id,
        ]);
    }
    public function bookUpdate($book)
    {

        $book->title = $this->title;
        $book->author_id = $this->author_id;
        $book->save();

    }
}
