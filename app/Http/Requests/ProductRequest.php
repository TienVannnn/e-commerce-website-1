<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // return [
        //     'code' => 'required|unique:products,code',
        //     'name' => 'required|unique:products,name',
        //     'slug' => 'required|unique:products,slug',
        //     'price' => 'required|unique:table,column,except,id',
        //     'image' => 'required',
        //     'tags' => 'required',
        //     'short_des' => 'required',
        //     'content' => 'required'
        // ];
        $productId = $this->route('product');
        return [
            'code' => $productId ? 'required|unique:products,code,' . $productId . ',id' : 'required|unique:products,code',
            'name' => $productId ? 'required|unique:products,name,' . $productId . ',id' : 'required|unique:products,name',
            'slug' => $productId ? 'required|unique:products,slug,' . $productId . ',id' : 'required|unique:products,slug',
            'price' => 'required',
            'short_des' => 'required',
            'content' => 'required',
        ];
    }
}
