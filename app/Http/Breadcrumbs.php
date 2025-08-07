<?php

namespace App\Http;

class Breadcrumbs
{
    protected $crumbs = [];

    public function add(string $title, string $url = null): void
    {
        $this->crumbs[] = (object) [
            'title' => $title,
            'url' => $url,
        ];
    }

    public function get(): array
    {
        return $this->crumbs;
    }

    public static function for(string $name, ...$params): array
    {
        $instance = new static();
        $instance->add('Home', route('home'));

        switch ($name) {
            case 'jobs.index':
                $instance->add('Jobs', route('jobs.index'));
                break;
            case 'jobs.show':
                $job = $params[0];
                $instance->add('Jobs', route('jobs.index'));
                $instance->add($job->title, route('jobs.show', $job));
                break;
            case 'jobs.create':
                $instance->add('Jobs', route('jobs.index'));
                $instance->add('Create', route('jobs.create'));
                break;
            case 'jobs.edit':
                $job = $params[0];
                $instance->add('Jobs', route('jobs.index'));
                $instance->add($job->title, route('jobs.show', $job));
                $instance->add('Edit');
                break;
            // Add cases for companies and categories here...
        }

        return $instance->get();
    }
}
