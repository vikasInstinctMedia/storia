<?php

namespace App\Traits;
use Session;
use Auth;
use Storage;

trait ProductHelperTrait {

    private function uploadUsp($usps, $uspIcons)
    {
        $uspData = [];

        foreach($usps as $key => $usp) {
            if($usp && $uspIcons && $uspIcons[$key]) {
                // upload image
                $fileName = $uspIcons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/usp/'. $fileName)) {
                    $iconPath = $uspIcons[$key]->storeAs('usp', $fileName );
                } else {
                    $iconPath = Storage::get('storage/usp/'. $fileName);
                }
                // dd($iconPath);

                $uspData[$key] = [
                    'usp'      => $usp,
                    'usp_icon' => $iconPath
                ];
            }
        }

        // dd($uspData);
        return $uspData;
    }

    private function uploadFruitIconDetails($fruiticons, $fruiticonIcons)
    {

        $uspData = [];

        foreach($fruiticons as $key => $fruiticon) {
            if($fruiticon && $fruiticonIcons && $fruiticonIcons[$key]) {
                // upload image
                $fileName = $fruiticonIcons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/fruiticon/'. $fileName)) {
                    $iconPath = $fruiticonIcons[$key]->storeAs('fruiticon', $fileName );
                } else {
                    $iconPath = Storage::get('storage/fruiticon/'. $fileName);
                }
                // dd($iconPath);

                $fruiticonData[$key] = [
                    'fruiticon'      => $fruiticon,
                    'fruiticon_icon' => $iconPath
                ];
            }
        }

        // dd($uspData);
        return $fruiticonData;
    }

      private function uploadIngredientDetails($ingredient, $ingredientIcons)
    {

        $uspData = [];

        foreach($ingredient as $key => $ingredient) {
            if($ingredient && $ingredientIcons && $ingredientIcons[$key]) {
                // upload image
                $fileName = $ingredientIcons[$key]->getClientOriginalName();
                if( ! Storage::exists('storage/ingredient/'. $fileName)) {
                    $iconPath = $ingredientIcons[$key]->storeAs('ingredient', $fileName );
                } else {
                    $iconPath = Storage::get('storage/ingredient/'. $fileName);
                }
                // dd($iconPath);

                $ingredientData[$key] = [
                    'ingredient'      => $ingredient,
                    'ingredient_icon' => $iconPath
                ];
            }
        }

        // dd($uspData);
        return $ingredientData;
    }

}
