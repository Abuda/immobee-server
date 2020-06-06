<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:' . Constants::MAX_TITLE_LENGTH,
            'description' => 'nullable|MAX:' . Constants::MAX_DESCRIPTION_LENGTH,
            'property' => ['required', Rule::in(Constants::PROPERTY_ARRAY)],
            'type' => [Rule::requiredIf(in_array($request->property, ['house', 'apartment'])), Rule::in(Constants::TYPE_ARRAY)],
            'rent_type' => [Rule::requiredIf(in_array($request->type, ['rent'])), Rule::in(Constants::RENT_TYPE_ARRAY)],
            'country' => ['required', 'exists:countries,name'],
            'state' => 'required|exists:states,name',
            'division' => 'exists:divisions,name',
            'street' => ['required', 'max:' . Constants::MAX_STREET_LENGTH],
            'house_no' => 'max:' . Constants::MAX_HOUSE_NO_LENGTH,
            'post_code' => 'required|max:' . Constants::MAX_POST_CODE_LENGTH,
            'street_and_house_no_visible' => 'boolean',
            'photos' => '',
            'area' => ['numeric', 'min:0', 'max:' . Constants::MAX_AREA, Rule::requiredIf(in_array($request->property, ['house', 'apartment', 'room']))],
            'rooms' => ['numeric', 'min:1', 'max:' . Constants::MAX_ROOMS, Rule::requiredIf(in_array($request->property, ['house', 'apartment']))],
            'floor' => ['numeric', 'min:0', 'max:' . Constants::MAX_FLOOR, Rule::requiredIf(in_array($request->property, ['house', 'apartment', 'room', 'bed']))],
            'build_year' => ['numeric', 'min:' . Constants::MIN_BUILD_YEAR, 'max:' . Constants::MAX_BUILD_YEAR],
            'available_from' => ['nullable', 'date_format:' . Constants::DATE_FORMAT, 'after:today'],
            'price' => [Rule::requiredIf(in_array($request->type, ['sell'])), 'numeric', 'min:0', 'max:' . Constants::MAX_PRICE],
            'rent' => [Rule::requiredIf(in_array($request->type, ['rent'])), 'numeric', 'min:0', 'max:' . Constants::MAX_RENT],
            'deposit' => ['numeric', 'min:0', 'max:' . Constants::MAX_DEPOSIT],
            'compensation' => ['numeric', 'min:0', 'max:' . Constants::MAX_COMPENSATION],
            'bathtub' => 'boolean',
            'balcony' => 'boolean',
            'terrace' => 'boolean',
            'garden' => 'boolean',
            'furnished' => 'boolean',
            'equipped_kitchen' => 'boolean',
            'lift' => 'boolean',
            'wlan' => 'boolean',
            'email_visible' => 'boolean',
            'phone_visible' => 'boolean',
        ]);

        // remove null values from request
        $validatedData = array_filter($validatedData);
        $validatedData['user_id'] = Auth::user()->id;
        $product = Product::create($validatedData)->save();
        return Response()->json(['message' => 'success', 'product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return Response()->json(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::user()->id) {
            return Response()->json([], Constants::codes()::UNAUTHORIZED);
        }
        $product->delete();
        return Response()->json(['message' => 'Item Deleted']);
    }
}
