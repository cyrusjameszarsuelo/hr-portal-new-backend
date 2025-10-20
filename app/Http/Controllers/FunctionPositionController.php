<?php

namespace App\Http\Controllers;

use App\Models\FunctionParameter;
use App\Models\FunctionPosition;
use App\Models\SubfunctionDescription;
use App\Models\SubfunctionPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// removed accidental import of PHPUnit isEmpty helper; use model exists() checks instead

class FunctionPositionController extends Controller
{
    /**
     * Return nested structure: label, subfunction, description arrays.
     */
    public function nested()
    {
        $functionPositions = FunctionPosition::with([
            'subfunctionPositions' => function ($q) {
                $q->orderBy('order_id');
            },
            'subfunctionPositions.subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            },
            'subfunctionPositions.functionParameters',
        ])->orderBy('order_id')->get();

        $result = $functionPositions->map(function ($fp) {
            return $this->buildNestedForFunction($fp);
        })->values();
        return response()->json($result);
    }

    public function getFunctionById($id)
    {
        $function = FunctionPosition::with([
            'subfunctionPositions' => function ($q) {
                $q->orderBy('order_id');
            },
            'subfunctionPositions.subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            }
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
            'subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            },
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

    /**
     * Reorder subfunctions for a given parent (function position).
     * Expects payload: { parent_id: <function_position_id>, ordered_ids: [<subfunction_id>, ...] }
     */
    public function reorderSubfunctions(Request $request)
    {
        $payload = $request->only(['parent_id', 'ordered_ids']);

        if (!isset($payload['parent_id']) || !is_array($payload['ordered_ids'])) {
            return response()->json(['message' => 'Invalid payload. expected parent_id and ordered_ids array.'], 400);
        }

        $parentId = $payload['parent_id'];
        $ordered = $payload['ordered_ids'];
        $user_id = $request['user_id'];

        DB::transaction(function () use ($parentId, $ordered, $user_id) {
            foreach ($ordered as $index => $subId) {
                $sp = SubfunctionPosition::where('id', $subId)
                    ->where('function_position_id', $parentId)
                    ->first();
                if ($sp) {
                    $old = $sp->toArray();
                    $sp->order_id = $index + 1;
                    $sp->save();
                    auditLog('SubfunctionPosition', 'edit', $old, $sp->toArray(), $user_id);
                }
            }
        });

        // return the nested data for the parent function (ordered)
        $function = FunctionPosition::with([
            'subfunctionPositions' => function ($q) {
                $q->orderBy('order_id');
            },
            'subfunctionPositions.subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            },
            'subfunctionPositions.functionParameters' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('id');
            },
        ])->find($parentId);

        if (!$function) {
            return response()->json(['message' => 'Function not found.'], 404);
        }

        // reuse nested builder to avoid duplication and handle deduplication
        return response()->json($this->buildNestedForFunction($function));
    }

    /**
     * Reorder descriptions for a given subfunction (parent_id is subfunction_position_id).
     * Expects payload: { parent_id: <subfunction_position_id>, ordered_ids: [<description_id>, ...] }
     */
    public function reorderDescriptions(Request $request)
    {
        $payload = $request->only(['parent_id', 'ordered_ids']);

        if (!isset($payload['parent_id']) || !is_array($payload['ordered_ids'])) {
            return response()->json(['message' => 'Invalid payload. expected parent_id and ordered_ids array.'], 400);
        }

        $parentId = $payload['parent_id'];
        $ordered = $payload['ordered_ids'];
        $user_id = $request['user_id'];

        DB::transaction(function () use ($parentId, $ordered, $user_id) {
            foreach ($ordered as $index => $descId) {
                $desc = SubfunctionDescription::where('id', $descId)
                    ->where('subfunction_position_id', $parentId)
                    ->first();
                if ($desc) {
                    $old = $desc->toArray();
                    $desc->order_id = $index + 1;
                    $desc->save();
                    auditLog('SubfunctionDescription', 'edit', $old, $desc->toArray(), $user_id);
                }
            }
        });

        // fetch the function position id for this subfunction to return nested structure
        $subfunction = SubfunctionPosition::with('functionPosition')->find($parentId);
        if (!$subfunction) {
            return response()->json(['message' => 'Subfunction not found.'], 404);
        }

        $function = FunctionPosition::with([
            'subfunctionPositions' => function ($q) {
                $q->orderBy('order_id');
            },
            'subfunctionPositions.subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            },
            'subfunctionPositions.functionParameters' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('id');
            },
        ])->find($subfunction->function_position_id);

        if (!$function) {
            return response()->json(['message' => 'Function not found.'], 404);
        }

        return response()->json($this->buildNestedForFunction($function));
    }

    /**
     * Reorder functions (top-level FunctionPosition records).
     * Expects payload: { ordered_ids: [<function_position_id>, ...] }
     */
    public function reorderFunctions(Request $request)
    {
        $payload = $request->only(['ordered_ids']);

        if (!is_array($payload['ordered_ids'] ?? null)) {
            return response()->json(['message' => 'Invalid payload. expected ordered_ids array.'], 400);
        }

        $ordered = $payload['ordered_ids'];
        $user_id = $request['user_id'];

        DB::transaction(function () use ($ordered, $user_id) {
            foreach ($ordered as $index => $funcId) {
                $fp = FunctionPosition::where('id', $funcId)->first();
                if ($fp) {
                    $old = $fp->toArray();
                    $fp->order_id = $index + 1;
                    $fp->save();
                    auditLog('FunctionPosition', 'edit', $old, $fp->toArray(), $user_id);
                }
            }
        });

        // return the full nested data (ordered)
        $functions = FunctionPosition::with([
            'subfunctionPositions' => function ($q) {
                $q->orderBy('order_id');
            },
            'subfunctionPositions.subfunctionDescriptions' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('order_id');
            },
            'subfunctionPositions.functionParameters' => function ($q) {
                $q->whereNull('deleted_at')->orderBy('id');
            },
        ])->orderBy('order_id')->get();

        $result = $functions->map(function ($fp) {
            return $this->buildNestedForFunction($fp);
        })->values();

        return response()->json($result);
    }

    /**
     * Build nested structure for a FunctionPosition and remove duplicate description rows.
     * Duplicate detection uses the label + deliverable combination.
     */
    private function buildNestedForFunction(FunctionPosition $fp)
    {
        return [
            'id' => $fp->id,
            'label' => $fp->name,
            'forder_id' => $fp->order_id,
            'subfunction' => $fp->subfunctionPositions->map(function ($sp) use ($fp) {
                $descriptions = $sp->subfunctionDescriptions->values();
                $parameters = $sp->functionParameters->values();
                $max = $descriptions->count();

                $seen = [];
                $descArr = [];
                for ($i = 0; $i < $max; $i++) {
                    $desc = $descriptions->get($i);
                    $param = $parameters->get($i);
                    $label = $desc ? $desc->description : ($param ? $param->deliverable : '');
                    $deliverable = $param->deliverable ?? null;
                    $key = md5($label . '|' . ($deliverable ?? ''));
                    if (isset($seen[$key])) {
                        continue; // skip duplicate
                    }
                    $seen[$key] = true;

                    $descArr[] = [
                        'paramId' => $param->id ?? null,
                        'descriptionId' => $desc->id ?? null,
                        'dorder_id' => $desc->order_id ?? null,
                        'function' => $fp->name,
                        'subfunction' => $sp->name,
                        'label' => $label,
                        'deliverable' => $deliverable,
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
                    'sporder_id' => $sp->order_id,
                    'description' => $descArr,
                ];
            })->values(),
        ];
    }

    public function manageFunction(Request $request)
    {
        $function = FunctionPosition::find($request->functionId);

        $oldFunction = null;
        if (!$function) {
            $function = new FunctionPosition;
            $lastOrder = FunctionPosition::max('order_id');
            $function->order_id = ($lastOrder ? intval($lastOrder) : 0) + 1;
        }

        $oldFunction = $function->exists ? $function->toArray() : null;
        $function->name = $request->function;
        $function->save();
        auditLog('FunctionPosition', $oldFunction ? 'edit' : 'create', $oldFunction, $function->toArray(), $request['user_id']);

        $payloadSubfunctionIds = collect($request->subfunctions)->pluck('id')->filter()->all();

        $function->subfunctionPositions()->whereNotIn('id', $payloadSubfunctionIds)->delete();

        foreach ($request->subfunctions as $subfunc) {
            $subfunction = SubfunctionPosition::find($subfunc['id']);
            if ($subfunction === null) {
                $subfunction = new SubfunctionPosition;
                $subfunction->function_position_id = $function->id;
                $lastSpOrder = SubfunctionPosition::where('function_position_id', $function->id)->max('order_id');
                $subfunction->order_id = ($lastSpOrder ? intval($lastSpOrder) : 0) + 1;
            }
            $oldSp = $subfunction->exists ? $subfunction->toArray() : null;
            $subfunction->name = $subfunc['subfunction'];
            $subfunction->save();
            auditLog('SubfunctionPosition', $oldSp ? 'edit' : 'create', $oldSp, $subfunction->toArray(), $request['user_id']);

            $payloadDescIds = collect($subfunc['descriptions'])->pluck('id')->filter()->all();

            $subfunction->subfunctionDescriptions()->whereNotIn('id', $payloadDescIds)->delete();

            foreach ($subfunc['descriptions'] as $subDesc) {
                $subDescription = SubfunctionDescription::find($subDesc['id']);
                if ($subDescription === null) {
                    $subDescription = new SubfunctionDescription;
                    $subDescription->subfunction_position_id = $subfunction->id;
                    // assign order_id as last + 1 when creating a new description under this subfunction
                    $lastDescOrder = SubfunctionDescription::where('subfunction_position_id', $subfunction->id)->max('order_id');
                    $subDescription->order_id = ($lastDescOrder ? intval($lastDescOrder) : 0) + 1;
                }
                $oldDesc = $subDescription->exists ? $subDescription->toArray() : null;
                $subDescription->description = $subDesc['description'];
                $subDescription->save();
                auditLog('SubfunctionDescription', $oldDesc ? 'edit' : 'create', $oldDesc, $subDescription->toArray(), $request['user_id']);
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

        if (!$functionParameter->exists) {
            $functionParameter->subfunction_position_id = $request->subfunctionId;
        }

        // initialize old param for audit logging
        $oldParam = $functionParameter->exists ? $functionParameter->toArray() : null;

        $functionParameter->deliverable = $request->deliverable;
        $functionParameter->frequency_deliverable = $request->frequency_deliverable;
        $functionParameter->responsible = $request->responsible;
        $functionParameter->accountable = $request->accountable;
        $functionParameter->support = $request->support;
        $functionParameter->consulted = $request->consulted;
        $functionParameter->informed = $request->informed;

        $functionParameter->save();

        auditLog('FunctionParameter', $oldParam ? 'edit' : 'create', $oldParam, $functionParameter->toArray(), $request['user_id']);

        return response()->json(['message' => 'Function Description saved successfully.']);
    }

    public function deleteFunction(Request $request)
    {

        $user_id = $request['user_id'];

        if ($request->type === 'function') {
            $function = FunctionPosition::find($request->id);
            if ($function) {
                $oldFunc = $function->toArray();
                $function->subfunctionPositions()->each(function ($subfunc) use ($user_id) {
                    $subfunc->subfunctionDescriptions()->each(function ($desc) use ($user_id) {
                        $old = $desc->toArray();
                        $desc->delete();
                        auditLog('SubfunctionDescription', 'delete', $old, null, $user_id);
                    });
                    $subfunc->functionParameters()->each(function ($param) use ($user_id) {
                        $old = $param->toArray();
                        $param->delete();
                        auditLog('FunctionParameter', 'delete', $old, null, $user_id);
                    });
                    $oldSub = $subfunc->toArray();
                    $subfunc->delete();
                    auditLog('SubfunctionPosition', 'delete', $oldSub, null, $user_id);
                });
                $function->delete();
                auditLog('FunctionPosition', 'delete', $oldFunc, null, $user_id);
                return response()->json(['message' => 'Function and its related subfunctions and descriptions deleted successfully.']);
            } else {
                return response()->json(['message' => 'Function not found.'], 404);
            }
        } else {
            $subfunction = SubfunctionPosition::find($request->id);
            if ($subfunction) {
                $subfunction->subfunctionDescriptions()->each(function ($desc) use ($user_id) {
                    $old = $desc->toArray();
                    $desc->delete();
                    auditLog('SubfunctionDescription', 'delete', $old, null, $user_id);
                });
                $subfunction->functionParameters()->each(function ($param) use ($user_id) {
                    $old = $param->toArray();
                    $param->delete();
                    auditLog('FunctionParameter', 'delete', $old, null, $user_id);
                });
                $oldSub = $subfunction->toArray();
                $subfunction->delete();
                auditLog('SubfunctionPosition', 'delete', $oldSub, null, $user_id);
                return response()->json(['message' => 'Subfunction and its related descriptions deleted successfully.']);
            } else {
                return response()->json(['message' => 'Subfunction not found.'], 404);
            }
        }
    }
}
