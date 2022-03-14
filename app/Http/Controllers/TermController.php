<?php

namespace App\Http\Controllers;

use App\Http\Resources\TermResourse;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TermController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return response(TermResourse::collection(Term::all()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'properties' => 'required'
        ]);

        $termSeq = DB::select("select nextval('term_seq')");
        $termId = intval($termSeq['0']->nextval);

        $newColumn = Term::create([
            'id' => $termId,
            'properties' => $request->properties,
        ]);

        return response($newColumn, 200);
    }

    /**
     * @param Term $term
     * @return Response
     */
    public function show(Term $term): Response
    {
        return response(new TermResourse($term), 200);
    }

    /**
     * @param Request $request
     * @param Term $term
     * @return Response
     */
    public function update(Request $request, Term $term): Response
    {
        $request->validate([
            'properties' => 'required'
        ]);

        $term->update($request->toArray());

        return response(new TermResourse($term), 201);

    }

    /**
     * @param Term $term
     * @return Response
     */
    public function destroy(Term $term): Response
    {
        $term->delete();

        return response(null, 204);
    }
}
