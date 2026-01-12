<?php


namespace App\BFF\Mobile\V1\Resources;

use App\BFF\Shared\DTOs\ProductDTO;
use \Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 *
 * @mixin ProductDTO
 *  que gano utilizando el mixin ? una simplificacion, ejemplo:
 * $this->id == $this->id,
 * $this->id == $this->JsonResource->id,
 * $this->id == $this->ProductDTO->id,
 *
 *   $this->id, este id se va a buscar en el siguiente ordern
 *
 *     1) ProductResource, ( si existiera la propiedad publica, public int id )
 *     2) JsonResource, si la clase padre ( si existiera la propiedad publica, public int id )
 *     3) ProductDTO, si la clase ProductDTO ( si existiera la propiedad publica, public int id )
 *
 *  Entonces,  a quien corresponde el valor de $this->id ? La primera clase que lo tenga, siempre se recorre en el orden establecido
 *  [ProductResource,JsonResource,ProductDTO]
 *
 */
class ProductResource extends JsonResource
{


    public function __construct($resource)
    {
        self::withoutWrapping();
        //con  self::withoutWrapping(); elimina el arreglo data, solo esta definido para ese nombre


        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => [
                'value' => $this->price,
                'formatted' => "e{$this->price}",
            ],
            'inStock' => $this->stock > 0,
            'category' => $this->category->name,
        ];
    }
}
