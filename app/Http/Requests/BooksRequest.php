<?php

namespace App\Http\Requests;

use App\Books;
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
            'author' => 'required',
        ];
    }

    public function store()
    {
        Books::create([
            'title' => $this->title,
            'author' => $this->author,
        ]);
    }
    public function bookUpdate($books)
    {
            $books->update($this->all());
            //dd($books);
    }
}
