<?php

namespace App\Http\Controllers;

use App\Models\FunctionParameter;
use App\Models\FunctionPosition;
use App\Models\SubfunctionDescription;
use App\Models\SubfunctionPosition;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class FunctionPositionController extends Controller
{
    public function index()
    {
        $functionPositions = FunctionPosition::with('subfunctionPositions', 'subfunctionPositions.subfunctionDescriptions', 'subfunctionPositions.functionParameters')->get();

        return response()->json($functionPositions);
    }
    public function tree()
    {
        $functionPositions = FunctionPosition::with([
            'subfunctionPositions.subfunctionDescriptions',
            'subfunctionPositions.functionParameters'
        ])->get();

        $tree = $functionPositions->map(function ($fp) {
            return [
                'expanded' => true,
                'label' => $fp->name,
                'style' => ['borderRadius' => '12px'],
                'children' => $fp->subfunctionPositions->map(function ($sp) use ($fp) {
                    // Build child nodes combining description + matching parameter rows by index.
                    // Assumption: order alignment by array index. If better matching needed, adapt.
                    $descriptions = $sp->subfunctionDescriptions->values();
                    $parameters = $sp->functionParameters->values();

                    $leafNodes = [];
                    $max = max($descriptions->count(), $parameters->count());
                    for ($i = 0; $i < $max; $i++) {
                        $desc = $descriptions->get($i);
                        $param = $parameters->get($i);

                        // We create a node per description (preferred) or per parameter if description missing.
                        $leafNodes[] = [
                            'node' => $sp->name,
                            'label' => $desc ? $desc->description : ($param ? $param->deliverable : ''),
                            'deliverable' => $param->deliverable ?? null,
                            'frequency_deliverable' => $param->frequency_deliverable ?? null,
                            'responsible' => $param->responsible ?? null,
                            'accountable' => $param->accountable ?? null,
                            'support' => $param->support ?? null,
                            'consulted' => $param->consulted ?? null,
                            'informed' => $param->informed ?? null,
                            'className' => 'bg-teal-500 ',
                            'style' => ['borderRadius' => '12px'],
                        ];
                    }

                    return [
                        'expanded' => true,
                        'node' => $fp->name,
                        'label' => $sp->name,
                        'style' => ['borderRadius' => '12px'],
                        'children' => $leafNodes,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json($tree);
    }

    public function flat()
    {
        $functionPositions = FunctionPosition::with([
            'subfunctionPositions.subfunctionDescriptions',
            'subfunctionPositions.functionParameters'
        ])->get();

        $result = [];
        $idCounter = 1;
        foreach ($functionPositions as $fp) {
            $fpId = $idCounter++;
            $result[] = [
                'id' => $fpId,
                'name' => $fp->name,
            ];

            foreach ($fp->subfunctionPositions as $sp) {
                $spId = $idCounter++;
                $result[] = [
                    'id' => $spId,
                    'pid' => $fpId,
                    'name' => $sp->name,
                ];

                $descriptions = $sp->subfunctionDescriptions->values();
                $parameters = $sp->functionParameters->values();
                $max = max($descriptions->count(), $parameters->count());
                for ($i = 0; $i < $max; $i++) {
                    $desc = $descriptions->get($i);
                    $param = $parameters->get($i);
                    $row = [
                        'id' => $idCounter++,
                        'pid' => $spId,
                        'name' => $desc ? $desc->description : ($param ? $param->deliverable : ''),
                    ];
                    if ($param) {
                        $row['deliverable'] = $param->deliverable;
                        $row['frequency_deliverable'] = $param->frequency_deliverable;
                        $row['responsible'] = $param->responsible;
                        $row['accountable'] = $param->accountable;
                        $row['support'] = $param->support;
                        $row['consulted'] = $param->consulted;
                        $row['informed'] = $param->informed;
                    }
                    $result[] = $row;
                }
            }
        }
        return response()->json($result);
    }
    /**
     * Return nested structure: label, subfunction, description arrays.
     */
    public function nested()
    {
        $customOrder = [1, 9, 11, 5, 12, 6, 7, 8, 10, 3, 4, 2];
        $functionPositions = FunctionPosition::with([
            'subfunctionPositions.subfunctionDescriptions',
            'subfunctionPositions.functionParameters'
        ])
        ->orderByRaw('CASE WHEN id IN (' . implode(',', $customOrder) . ') THEN FIELD(id, ' . implode(',', $customOrder) . ') ELSE 999999 END')
        ->get();

        $result = $functionPositions->map(function ($fp) {
            return [
                'id' => $fp->id,
                'label' => $fp->name,
                'subfunction' => $fp->subfunctionPositions->map(function ($sp) use ($fp) {
                    $descriptions = $sp->subfunctionDescriptions->values();
                    $parameters = $sp->functionParameters->values();
                    $max = max($descriptions->count(), $parameters->count());
                    $descArr = [];
                    for ($i = 0; $i < $max; $i++) {
                        $desc = $descriptions->get($i);
                        $param = $parameters->get($i);
                        $descArr[] = [
                            'descriptionId' => $param->id ?? null,
                            'function' => $fp->name,
                            'subfunction' => $sp->name,
                            'label' => $desc ? $desc->description : ($param ? $param->deliverable : ''),
                            'deliverable' => $param->deliverable ?? null,
                            'frequency_deliverable' => $param->frequency_deliverable ?? null,
                            'responsible' => $param->responsible ?? null,
                            'accountable' => $param->accountable ?? null,
                            'support' => $param->support ?? null,
                            'consulted' => $param->consulted ?? null,
                            'informed' => $param->informed ?? null,
                            'updated_at' => $desc && $desc->updated_at ? $desc->updated_at->format('F j, Y \a\t H:i:s') : null,
                        ];
                    }
                    return [
                        'label' => $sp->name,
                        'id' => $fp->id ?? null,
                        'subfunction_id' => $sp->id,
                        'description' => $descArr,
                    ];
                })->values(),
            ];
        })->values();
        return response()->json($result);
    }

    public function getFunctionById($id)
    {
        $function = FunctionPosition::with([
            'subfunctionPositions'
        ])->find($id);

        $result = [
            'functionId' => $function->id,
            'function' => $function->name,
            'subfunctions' => $function->subfunctionPositions->map(function ($sp) {
                return [
                    'id' => $sp->id,
                    'subfunction' => $sp->name,
                    'descriptions' => $sp->subfunctionDescriptions->map(function ($desc) {
                        return [
                            'id' => $desc->id,
                            'description' => $desc->description,
                        ];
                    })->values(),
                ];
            })->values(),
        ];

        return response()->json($result);
    }

    public function getSubFunctionById($id)
    {
        $subfunction = SubfunctionPosition::with([
            'subfunctionDescriptions',
            'functionPosition'
        ])->find($id);

        $result = [
            'functionId' => $subfunction->functionPosition?->id,
            'subfunctionId' => $subfunction->id,
            'function' => $subfunction->functionPosition?->name,
            'subfunction' => $subfunction->name,
            'descriptions' => $subfunction->subfunctionDescriptions->map(function ($desc) {
                return [
                    'id' => $desc->id,
                    'description' => $desc->description,
                ];
            })->values(),
        ];

        return response()->json($result);
    }

    public function manageFunction(Request $request)
    {
        $function = FunctionPosition::find($request->functionId);

        if (!$function) {
            $function = new FunctionPosition;
        }

        $function->name = $request->function;
        $function->save();

        $payloadSubfunctionIds = collect($request->subfunctions)->pluck('id')->filter()->all();

        $function->subfunctionPositions()->whereNotIn('id', $payloadSubfunctionIds)->delete();

        foreach ($request->subfunctions as $subfunc) {
            $subfunction = SubfunctionPosition::find($subfunc['id']);
            if ($subfunction === null) {
                $subfunction = new SubfunctionPosition;
                $subfunction->function_position_id = $function->id;
            }
            $subfunction->name = $subfunc['subfunction'];
            $subfunction->save();

            $payloadDescIds = collect($subfunc['descriptions'])->pluck('id')->filter()->all();

            $subfunction->subfunctionDescriptions()->whereNotIn('id', $payloadDescIds)->delete();

            foreach ($subfunc['descriptions'] as $subDesc) {
                $subDescription = SubfunctionDescription::find($subDesc['id']);
                if ($subDescription === null) {
                    $subDescription = new SubfunctionDescription;
                    $subDescription->subfunction_position_id = $subfunction->id;
                }
                $subDescription->description = $subDesc['description'];
                $subDescription->save();
            }
        }

        return response()->json(['message' => 'Function and Subfunctions saved successfully.']);
    }

    public function getDescriptionById($id)
    {
        $functionParameters = FunctionParameter::find($id);

        if (!$functionParameters) {
            return response()->json(['message' => 'Function Parameter not found.'], 404);
        }

        return response()->json($functionParameters);
    }

    public function manageDescription(Request $request)
    {
        $functionParameter = $request->id ? FunctionParameter::find($request->id) : new FunctionParameter;

        if (isEmpty($functionParameter)) {
            $functionParameter->subfunction_position_id = $request->subfunctionId;
        }

        $functionParameter->deliverable = $request->deliverable;
        $functionParameter->frequency_deliverable = $request->frequency_deliverable;
        $functionParameter->responsible = $request->responsible;
        $functionParameter->accountable = $request->accountable;
        $functionParameter->support = $request->support;
        $functionParameter->consulted = $request->consulted;
        $functionParameter->informed = $request->informed;

        $functionParameter->save();

        return response()->json(['message' => 'Function Description saved successfully.']);
    }

    public function deleteFunction(Request $request)
    {
        if ($request->type === 'function') {
            $function = FunctionPosition::find($request->id);
            if ($function) {
                $function->subfunctionPositions()->each(function ($subfunc) {
                    $subfunc->subfunctionDescriptions()->delete();
                    $subfunc->functionParameters()->delete();
                });
                $function->subfunctionPositions()->delete();
                $function->delete();
                return response()->json(['message' => 'Function and its related subfunctions and descriptions deleted successfully.']);
            } else {
                return response()->json(['message' => 'Function not found.'], 404);
            }
        } else {
            $subfunction = SubfunctionPosition::find($request->id);
            if ($subfunction) {
                $subfunction->subfunctionDescriptions()->delete();
                $subfunction->functionParameters()->delete();
                $subfunction->delete();
                return response()->json(['message' => 'Subfunction and its related descriptions deleted successfully.']);
            } else {
                return response()->json(['message' => 'Subfunction not found.'], 404);
            }
        }
    }
}
