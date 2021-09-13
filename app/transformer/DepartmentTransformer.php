<?php
namespace transformer;
use Department;
use League\Fractal\TransformerAbstract;
class DepartmentTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'users'
    ];
    public function transform($dept)
    {
        return [
            'id'            => $dept->id,
            'name'         =>  $dept->name,
            'created_at' => $dept->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $dept->updated_at->format('Y-m-d H:i:s')
         ];
    }
    public function includeUsers($dept)
    {
        $rule = $dept->users;
        if($rule){
        return $this->collection($rule, new UserTransformer);
        }
    }
}