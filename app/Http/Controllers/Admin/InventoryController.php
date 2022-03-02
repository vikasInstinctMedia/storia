<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\ProductPackMap;
use App\Models\Recipe;
use Excel;
use App\Exports\InventoryTemplateExport;
use App\Imports\InventoryImport;

class InventoryController extends Controller
{
    
    public function index(Branch $branch)
    {   
        // echo($tets);
        // $this->syncInventory($branch);
        return view('admin.branch.inventory.index', compact('branch'));
    }

    public function getInventroyList(Branch $branch)
    {   
        $allBranchProducts = $branch->inventories()->with(['sku', 'sku.product' => function($query) {
                                $query->select('id','name');
                            }]);
        // dd($allBranchProducts->get());
        return datatables()->of($allBranchProducts)
                    ->addIndexColumn()
                    ->editColumn('thumbnail_image', function($row) {
                        return $row->thumbnail_image ? asset("storage/".$row->thumbnail_image) : "";
                    })
                    ->addColumn('action', function($row){
                           return [
                                // 'view_url' => route('admin.categories.show',[ 'category' => $row->id]),
                                'edit_url' => route('admin.products.edit', ['product' => $row->id])
                           ];
                    })
                    ->toJson();
    }


    public function updateQuantity(Request $request)
    {
        $request->validate([
            'inventoryId' => 'required|numeric',
            'quantity' => 'required|numeric|gte:0'
        ]);

        if( ! Inventory::where('id', $request->inventoryId)->update(['quantity' => $request->quantity ]) ) {
            return back()->with('error', 'something went wrong');
        }
        return back()->with('message', 'Quantity updated successfully');
    }   

    /**
     * 
     */
    private function syncInventory($branch) 
    {
        $allSkus = ProductPackMap::all();
        // dd($allSkus);
        $allSkus->each(function($sku) use($branch) {
            
            Inventory::updateOrCreate([
                'branch_id' => $branch->id,
                'product_pack_map_id' => $sku->id
            ], [
                'quantity' => 50
            ]);
        });

        dd('inventory synced with branch '. count($allSkus));
    }

    public function importStockView($branch_id)
    {
        $branch = Branch::where('id', $branch_id)->first();
        return view('admin.branch.inventory.import_stock', compact('branch'));
    }

    public function exportTemplateForInventory(Request $request)
    {
        // dd('test');
        // dd($request->branch_id);
        return Excel::download(new InventoryTemplateExport($request->branch_id), 'inventory.xlsx');
    }
    
    public function importStock(Request $request)
    {
        // dd($request->all());
        

        Excel::import(new InventoryImport(), $request->file('file')  );

        return redirect()->route('admin.branches.inventory.index', ['branch' =>$request->branch_id ])->with('message', 'successfully imported');
    }
}
