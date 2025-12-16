<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Sort;

use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Attribute\NestedArray;

trait SortRequestTrait
{
    #[NestedArray(class: SortRequest::class, input: new Query())]
    private ?array $sorts = null;

    public function getSorts(): ?array
    {
        return !empty($this->sorts) ? $this->sorts : null;
    }
}
