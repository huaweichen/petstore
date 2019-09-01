<?php

namespace App\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class PetSerializer extends ArraySerializer {
    /**
     * Rewrite collection function to remove 'data' key.
     *
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        return $data;
    }
}
