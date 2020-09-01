<?php

namespace Edalzell\Blade\Directives;

use Statamic\Facades\Antlers;
use Statamic\Support\Arr;
use Statamic\Tags\Glide as GlideTag;

class Glide
{
    public function handle(string $path, array $params = [])
    {
        $tag = (new GlideTag)
            ->setParser(Antlers::parser())
            ->setContext([])
            ->setParameters($params);
        $data = $tag->generate($path);

        return $data[0];
    }

    private function filter()
    {
        if ($where = Arr::get($this->params, 'where')) {
            foreach (explode(',', $where) as $condition) {
                list($field, $value) = explode(':', $condition);

                $this->collectionQuery->where(trim($field), trim($value));
            }
        }
    }

    private function limit()
    {
        if ($limit = Arr::get($this->params, 'limit')) {
            $this->collectionQuery->limit($limit);
        }
    }

    private function orderBy()
    {
        if ($orderBy = Arr::get($this->params, 'orderBy')) {
            $sort = explode(':', $orderBy);
            $field = $sort[0];
            $direction = $sort[1] ?? 'asc';

            $this->collectionQuery->orderBy($field, $direction);
        }
    }
}
