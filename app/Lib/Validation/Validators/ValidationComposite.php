<?php 

namespace App\Lib\Validation\Validators;

use App\Lib\Presentation\Protocols\Validation;

class ValidationComposite implements Validation 
{
    private array $validations;

    public function __construct(array $validations)
    {
        $this->validations = $validations;
    }

	public function validate(string $field, ?string $value): ?string 
    {
        $error = null;
        foreach ($this->validations as $validation) {
            if($validation->field == $field){
                $error = $validation->validate($value);
                if($error != null && $error != ""){
                    return $error;
                }
            }
        }
        return $error;
	}
}