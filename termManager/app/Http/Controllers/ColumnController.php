<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColumnResource;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return response(ColumnResource::collection(Column::all()), 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => 'required',
            'sortable' => 'required',
            'filterable' => 'required',
            'elementType' => 'required',
            'mandatory' => 'required',
            'position' => 'required',
        ]);

        $nextColSeq = DB::select("select nextval('column_seq')");
        $nextColId = intval($nextColSeq['0']->nextval);

        $newColumn = Column::create([
            'id' => $nextColId,
            'name' => $request->name,
            'html_id' => 'column_' . $nextColId,
            'sortable' => $request->sortable,
            'filterable' => $request->filterable,
            'element_type' => $request->elementType,
            'mandatory' => $request->mandatory,
            'position' => $request->position,
        ]);

        if ($request->exists('dropdownOptions')) {
            foreach ($request->dropdownOptions as $dropdownOption) {
                $newColumn->dropdownOption()->create([
                    'id' => intval(DB::select("select nextval('dropdown_options_id_seq')")['0']->nextval),
                    'column_id' => $nextColId,
                    'position' => $dropdownOption['position'],
                    'name' => $dropdownOption['name'],
                ]);
            }
        }
        DB::statement("UPDATE terms SET properties = properties || '{\"column_$nextColId\": \"\"}'");

        return response($nextColId, 200);
    }

    /**
     * @param Column $column
     * @return Response
     */
    public function show(Column $column): Response
    {
        return response(new ColumnResource($column));
    }

    /**
     * @param Request $request
     * @param Column $column
     * @return Response
     */
    public function update(Request $request, Column $column): Response
    {
        $request->validate([
            'name' => 'required',
            'htmlId' => 'required',
            'sortable' => 'required',
            'filterable' => 'required',
            'elementType' => 'required',
            'mandatory' => 'required',
            'position' => 'required',
        ]);
        $column->update([
            'id' => $request->id,
            'name' => $request->name,
            'html_id' => $request->htmlId,
            'sortable' => $request->sortable,
            'filterable' => $request->filterable,
            'element_type' => $request->elementType,
            'mandatory' => $request->mandatory,
            'position' => $request->position,
        ]);
        if ($request->exists('dropdownOptions')) {
            $column->dropdownOption()->delete();

            foreach ($request->dropdownOptions as $dropdownOption) {
                $newDropdownOption = $column->dropdownOption()->firstOrNew([
                    'column_id' => $column->id,
                    'name' => $dropdownOption['name'],
                    ]);
                $newDropdownOption->id = intval(DB::select("select nextval('dropdown_options_id_seq')")['0']->nextval);
                $newDropdownOption->position = $dropdownOption['position'];
                $newDropdownOption->save();
            }
        }

        return response(new ColumnResource($column), 201);
    }

    /**
     * @param Column $column
     * @return Response
     */
    public function destroy(Column $column):Response
    {
        $column->dropdownOption()->delete();
        $column->delete();
        DB::statement("UPDATE terms SET properties = properties - 'column_$column->id'");

        return response(null, 204);
    }
}
